<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Project, Task};
use Inertia\Inertia;

class TaskController extends Controller
{

    public function store(Project $project, Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:todo,in_progress,done',
        ]);

        $project->tasks()->create([
            ...$data,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('projects.show', $project->id);
    }

    public function edit(Project $project, Task $task)
    {
        return Inertia::render('Tasks/Edit', [
            'project' => $project,
            'task' => $task,
        ]);
    }

    public function update(Project $project, Task $task, Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:todo,in_progress,done',
        ]);

        $task->update($data);

        return redirect()->route('projects.show', $project->id);
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return redirect()->route('projects.show', $project->id);
    }
}
