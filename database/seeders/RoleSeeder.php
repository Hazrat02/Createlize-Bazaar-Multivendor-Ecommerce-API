<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Admin','Vendor','Customer'] as $role) {
            Role::findOrCreate($role, 'web');
            Role::findOrCreate($role, 'sanctum');
        }
    }
}
