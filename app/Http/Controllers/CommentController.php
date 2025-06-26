<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Comment, Task};

class CommentController extends Controller
{

    public function store(Task $task, Request $request)
    {
        $request->validate(['body' => 'required|string']);

        $task->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return back();
    }
}
