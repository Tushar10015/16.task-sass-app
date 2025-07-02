<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class CommentAdded implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $comment;

    public function __construct(Comment $comment)
    {
        Log::info('CommentAdded Event Constructor', [
            'comment_id' => $comment->id,
            'project_id' => $comment->task->project_id,
            'task_id' => $comment->task_id,
            'user_id' => $comment->user_id
        ]);

        $this->comment = $comment->load('user');
    }

    public function broadcastOn()
    {
        Log::info('Attempting to broadcast');

        try {
            $channel = new Channel('project.' . $this->comment->task->project_id);
            Log::info('Broadcast channel created', ['channel' => $channel->name]);
            return $channel;
        } catch (Exception $e) {
            Log::error('Broadcast failed', [
                'error' => $e->getMessage(),
                'comment_id' => $this->comment->id
            ]);
            throw $e;
        }
    }

    public function broadcastWith()
    {
        Log::info('Broadcast data prepared');
        return [
            'comment' => $this->comment,
            'user' => $this->comment->user
        ];
    }

    public function broadcastAs()
    {
        return 'comment.added';
    }
}
