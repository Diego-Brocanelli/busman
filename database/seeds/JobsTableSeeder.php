<?php

use Illuminate\Database\Seeder;
use Busman\Jobs\Models\Task;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = \Busman\People\Models\Team::all();

        foreach ($teams as $team) {

            $service = \Busman\Jobs\Models\Service::where('team_id', $team->id)->first();
            $customer = \Busman\People\Models\Customer::where('team_id', $team->id)->first();

            DB::table('types')->insert([
                [
                    'name' => 'T&M',

                    'team_id' => $team->id
                ],
                [
                    'name' => 'Quoted',
                    'team_id' => $team->id
                ],
                [
                    'name' => 'Warranty Work',
                    'team_id' => $team->id
                ],

            ]);

            $types = \Busman\Jobs\Models\Type::where('team_id', $team->id)->get();

            $job = \Busman\Jobs\Models\Job::create([
                'name' => 'Sample Job',
                'customer_id' => $customer->id,
                'service_id' => $service->id,
                'status' => 'pending',
                'description' => 'Just a sample job',
                'team_id' => $team->id,
                'type_id' => $types->first()->id,
                'deadline' => '2018-07-01 10:00:00'
            ]);

            $job->stages()->create(['name' => 'ToDo', 'after' => optional($job->lastStage())->id, 'team_id' => $team->id]);
            $job->stages()->create(['name' => 'Doing', 'after' => optional($job->lastStage())->id, 'team_id' => $team->id]);
            $job->stages()->create(['name' => 'Done', 'after' => optional($job->lastStage())->id, 'team_id' => $team->id]);

            $job->epics()->create([
                'name' => 'Painting',
                'color' => '#1c1fdb',
                'team_id' => $team->id
            ]);
            $job->epics()->create([
                'name' => 'Cleaning',
                'color' => '#ea0edb',
                'team_id' => $team->id
            ]);
            $job->epics()->create([
                'name' => 'Manufacturing',
                'color' => '#e5e5e5',
                'team_id' => $team->id
            ]);

            Task::create([
                'story_points' => 1,
                'epic_id' => $job->epics->first()->id,
                'end' => now()->addHour(5),
                'description' => 'Paint deck of Titanic today',
                'name' => 'Paint a deck',
                'status' => 'pending',
                'start' => now(),
                'stage_id' => $job->stages()->first()->id,

                'job_id' => $job->id,
                'team_id' => $team->id
            ]);

            Task::create([
                'story_points' => 2,
                'epic_id' => $job->epics->first()->id,
                'end' => now()->addDay()->addHour(10),
                'description' => 'Fix iceberg crack',
                'name' => 'Fix crack',
                'status' => 'pending',
                'start' => now()->addDay(),
                'stage_id' => $job->stages()->first()->id,

                'job_id' => $job->id,
                'team_id' => $team->id
            ]);

            Task::create([
                'story_points' => 4,
                'epic_id' => $job->epics->first()->id,
                'end' => now()->addHour(8),
                'description' => 'Install new engine',
                'name' => 'Install engine',
                'status' => 'pending',
                'start' => now(),
                'stage_id' => $job->stages()->first()->id,

                'job_id' => $job->id,
                'team_id' => $team->id
            ]);
        }
    }
}
