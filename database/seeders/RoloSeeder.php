<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Usuario']);

        Permission::create(['name' => 'home'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'inventario'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'inventariodet'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'users.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.update'])->syncRoles([$role1]);

        Permission::create(['name' => 'credito'])->syncRoles([$role1]);
        Permission::create(['name' => 'comprasyventas'])->syncRoles([$role2]);

        Permission::create(['name' => 'editcompra'])->syncRoles([$role1]);
        Permission::create(['name' => 'deletecompra'])->syncRoles([$role1]);

        Permission::create(['name' => 'reportescf'])->syncRoles([$role1]);
        Permission::create(['name' => 'reportescaja'])->syncRoles([$role1]);
        Permission::create(['name' => 'in-eg-ca-ba'])->syncRoles([$role1]);
        Permission::create(['name' => 'editdeletebanco'])->syncRoles([$role1]);
        Permission::create(['name' => 'editarticulo'])->syncRoles([$role1]);
        Permission::create(['name' => 'sicredito'])->syncRoles([$role1]);
    }

}
