<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use JeroenNoten\LaravelAdminLte\AdminLte;
use JeroenNoten\LaravelAdminLte\AdminLteServiceProvider as BaseServiceProvider;
use JeroenNoten\LaravelAdminLte\Console\AdminLteInstallCommand;
use JeroenNoten\LaravelAdminLte\Console\AdminLtePluginCommand;
use JeroenNoten\LaravelAdminLte\Console\AdminLteRemoveCommand;
use JeroenNoten\LaravelAdminLte\Console\AdminLteStatusCommand;
use JeroenNoten\LaravelAdminLte\Console\AdminLteUpdateCommand;

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

    public function boot(): void
    {
        $this->loadViews();
        $this->loadTranslations();
        $this->loadConfig();
        $this->registerCommands();
        $this->registerViewComposers();
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
        if ($this->app->runningInConsole()) {
            $this->commands([
                AdminLteInstallCommand::class,
                AdminLtePluginCommand::class,
                AdminLteRemoveCommand::class,
                AdminLteStatusCommand::class,
                AdminLteUpdateCommand::class,
            ]);
        }
    }

    private function registerViewComposers(): void
    {
        View::composer('layouts.admin.page', function (\Illuminate\View\View $v) {
            $v->with('adminlte', $this->app->make(AdminLte::class));
        });
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
