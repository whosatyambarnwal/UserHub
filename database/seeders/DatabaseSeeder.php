<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Super Admin Account
        $admin = User::create([
            'name' => 'Satyam Barnwal',
            'email' => 'admin@yopmail.com',
            'mobile' => '+91 98765 43210',
            'role' => 'admin',
            'status' => 'active',
            'is_super_admin' => true,
            'password' => Hash::make('password123'),
        ]);

        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'System Seeded',
            'description' => 'Initial Super Administrator account seeded',
            'ip_address' => '127.0.0.1',
        ]);

        // 2. Active Normal User Account
        $user = User::create([
            'name' => 'Priya Patel',
            'email' => 'user@yopmail.com',
            'mobile' => '+91 91234 56789',
            'role' => 'user',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'User Created',
            'description' => 'Standard user account initialized',
            'ip_address' => '127.0.0.1',
        ]);

        // 3. Inactive Normal User Account (For testing deactivation)
        $inactiveUser = User::create([
            'name' => 'Amit Verma',
            'email' => 'inactive@yopmail.com',
            'mobile' => '+91 98111 22334',
            'role' => 'user',
            'status' => 'inactive',
            'password' => Hash::make('password123'),
        ]);

        ActivityLog::create([
            'user_id' => $inactiveUser->id,
            'action' => 'Status Changed',
            'description' => 'Account set to inactive by system policy',
            'ip_address' => '127.0.0.1',
        ]);

        // 4. Secondary Admin
        $secAdmin = User::create([
            'name' => 'Vikram Malhotra',
            'email' => 'vikram.admin@yopmail.com',
            'mobile' => '+91 98222 33445',
            'role' => 'admin',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        // 5. Additional Realistic Dummy Users for testing filters & pagination
        $dummyUsers = [
            ['name' => 'Sneha Reddy', 'email' => 'sneha.reddy@yopmail.com', 'mobile' => '+91 98333 44556', 'role' => 'user', 'status' => 'active'],
            ['name' => 'Rohan Gupta', 'email' => 'rohan.gupta@yopmail.com', 'mobile' => '+91 98444 55667', 'role' => 'user', 'status' => 'active'],
            ['name' => 'Ananya Iyer', 'email' => 'ananya.iyer@yopmail.com', 'mobile' => '+91 98555 66778', 'role' => 'user', 'status' => 'active'],
            ['name' => 'Karthik Nair', 'email' => 'karthik.nair@yopmail.com', 'mobile' => '+91 98666 77889', 'role' => 'user', 'status' => 'inactive'],
            ['name' => 'Neha Joshi', 'email' => 'neha.joshi@yopmail.com', 'mobile' => '+91 98777 88990', 'role' => 'user', 'status' => 'active'],
            ['name' => 'Siddharth Rao', 'email' => 'siddharth.rao@yopmail.com', 'mobile' => '+91 98888 99001', 'role' => 'user', 'status' => 'active'],
            ['name' => 'Pooja Deshmukh', 'email' => 'pooja.d@yopmail.com', 'mobile' => '+91 98999 00112', 'role' => 'user', 'status' => 'active'],
            ['name' => 'Aditya Kulkarni', 'email' => 'aditya.k@yopmail.com', 'mobile' => '+91 97111 11223', 'role' => 'user', 'status' => 'inactive'],
            ['name' => 'Divya Choudhary', 'email' => 'divya.c@yopmail.com', 'mobile' => '+91 97222 22334', 'role' => 'user', 'status' => 'active'],
            ['name' => 'Manish Mehta', 'email' => 'manish.m@yopmail.com', 'mobile' => '+91 97333 33445', 'role' => 'user', 'status' => 'active'],
            ['name' => 'Ritu Saxena', 'email' => 'ritu.s@yopmail.com', 'mobile' => '+91 97444 44556', 'role' => 'user', 'status' => 'active'],
            ['name' => 'Harish Menon', 'email' => 'harish.m@yopmail.com', 'mobile' => '+91 97555 55667', 'role' => 'user', 'status' => 'active'],
        ];

        foreach ($dummyUsers as $data) {
            $u = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'role' => $data['role'],
                'status' => $data['status'],
                'password' => Hash::make('password123'),
            ]);

            ActivityLog::create([
                'user_id' => $u->id,
                'action' => 'User Registered',
                'description' => "Account {$u->name} registered with status [{$u->status}]",
                'ip_address' => '127.0.0.1',
            ]);
        }

        // 6. One soft-deleted user in Trash to showcase trash/restore feature
        $trashUser = User::create([
            'name' => 'Suresh Kumar (Archived)',
            'email' => 'suresh.kumar@yopmail.com',
            'mobile' => '+91 97666 66778',
            'role' => 'user',
            'status' => 'inactive',
            'password' => Hash::make('password123'),
        ]);
        $trashUser->delete();

        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'User Soft-Deleted',
            'description' => "Administrator soft-deleted user {$trashUser->name}",
            'ip_address' => '127.0.0.1',
        ]);
    }
}
