<?php

use App\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add Roles
         *
         */
        if (Role::where('slug', '=', 'admin')->first() === null) {
            $adminRole = Role::create([
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'Admin Role',
                'level'       => 5,
            ]);
        }

        if (Role::where('slug', '=', 'mod')->first() === null) {
            $modRole = Role::create([
                'name'        => 'Moderator',
                'slug'        => 'mod',
                'description' => 'Moderator Role',
                'level'       => 4,
            ]);
        }

        if (Role::where('slug', '=', 'owner')->first() === null) {
            $ownerRole = Role::create([
                'name'        => 'Business Owner',
                'slug'        => 'owner',
                'description' => 'Business Owner Role',
                'level'       => 3,
            ]);
            $editBizPerm = Permission::where('slug', 'edit.businesses')->first();
            $ownerRole->attachPermission($editBizPerm);
        }

        if (Role::where('slug', '=', 'user')->first() === null) {
            $userRole = Role::create([
                'name'        => 'User',
                'slug'        => 'user',
                'description' => 'User Role',
                'level'       => 1,
            ]);
        }

        if (Role::where('slug', '=', 'unverified')->first() === null) {
            $userRole = Role::create([
                'name'        => 'Unverified',
                'slug'        => 'unverified',
                'description' => 'Unverified Role',
                'level'       => 0,
            ]);
        }
    }
}
