<?php

namespace App\Http\Controllers;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return Inertia::render('Tasks/Index', ['tasks' => $tasks]);
    }

    public function create()
    {
        return Inertia::render('Tasks/Create');
    }

    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());
        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        return Inertia::render('Tasks/Edit', ['task' => $task]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
