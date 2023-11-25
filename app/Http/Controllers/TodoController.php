<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Foundation\Application;

class TodoController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): Response
  {
    return Inertia::render('Home', [
      'laravelVersion' => Application::VERSION,
      'phpVersion' => PHP_VERSION,
      'todos' => Todo::with('user:id,name')->latest()->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreTodoRequest $request): RedirectResponse
  {
    $validated = $request->validated();

    $request->user()->todos()->create($validated);

    return redirect(route('todo.index'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Todo $todo)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Todo $todo)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateTodoRequest $request, Todo $todo): RedirectResponse
  {
    $this->authorize('update', $todo);

    $validated = $request->validated();

    $todo->update($validated);

    return redirect(route('todo.index'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Todo $todo)
  {
    $this->authorize('delete', $todo);

    $todo->delete();

    return redirect(route('todo.index'));
  }
}
