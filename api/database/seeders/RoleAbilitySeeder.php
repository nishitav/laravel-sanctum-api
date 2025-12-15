<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAbilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // abilities
        $abilities = [
            'products:read',
            'products:create',
            'products:update',
            'products:delete'
        ];

        foreach ($abilities as $ab) {
            Ability::firstOrCreate(['name' => $ab]);
        }

        // roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $staff   = Role::firstOrCreate(['name' => 'staff']);
        $customer= Role::firstOrCreate(['name' => 'customer']);

        // map abilities to roles
        $admin->abilities()->sync(Ability::pluck('id')); // full access (all abilities)
        $staff->abilities()->sync(Ability::whereIn('name', [
            'products:read','products:create','products:update'
        ])->pluck('id'));
        $customer->abilities()->sync(Ability::whereIn('name', [
            'products:read'
        ])->pluck('id'));
    }
}
