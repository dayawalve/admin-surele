<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);

        \App\Models\Admin::factory(1)->create()->each(function ($admin) use ($adminRole){
            $admin->assignRole($adminRole);
        });

        \App\Models\User::factory(5)->create();

        $resourcePermissions = [
            ['name' => 'admin.users', 'controller' => 'AdminController'],
            ['name' => 'admin.role-permission', 'controller' => 'RolePermissionController'],
            ['name' => 'admin.permission-listing', 'controller' => 'PermissionListingController'],
        ];

        foreach ($resourcePermissions as $resource) {
            $this->createResourcePermissions($resource['name'], $resource['controller'], 'admin');
        }
    }

    private function createResourcePermissions($resourceName, $controllerName, $roleName)
    {
        $actions = ['index', 'create', 'store', 'edit', 'update', 'destroy', 'show'];

        foreach ($actions as $action) {
            $permissionName = "{$resourceName}.{$action}";

            $permission = Permission::create([
                'name' => $permissionName,
                'controller' => $controllerName,
            ]);
            $permission->syncRoles($roleName);
        }
    }
}
