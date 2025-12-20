<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VendorProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@createlize.org'],
            ['name' => 'Createlize Admin', 'password' => Hash::make('admin@createlize.org'), 'status'=>'active']
        );
        $admin->syncRoles(['Admin']);

        $vendor1 = User::updateOrCreate(
            ['email' => 'vendor1@createlize.org'],
            ['name' => 'Createlize Academy', 'password' => Hash::make('password'), 'status'=>'active']
        );
        $vendor1->syncRoles(['Vendor']);
        VendorProfile::updateOrCreate(['user_id'=>$vendor1->id], [
            'store_name' => 'Createlize Academy',
            'phone' => '01XXXXXXXXX',
            'address' => 'Dhaka, Bangladesh',
            'verified_at' => now(),
        ]);

        $vendor2 = User::updateOrCreate(
            ['email' => 'vendor2@createlize.org'],
            ['name' => 'Createlize Host', 'password' => Hash::make('password'), 'status'=>'active']
        );
        $vendor2->syncRoles(['Vendor']);
        VendorProfile::updateOrCreate(['user_id'=>$vendor2->id], [
            'store_name' => 'Createlize Host',
            'phone' => '01XXXXXXXXX',
            'address' => 'Dhaka, Bangladesh',
            'verified_at' => now(),
        ]);

        $customer = User::updateOrCreate(
            ['email' => 'customer@createlize.org'],
            ['name' => 'Demo Customer', 'password' => Hash::make('password'), 'status'=>'active']
        );
        $customer->syncRoles(['Customer']);
    }
}
