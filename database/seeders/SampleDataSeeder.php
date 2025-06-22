<?php

namespace Database\Seeders;

use App\Models\{User, Team, Project, Task, Subtask, Comment};
use Illuminate\Database\Seeder;
use Database\Factories\ProjectFactory;


class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(3)->create()->each(function ($user) {
            $team = $user->ownedTeams()->create([
                'name' => $user->name . "'s Workspace",
                'personal_team' => false,
            ]);

            Project::factory()->count(2)->create([
                'team_id' => $team->id,
                'user_id' => $user->id,
            ])->each(function ($project) use ($user) {
                Task::factory()->count(3)->create([
                    'project_id' => $project->id,
                    'user_id' => $user->id,
                ])->each(function ($task) use ($user) {
                    Subtask::factory()->count(2)->create(['task_id' => $task->id]);
                    Comment::factory()->count(2)->create([
                        'task_id' => $task->id,
                        'user_id' => $user->id,
                    ]);
                });
            });
        });
    }
}
