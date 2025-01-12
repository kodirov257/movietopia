<?php

namespace App\Http\Controllers\Admin\Film;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Film\GoofTypes\CreateRequest;
use App\Http\Requests\Admin\Film\GoofTypes\UpdateRequest;
use App\Models\Film\GoofType;
use App\Services\Manage\Film\GoofTypeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GoofTypeController extends Controller
{
    private GoofTypeService $service;

    public function __construct(GoofTypeService $service)
    {
        $this->service = $service;
    }

    public function index(): View
    {
        $query = GoofType::orderByDesc('updated_at');

        $goofType = $query->get();

        return view('admin.film.goof-types.index', compact('goofType'));
    }

    public function create(): View
    {
        return view('admin.film.goof-types.create');
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        $goofType = $this->service->create($request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.goof-types.show', $goofType);
    }

    public function show(GoofType $goofType): View
    {
        return view('admin.film.goof-types.show', compact('goofType'));
    }

    public function edit(GoofType $goofType): View
    {
        return view('admin.film.goof-types.edit', compact('goofType'));
    }

    public function update(UpdateRequest $request, GoofType $goofType): RedirectResponse
    {
        $this->service->update($goofType->id, $request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.goof-types.show', $goofType);
    }

    public function destroy(GoofType $goofType): RedirectResponse
    {
        if ($goofType->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.goof-types.index');
        }

        try {
            $goofType->delete();

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.goof-types.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(GoofType $goofType)
    {
        try {
            $this->service->moveToFirst($goofType->id);
            return redirect()->route('dashboard.goof-types.index');
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(GoofType $goofType)
    {
        try {
            $this->service->moveUp($goofType->id);
            return redirect()->route('dashboard.goof-types.index');
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(GoofType $goofType)
    {
        try {
            $this->service->moveDown($goofType->id);
            return redirect()->route('dashboard.goof-types.index');
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(GoofType $goofType)
    {
        try {
            $this->service->moveToLast($goofType->id);
            return redirect()->route('dashboard.goof-types.index');
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
