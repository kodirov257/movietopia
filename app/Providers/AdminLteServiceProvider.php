<?php

namespace App\Providers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Route;
use JeroenNoten\LaravelAdminLte\AdminLteServiceProvider as BaseServiceProvider;
use JeroenNoten\LaravelAdminLte\Console\AdminLteInstallCommand;
use JeroenNoten\LaravelAdminLte\Console\AdminLtePluginCommand;
use JeroenNoten\LaravelAdminLte\Console\AdminLteStatusCommand;
use JeroenNoten\LaravelAdminLte\Console\AdminLteUpdateCommand;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use JeroenNoten\LaravelAdminLte\Http\ViewComposers\AdminLteComposer;

class AdminLteServiceProvider extends BaseServiceProvider
{
    public function __construct($app)
    {
        parent::__construct($app);
        $this->pkgPrefix = 'admin';
    }

    public function register(): void
    {
        parent::register();

        // Bind a singleton instance of the AdminLte class into the service
        // container.
    }

    public function boot(Factory $view, Dispatcher $events, Repository $config): void
    {
        $this->loadViews();
        $this->loadTranslations();
        $this->loadConfig();
//        $this->registerCommands();
        $this->registerViewComposers($view);
//        $this->registerMenu($events, $config);
        $this->loadComponents();
        $this->loadRoutes();
    }

    private function loadViews(): void
    {
        $viewsPath = $this->packagePath('../resources/views');
        $this->loadViewsFrom($viewsPath, $this->pkgPrefix);
    }

    private function loadTranslations(): void
    {
        $translationsPath = $this->packagePath('../resources/lang');
        $this->loadTranslationsFrom($translationsPath, $this->pkgPrefix);
    }

    private function loadConfig(): void
    {
        $configPath = $this->packagePath('../config/adminlte.php');
        $this->mergeConfigFrom($configPath, $this->pkgPrefix);
    }

    private function packagePath(string $path): string
    {
        return __DIR__."/../$path";
    }

    private function registerCommands(): void
    {
        $this->commands([
            AdminLteInstallCommand::class,
            AdminLteStatusCommand::class,
            AdminLteUpdateCommand::class,
            AdminLtePluginCommand::class,
        ]);
    }

    private function registerViewComposers(Factory $view): void
    {
        $view->composer('layouts.admin.page', AdminLteComposer::class);
    }

    private static function registerMenu(Dispatcher $events, Repository $config): void
    {
        // Register a handler for the BuildingMenu event, this handler will add
        // the menu defined on the config file to the menu builder instance.

        $events->listen(
            BuildingMenu::class,
            function (BuildingMenu $event) use ($config) {
                $menu = $config->get('adminlte.menu', []);
                $menu = is_array($menu) ? $menu : [];
                $event->menu->add(...$menu);
            }
        );
    }

    private function loadComponents(): void
    {
        // Support of x-components is only available for Laravel >= 7.x
        // versions. So, we check if we can load components.

        $canLoadComponents = method_exists(
            'Illuminate\Support\ServiceProvider',
            'loadViewComponentsAs'
        );

        if (! $canLoadComponents) {
            return;
        }

        // Load all the blade-x components.

        $components = array_merge(
            $this->layoutComponents,
            $this->formComponents,
            $this->toolComponents,
            $this->widgetComponents
        );

        $this->loadViewComponentsAs($this->pkgPrefix, $components);
    }

    private function loadRoutes(): void
    {
        $routesCfg = [
            'as' => "{$this->pkgPrefix}.",
            'prefix' => $this->pkgPrefix,
            'middleware' => ['web'],
        ];

        Route::group($routesCfg, function () {
            $routesPath = $this->packagePath('../routes/web.php');
            $this->loadRoutesFrom($routesPath);
        });
    }
}
