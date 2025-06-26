<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Task, Subtask};

class SubtaskController extends Controller
{

    public function store(Task $task, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task->subtasks()->create([
            'title' => $request->title,
            'is_done' => false,
        ]);

        return back(); // or redirect to project.show
    }

    public function toggle(Subtask $subtask)
    {
        $subtask->update([
            'is_done' => !$subtask->is_done,
        ]);

        return back();
    }
}
