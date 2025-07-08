<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id',
        'user_id',
        'assigned_to',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
