<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
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
            DB::table('services')->insert([
                ['name' => 'Clean a boat', 'description' => 'Clean a boat', 'team_id' => $team->id],
            ]);
        }

    }
}
