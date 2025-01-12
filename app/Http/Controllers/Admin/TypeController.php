<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Types\CreateRequest;
use App\Http\Requests\Admin\Types\UpdateRequest;
use App\Models\Type;
use App\Services\Manage\TypeService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TypeController extends Controller
{
    public function __construct(private readonly TypeService $service)
    {
    }

    public function index(Request $request): View
    {
        $query = Type::orderByDesc('updated_at');

        if (!empty($value = $request->get('name'))) {
            $query->where(function (Builder $query) use ($value) {
                $query->where('name_uz', 'ilike', '%' . $value . '%')
                    ->orWhere('name_uz_cy', 'ilike', '%' . $value . '%')
                    ->orWhere('name_ru', 'ilike', '%' . $value . '%')
                    ->orWhere('name_en', 'ilike', '%' . $value . '%');
            });
        }

        $types = $query->paginate(20)->appends('name', $request->get('name'));

        return view('admin.types.index', compact('types'));
    }

    public function create(): View
    {
        return view('admin.types.create');
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        $type = $this->service->create($request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.types.show', $type);
    }

    public function show(Type $type): View
    {
        return view('admin.types.show', compact('type'));
    }

    public function edit(Type $type): View
    {
        return view('admin.types.edit', compact('type'));
    }

    public function update(UpdateRequest $request, Type $type): RedirectResponse
    {
        $this->service->update($type->id, $request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.types.show', $type);
    }

    public function destroy(Type $type): RedirectResponse
    {
        if ($type->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {

            return redirect()->route('dashboard.types.index');
        }

        try {
            $type->delete();

            session()->flash('message', 'запись обновлён ');

            return redirect()->route('dashboard.types.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
