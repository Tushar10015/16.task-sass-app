<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;


Broadcast::channel('project.{projectId}', function ($user, $projectId) {
    Log::info("User $user->id is trying to join private channel 'project.$projectId'");
    return true;
});

Broadcast::private('project.{projectId}', function ($user, $projectId) {
    Log::info("User $user->id is trying to join private channel 'project.$projectId'");
    return true;
});
