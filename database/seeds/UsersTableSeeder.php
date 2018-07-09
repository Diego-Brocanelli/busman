<?php

use Busman\People\Models\Team;
use Busman\People\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use Busman\Warehouse\Models\Material;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            [
                'name' => 'Admin User',
                'email' => 'user@email.com.br',
                'teamName' => 'User Team',
                'department' => 'IT'
            ],[
                'name' => 'Marcelo Barros',
                'email' => 'maxcelos@outlook.com',
                'teamName' => 'Maxcelos',
                'department' => 'IT'
            ],[
                'name' => 'Santiago Sanches',
                'email' => 'sanchexm@protonmail.com',
                'teamName' => 'Sanchexm',
                'department' => 'IT'
            ],[
                'name' => 'Farley Rangel',
                'email' => 'farley@email.com',
                'teamName' => 'Farley',
                'department' => 'IT'
            ],[
                'name' => 'Munish Kumar',
                'email' => 'munish-kumar@outlook.com',
                'teamName' => 'Munish',
                'department' => 'IT'
            ],
        ];

        $comStatus = ['auto-gen', 'new', 'progress', 'hold', 'complete', 'pending', 'closed', 'canceled'];
        $permissions = DB::table('permissions')->get()->pluck('id')->toArray();

        foreach ($userData as $userDataItem) {
            /*
             * Create the admin user Team and initial setup
             *
             * */
            $user = User::create([
                'name' => $userDataItem['name'],
                'email' => $userDataItem['email'],
                'password' => bcrypt('admin.123'),
                'last_read_announcements_at' => Carbon::now(),
                'trial_ends_at' => Carbon::now()->addDays(30),
            ]);

            $team = Team::create([
                'name' => $userDataItem['teamName'],
                'owner_id' => $user->id
            ]);

            $user->employee()->create([
                'department' => $userDataItem['department'],
                'meta' => null,
                'team_id' => $team->id,
            ]);


            /*
             * Set this user as team owner. This is used by Spark
             *
             * */
            $team->users()->attach($user, ['role' => 'owner']);


            /*
             * Create 3 non editable roles
             *
             * */
            $adminRole = $team->roles()->create([
                'name' => 'Admin',
                'slug' => 'admin',
                'editable' => 0,
            ]);

            $team->roles()->create([
                'name' => 'Customer',
                'slug' => 'customer',
                'editable' => 0,
            ]);

            $team->roles()->create([
                'name' => 'Employee',
                'slug' => 'employee',
                'editable' => 0,
            ]);


            /*
             * Set this user as employee with admin powers
             *
             * */
            $user->assignRoles(['admin', 'employee']);


            /*
             * Assign all permissions to Admin role on this team
             *
             * */
            $adminRole->permissions()->attach($permissions);


            /*
             * Create 5 customers for this team
             *
             * */
            factory(User::class, 5)->create()->each(function($customer) use ($team) {
                $customer->customer()->create([
                    'business_name' => $customer->name,
                    'meta' => null,
                    'team_id' => $team->id
                ]);

                $customer->assignRole('customer');

                $team->users()->attach($customer, ['role' => 'customer']);
            });


            /*
             * Create 2 non admin users for this team
             *
             * */
            factory(User::class, 150)->create()->each(function($employee) use ($team, $userDataItem) {
                $employee->employee()->create([
                    'department' => $userDataItem['department'],
                    'meta' => null,
                    'team_id' => $team->id,
                ]);

                $employee->assignRole('employee');

                $team->users()->attach($employee, ['role' => 'employee']);
            });
        }

    }
}
