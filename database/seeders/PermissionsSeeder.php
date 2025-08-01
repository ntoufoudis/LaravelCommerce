<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $usersPermissions = [
            'users:viewAny',
            'users:view',
            'users:create',
            'users:update',
            'users:delete',
        ];

        foreach ($usersPermissions as $userPermission) {
            Permission::create(['name' => $userPermission]);
        }

        $rolesPermissions = [
            'roles:viewAny',
            'roles:view',
            'roles:create',
            'roles:update',
            'roles:delete',
        ];

        foreach ($rolesPermissions as $rolePermission) {
            Permission::create(['name' => $rolePermission]);
        }

        $permissionsPermissions = [
            'permissions:viewAny',
            'permissions:view',
            'permissions:create',
            'permissions:update',
            'permissions:delete',
        ];

        foreach ($permissionsPermissions as $permissionPermission) {
            Permission::create(['name' => $permissionPermission]);
        }

        $categoriesPermissions = [
            'categories:viewAny',
            'categories:view',
            'categories:create',
            'categories:update',
            'categories:delete',
        ];

        foreach ($categoriesPermissions as $categoryPermission) {
            Permission::create(['name' => $categoryPermission]);
        }

        $tagsPermissions = [
            'tags:viewAny',
            'tags:view',
            'tags:create',
            'tags:update',
            'tags:delete',
        ];

        foreach ($tagsPermissions as $tagPermission) {
            Permission::create(['name' => $tagPermission]);
        }

        // Create Roles and assign existing Permissions
        $role1 = Role::create(['name' => 'customer']);

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo($usersPermissions);
        $role2->givePermissionTo($rolesPermissions);
        $role2->givePermissionTo($permissionsPermissions);
        $role2->givePermissionTo($categoriesPermissions);
        $role2->givePermissionTo($tagsPermissions);

        $role3 = Role::create(['name' => 'Super-Admin']);

        // Create Users
        $customer = User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
        ]);
        $customer->assignRole($role1);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole($role2);

        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);
        $superAdmin->assignRole($role3);
    }
}
