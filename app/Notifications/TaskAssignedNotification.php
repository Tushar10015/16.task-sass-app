<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class TaskAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject("New Task Assigned: {$this->task->title}")
            ->line("You’ve been assigned to the task: {$this->task->title}")
            ->action('View Task', url("/tasks/{$this->task->id}"));
    }

    public function toArray($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'project' => $this->task->project->name,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new \Illuminate\Notifications\Messages\BroadcastMessage([
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'project' => $this->task->project->name,
            'user_id' => $notifiable->id
        ]);
    }

    public function broadcastOn()
    {
        Log::info('Broadcasting notification', [
            'channel' => 'App.Models.User.' . $this->task->assigned_to,
            'task_id' => $this->task->id,
            'assigned_to' => $this->task->assigned_to
        ]);

        return new \Illuminate\Broadcasting\Channel('App.Models.User.' . $this->task->assigned_to);
    }
}
