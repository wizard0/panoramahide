<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => \App\Models\User::PERMISSION_ADMIN]);

        $role = Role::create(['name' => \App\Models\User::ROLE_ADMIN]);
        $role->givePermissionTo(\App\Models\User::PERMISSION_ADMIN);

        $role = Role::create(['name' => \App\Models\User::ROLE_SUPERADMIN]);
        $role->givePermissionTo(Permission::all());
    }
}
