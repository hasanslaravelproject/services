<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list services']);
        Permission::create(['name' => 'view services']);
        Permission::create(['name' => 'create services']);
        Permission::create(['name' => 'update services']);
        Permission::create(['name' => 'delete services']);

        Permission::create(['name' => 'list companies']);
        Permission::create(['name' => 'view companies']);
        Permission::create(['name' => 'create companies']);
        Permission::create(['name' => 'update companies']);
        Permission::create(['name' => 'delete companies']);

        Permission::create(['name' => 'list categories']);
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);

        Permission::create(['name' => 'list measureunits']);
        Permission::create(['name' => 'view measureunits']);
        Permission::create(['name' => 'create measureunits']);
        Permission::create(['name' => 'update measureunits']);
        Permission::create(['name' => 'delete measureunits']);

        Permission::create(['name' => 'list ingredients']);
        Permission::create(['name' => 'view ingredients']);
        Permission::create(['name' => 'create ingredients']);
        Permission::create(['name' => 'update ingredients']);
        Permission::create(['name' => 'delete ingredients']);

        Permission::create(['name' => 'list products']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'update products']);
        Permission::create(['name' => 'delete products']);

        Permission::create(['name' => 'list finishedproductstocks']);
        Permission::create(['name' => 'view finishedproductstocks']);
        Permission::create(['name' => 'create finishedproductstocks']);
        Permission::create(['name' => 'update finishedproductstocks']);
        Permission::create(['name' => 'delete finishedproductstocks']);

        Permission::create(['name' => 'list rawproductstocks']);
        Permission::create(['name' => 'view rawproductstocks']);
        Permission::create(['name' => 'create rawproductstocks']);
        Permission::create(['name' => 'update rawproductstocks']);
        Permission::create(['name' => 'delete rawproductstocks']);

        Permission::create(['name' => 'list productions']);
        Permission::create(['name' => 'view productions']);
        Permission::create(['name' => 'create productions']);
        Permission::create(['name' => 'update productions']);
        Permission::create(['name' => 'delete productions']);

        Permission::create(['name' => 'list deliveries']);
        Permission::create(['name' => 'view deliveries']);
        Permission::create(['name' => 'create deliveries']);
        Permission::create(['name' => 'update deliveries']);
        Permission::create(['name' => 'delete deliveries']);

        Permission::create(['name' => 'list orders']);
        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'update orders']);
        Permission::create(['name' => 'delete orders']);

        Permission::create(['name' => 'list packages']);
        Permission::create(['name' => 'view packages']);
        Permission::create(['name' => 'create packages']);
        Permission::create(['name' => 'update packages']);
        Permission::create(['name' => 'delete packages']);

        Permission::create(['name' => 'list packagetypes']);
        Permission::create(['name' => 'view packagetypes']);
        Permission::create(['name' => 'create packagetypes']);
        Permission::create(['name' => 'update packagetypes']);
        Permission::create(['name' => 'delete packagetypes']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
