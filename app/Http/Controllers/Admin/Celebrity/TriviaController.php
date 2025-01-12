<?php

namespace App\Http\Controllers\Admin\Celebrity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Celebrity\Trivias\CreateRequest;
use App\Http\Requests\Admin\Celebrity\Trivias\UpdateRequest;
use App\Models\Celebrity\Celebrity;
use App\Models\Celebrity\Trivia;
use App\Services\Manage\Celebrity\TriviaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TriviaController extends Controller
{
    private TriviaService $service;

    public function __construct(TriviaService $service)
    {
        $this->service = $service;
    }

    public function create(Celebrity $celebrity): View
    {
        return view('admin.celebrity.trivias.create', compact('celebrity'));
    }

    public function store(CreateRequest $request, Celebrity $celebrity): RedirectResponse
    {
        try {
            $company = $this->service->addTrivia($celebrity->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.trivias.show', $company);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Celebrity $celebrity, Trivia $trivia): View
    {
        return view('admin.celebrity.trivias.show', compact('celebrity', 'trivia'));
    }

    public function edit(Celebrity $celebrity, Trivia $trivia): View
    {
        return view('admin.celebrity.trivias.edit', compact('celebrity', 'trivia'));
    }

    public function update(UpdateRequest $request, Celebrity $celebrity, Trivia $trivia): RedirectResponse
    {
        try {
            $this->service->updateTrivia($celebrity->id, $trivia->id, $request);
            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.trivias.show', ['celebrity' => $celebrity, 'trivia' => $trivia]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Celebrity $celebrity, Trivia $trivia): RedirectResponse
    {
        if ($trivia->created_by !== Auth::user()->id && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        }

        try {
            $trivia->delete();

            session()->flash('message', 'запись обновлён ');
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function first(Celebrity $celebrity, Trivia $trivia) {

        try {
            $this->service->moveTriviaToFirst($celebrity->id, $trivia->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function up(Celebrity $celebrity, Trivia $trivia) {

        try {
            $this->service->moveTriviaUp($celebrity->id, $trivia->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function down(Celebrity $celebrity, Trivia $trivia) {

        try {
            $this->service->moveTriviaDown($celebrity->id, $trivia->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function last(Celebrity $celebrity, Trivia $trivia) {

        try {
            $this->service->moveTriviaToLast($celebrity->id, $trivia->id);
            return redirect()->route('dashboard.celebrities.show', $celebrity);
        } catch (\Exception|\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
