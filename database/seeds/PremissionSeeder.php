<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\User;

class PremissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        //$role = Role::create(['name' => 'Manager']);
        
        $permission = Permission::create(['name' => 'create test']);
        $permission = Permission::create(['name' => 'delete test']);
        $permission = Permission::create(['name' => 'update test']);
        $permission = Permission::create(['name' => 'read test']);

        $permission = Permission::create(['name' => 'create user']);
        $permission = Permission::create(['name' => 'read user']);
        $permission = Permission::create(['name' => 'edit user']);
        $permission = Permission::create(['name' => 'delete user']);
        
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo('create test');
        $role->givePermissionTo('delete test');
        $role->givePermissionTo('update test');
        $role->givePermissionTo('read test');

        $user = User::find(1);
        $user->assignRole($role);

    }
}
