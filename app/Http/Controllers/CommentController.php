<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Comment, Task};
use App\Events\CommentAdded;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{

    public function store(Task $task, Request $request)
    {
        $request->validate(['body' => 'required|string']);

        $comment = $task->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        broadcast(new CommentAdded($comment));
        //event(new CommentAdded($comment));

        //broadcast(new CommentAdded($comment))->toOthers();

        return back();
    }
}
