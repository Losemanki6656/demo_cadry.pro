<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'management_statistics',
           'management_organizations',
           'management_turnicet',
           'organization_cadries',
           'organization_statistics',
           'organization_staffs',
           'organization_departments',
           'organization_vacations',          
           'organization_meds',
           'organization_incentives',
           'organization_discips',
           'cadry_leader_statistics',
           'cadry_leader_cadries',
           'organization_archive',
           'admin',
           'pereview_statistics',
           'management_qualifications',
           'management_professions'
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}