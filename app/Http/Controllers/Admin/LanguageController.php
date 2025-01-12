<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Languages\CreateRequest;
use App\Http\Requests\Admin\Languages\UpdateRequest;
use App\Models\Language;
use App\Services\Manage\LanguageService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LanguageController extends Controller
{
    private LanguageService $service;

    public function __construct(LanguageService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $query = Language::orderByDesc('updated_at');

        if (!empty($value = $request->get('name'))) {
            $query->where(function (Builder $query) use ($value) {
                $query->where('name_uz', 'ilike', '%' . $value . '%')
                    ->orWhere('name_uz_cy', 'ilike', '%' . $value . '%')
                    ->orWhere('name_ru', 'ilike', '%' . $value . '%')
                    ->orWhere('name_en', 'ilike', '%' . $value . '%');
            });
        }

        $languages = $query->paginate(20)->appends('name', $request->get('name'));

        return view('admin.languages.index', compact('languages'));
    }

    public function create(): View
    {
        return view('admin.languages.create');
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        $genre = $this->service->create($request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.languages.show', $genre);
    }

    public function show(Language $language): View
    {
        return view('admin.languages.show', compact('language'));
    }

    public function edit(Language $language): View
    {
        return view('admin.languages.edit', compact('language'));
    }

    public function update(UpdateRequest $request, Language $language): RedirectResponse
    {
        $this->service->update($language->id, $request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.languages.show', $language);
    }

    public function destroy(Language $language): RedirectResponse
    {
        if ($language->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.languages.index');
        }

        try {
            $language->delete();

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.languages.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
