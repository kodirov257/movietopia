<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Companies\CreateRequest;
use App\Http\Requests\Admin\Companies\UpdateRequest;
use App\Models\Company;
use App\Models\Country;
use App\Services\Manage\CompanyService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CompanyController extends Controller
{
    private CompanyService $service;

    public function __construct(CompanyService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $query = Company::orderByDesc('updated_at');

        if (!empty($value = $request->get('name'))) {
            $query->where(function (Builder $query) use ($value) {
                $query->where('name_uz', 'ilike', '%' . $value . '%')
                    ->orWhere('name_uz_cy', 'ilike', '%' . $value . '%')
                    ->orWhere('name_ru', 'ilike', '%' . $value . '%')
                    ->orWhere('name_en', 'ilike', '%' . $value . '%');
            });
        }

        $companies = $query->paginate(20)->appends('name', $request->get('name'));

        return view('admin.companies.index', compact('companies'));
    }

    public function create(): View
    {
        return view('admin.companies.create');
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        $company = $this->service->create($request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.companies.show', $company);
    }

    public function show(Company $company): View
    {
        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company): View
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(UpdateRequest $request, Company $company): RedirectResponse
    {
        $this->service->update($company->id, $request);
        session()->flash('message', 'запись обновлён ');
        return redirect()->route('dashboard.companies.show', $company);
    }

    public function destroy(Company $company): RedirectResponse
    {
        if ($company->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.companies.index');
        }

        try {
            $company->delete();

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.companies.index');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
