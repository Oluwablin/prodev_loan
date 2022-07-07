<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        $Permissionitems = [
            [
                'name'        => 'Can View Users',
                'slug'        => 'view.users',
                'description' => 'Can view users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Create Users',
                'slug'        => 'create.users',
                'description' => 'Can create new users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Edit Users',
                'slug'        => 'edit.users',
                'description' => 'Can edit users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Delete Users',
                'slug'        => 'delete.users',
                'description' => 'Can delete users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Loans',
                'slug'        => 'view.loans',
                'description' => 'Can view loans',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Create Loans',
                'slug'        => 'create.loans',
                'description' => 'Can create new loans',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Edit Loans',
                'slug'        => 'edit.loans',
                'description' => 'Can edit loans',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Delete Loans',
                'slug'        => 'delete.loans',
                'description' => 'Can delete loans',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Approve Loans',
                'slug'        => 'approve.loans',
                'description' => 'Can approve loans',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Reject Loans',
                'slug'        => 'reject.loans',
                'description' => 'Can reject loans',
                'model'       => 'Permission',
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem === null) {
                $newPermissionitem = config('roles.models.permission')::create([
                    'name'          => $Permissionitem['name'],
                    'slug'          => $Permissionitem['slug'],
                    'description'   => $Permissionitem['description'],
                    'model'         => $Permissionitem['model'],
                ]);
            }
        }
    }
}
