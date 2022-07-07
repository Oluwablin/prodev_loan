<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = config('roles.models.role')::where('name', '=', 'User')->first();
        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $permissions = config('roles.models.permission')::all();

        /*
         * Add Users
         *
         */
        if (config('roles.models.defaultUser')::where('email', '=', 'admin@admin.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'first_name'     => 'Admin',
                'last_name'     => 'Admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password'),
                'is_verified' => 1,
                'phone'    => '+234810',
                'username'    => 'AdminAdmin1',
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'user@user.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'first_name'     => 'Default',
                'last_name'     => 'User',
                'email'    => 'default_user@user.com',
                'password' => bcrypt('password'),
                'is_verified' => 1,
                'phone'    => '+234811',
                'username'    => 'DefaultUser2',
            ]);

            $newUser->attachRole($userRole);
        }
    }
}
