<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subtask extends Model
{
    use HasFactory;
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
