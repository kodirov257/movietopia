<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Positions\CreateRequest;
use App\Http\Requests\Admin\Positions\UpdateRequest;
use App\Models\Position;
use App\Services\Manage\PositionService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PositionController extends Controller
{
    private PositionService $service;

    public function __construct(PositionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $query = Position::orderByDesc('updated_at');

        if (!empty($value = $request->get('name'))) {
            $query->where(function (Builder $query) use ($value) {
                $query->where('name_uz', 'ilike', '%' . $value . '%')
                    ->orWhere('name_uz_cy', 'ilike', '%' . $value . '%')
                    ->orWhere('name_ru', 'ilike', '%' . $value . '%')
                    ->orWhere('name_en', 'ilike', '%' . $value . '%');
            });
        }

        $positions = $query->paginate(20)->appends('name', $request->get('name'));

        return view('admin.positions.index', compact('positions'));
    }

    public function create(): View
    {
        return view('admin.positions.create');
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        $genre = $this->service->create($request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.positions.show', $genre);
    }

    public function show(Position $position): View
    {
        return view('admin.positions.show', compact('position'));
    }

    public function edit(Position $position): View
    {
        return view('admin.positions.edit', compact('position'));
    }

    public function update(UpdateRequest $request, Position $position): RedirectResponse
    {
        $this->service->update($position->id, $request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.positions.show', $position);
    }

    public function destroy(Position $position): RedirectResponse
    {
        if ($position->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.positions.index');
        }

        try {
            $position->delete();

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.positions.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
