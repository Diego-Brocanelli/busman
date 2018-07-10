<?php

use Busman\People\Models\Team;
use Illuminate\Database\Seeder;

class AclSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['group' => 'Roles', 'name' => 'role_list'],
            ['group' => 'Roles', 'name' => 'role_store'],
            ['group' => 'Roles', 'name' => 'role_update'],
            ['group' => 'Roles', 'name' => 'role_destroy'],
            ['group' => 'Roles', 'name' => 'role_permissions'],

            ['group' => 'Teams', 'name' => 'team_list'],
            ['group' => 'Teams', 'name' => 'team_store'],
            ['group' => 'Teams', 'name' => 'team_update'],
            ['group' => 'Teams', 'name' => 'team_destroy'],

            ['group' => 'Customers', 'name' => 'customer_list'],
            ['group' => 'Customers', 'name' => 'customer_store'],
            ['group' => 'Customers', 'name' => 'customer_update'],
            ['group' => 'Customers', 'name' => 'customer_destroy'],

            ['group' => 'Employees', 'name' => 'employee_list'],
            ['group' => 'Employees', 'name' => 'employee_store'],
            ['group' => 'Employees', 'name' => 'employee_update'],
            ['group' => 'Employees', 'name' => 'employee_destroy'],

            ['group' => 'Accounts', 'name' => 'account_list'],
            ['group' => 'Accounts', 'name' => 'account_store'],
            ['group' => 'Accounts', 'name' => 'account_update'],
            ['group' => 'Accounts', 'name' => 'account_destroy'],
        ]);
    }
}
