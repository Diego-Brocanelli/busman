<?php

use Illuminate\Database\Seeder;

class ToolsTableSeeder extends Seeder
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
            DB::table('tools')->insert([
                [
                    'name' => 'Furadeira',
                    'code' => '#3534',
                    'serial_number' => 'SN3453455',
                    'notes' => 'Sample Tool',
                    'status' => 'available',
                    'model' => 'Best Model',
                    'vendor' => 'Bosh',
                    'type' => 'type 1',
                    'team_id' => $team->id
                ]
            ]);
        }
    }
}
