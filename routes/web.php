<?php

use App\Events\CommentAdded;
use App\Events\TestEvent;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SubtaskController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BillingController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    Route::prefix('projects/{project}')->group(function () {
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/subtasks/{subtask}/toggle', [SubtaskController::class, 'toggle'])->name('subtasks.toggle');
    Route::post('/tasks/{task}/subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
});


Route::middleware(['auth'])->group(function () {
    Route::post('/billing/checkout', [BillingController::class, 'redirectToCheckout'])->name('billing.checkout');
    Route::get('/billing/success', [BillingController::class, 'success'])->name('billing.success');
    Route::get('/billing/cancel', [BillingController::class, 'cancel'])->name('billing.cancel');
});



Route::get('/test-pusher', function () {
    try {
        $pusher = new Pusher\Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );
        $comment = App\Models\Comment::with('user', 'task')->first();
        //$response = $pusher->trigger('test-channel', 'test-event', ['message' => 'Hello']);
        $response = $pusher->trigger('project.9', 'comment.added', ['message' => $comment]);
        return response()->json(['success' => true, 'response' => $response]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/fire', function () {
    broadcast(new TestEvent());
    return 'Test event fired';
});
