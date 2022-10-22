<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public CONST ADMIN_USER_1 = 'admin@example.com';
    public CONST CS_USER_1 = 'test@example.com';
    public CONST SALES_USER_1 = 'test2@example.com';
    public CONST ROLE_PRODUCTION_MANAGER_USER_1 = 'pm@example.com';
    public CONST PURCHASING_OFFICE_USER_1 = 'po@example.com';

    public function run()
    {
        User::factory()->create([
            'email' => self::ADMIN_USER_1,
            'password' => 'admin'
        ])->assignRole(User::ROLE_ADMINISTRATOR);

        User::factory()->create([
            'email' => self::CS_USER_1,
            'password' => 'test'
        ])->assignRole(User::ROLE_CUSTOMER_SERVICE_AGENT);

        User::factory()->create([
            'email' => self::SALES_USER_1,
            'password' => 'test2'
        ])->assignRole(User::ROLE_SALES_AGENT);

        User::factory()->create([
            'email' => self::ROLE_PRODUCTION_MANAGER_USER_1,
            'password' => 'pm'
        ])->assignRole(User::ROLE_PRODUCTION_MANAGER);

        User::factory()->create([
            'email' => self::PURCHASING_OFFICE_USER_1,
            'password' => 'po'
        ])->assignRole(User::ROLE_PURCHASING_OFFICER);
    }
}
