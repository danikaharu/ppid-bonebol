<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (config('permission.list_permissions') as $permission) {
            foreach ($permission['lists'] as $list) {
                Permission::create(['name' => $list]);
            }
        }

        $roleAdmin = User::first();

        $roleAdmin->givePermissionTo(Permission::all());
    }
}
