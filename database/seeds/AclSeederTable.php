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

            ['group' => 'Jobs', 'name' => 'job_list'],
            ['group' => 'Jobs', 'name' => 'job_store'],
            ['group' => 'Jobs', 'name' => 'job_update'],
            ['group' => 'Jobs', 'name' => 'job_destroy'],

            ['group' => 'Tasks', 'name' => 'task_list'],
            ['group' => 'Tasks', 'name' => 'task_store'],
            ['group' => 'Tasks', 'name' => 'task_update'],
            ['group' => 'Tasks', 'name' => 'task_destroy'],

            ['group' => 'Epics', 'name' => 'epic_list'],
            ['group' => 'Epics', 'name' => 'epic_store'],
            ['group' => 'Epics', 'name' => 'epic_update'],
            ['group' => 'Epics', 'name' => 'epic_destroy'],

            ['group' => 'Stages', 'name' => 'stage_list'],
            ['group' => 'Stages', 'name' => 'stage_store'],
            ['group' => 'Stages', 'name' => 'stage_update'],
            ['group' => 'Stages', 'name' => 'stage_destroy'],

            ['group' => 'Tickets', 'name' => 'ticket_list'],
            ['group' => 'Tickets', 'name' => 'ticket_store'],
            ['group' => 'Tickets', 'name' => 'ticket_update'],
            ['group' => 'Tickets', 'name' => 'ticket_destroy'],

            ['group' => 'Services', 'name' => 'service_list'],
            ['group' => 'Services', 'name' => 'service_store'],
            ['group' => 'Services', 'name' => 'service_update'],
            ['group' => 'Services', 'name' => 'service_destroy'],

            ['group' => 'Ticket Followers', 'name' => 'ticket_followers_list'],
            ['group' => 'Ticket Followers', 'name' => 'ticket_followers_store'],
            ['group' => 'Ticket Followers', 'name' => 'ticket_followers_destroy'],

            ['group' => 'Task Followers', 'name' => 'task_followers_list'],
            ['group' => 'Task Followers', 'name' => 'task_followers_store'],
            ['group' => 'Task Followers', 'name' => 'task_followers_destroy'],

            ['group' => 'Tools', 'name' => 'tools_list'],
            ['group' => 'Tools', 'name' => 'tools_store'],
            ['group' => 'Tools', 'name' => 'tools_update'],
            ['group' => 'Tools', 'name' => 'tools_destroy'],

            ['group' => 'Leases', 'name' => 'leases_list'],
            ['group' => 'Leases', 'name' => 'leases_store'],
            ['group' => 'Leases', 'name' => 'leases_update'],
            ['group' => 'Leases', 'name' => 'leases_destroy'],

            ['group' => 'Job Types', 'name' => 'type_list'],
            ['group' => 'Job Types', 'name' => 'type_store'],
            ['group' => 'Job Types', 'name' => 'type_update'],
            ['group' => 'Job Types', 'name' => 'type_destroy'],

            ['group' => 'Materials', 'name' => 'material_list'],
            ['group' => 'Materials', 'name' => 'material_store'],
            ['group' => 'Materials', 'name' => 'material_update'],
            ['group' => 'Materials', 'name' => 'material_destroy'],

            ['group' => 'Job Materials', 'name' => 'job_material_list'],
            ['group' => 'Job Materials', 'name' => 'job_material_store'],
            ['group' => 'Job Materials', 'name' => 'job_material_update'],
            ['group' => 'Job Materials', 'name' => 'job_material_destroy'],
        ]);
    }
}
