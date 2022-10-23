<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    const CUSTOMER_1_EMAIL = 'customer1@example.com';
    const CUSTOMER_2_EMAIL = 'customer2@example.com';

    public function run()
    {
        $customerLogos = [
            ['file_path' => 'WtbxweLh4LdgK5wFFSAEwTuO1YXNEaTl4VZRjbQf.jpg'],
            ['file_path' => '2oRrAeFGKPFqRDMlON4BMue8DlK0CHlEkx11eMyr.png']
        ];

        foreach ($customerLogos as $logo) {
            File::create($logo);
        }
        $logo1 = File::orderBy('id', 'asc')->first();
        $logo2 = File::orderBy('id', 'desc')->first();

        $csAgent = User::role(User::ROLE_CUSTOMER_SERVICE_AGENT)->first();
        $salesAgent = User::role(User::ROLE_SALES_AGENT)->first();

        $customer1 = Customer::factory()->create([
            'name' => 'Customer 1',
            'logo_id' => $logo1->id,
            'email' => self::CUSTOMER_1_EMAIL,
        ]);

        $customer1->salesAgents()->attach($salesAgent);
        $customer1->customerSupportAgents()->attach($csAgent);

        $customer2 = Customer::factory()->create([
            'name' => 'Customer 2',
            'logo_id' => $logo2->id,
            'email' => self::CUSTOMER_2_EMAIL,
        ]);

        $customer2->salesAgents()->attach($salesAgent);
        $customer2->customerSupportAgents()->attach($csAgent);
    }

    public static function customer1(): Customer
    {
        return Customer::query()->where('email', '=', self::CUSTOMER_1_EMAIL)->get()->first();
    }

    public static function customer2(): Customer
    {
        return Customer::query()->where('email', '=', self::CUSTOMER_2_EMAIL)->get()->first();
    }
}
