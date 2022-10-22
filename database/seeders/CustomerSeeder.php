<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
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
            'name' => 'John Doe',
            'logo_id' => $logo1->id
        ]);

        $customer1->salesAgent()->attach($salesAgent);
        $customer1->csAgent()->attach($csAgent);

        $customer2 = Customer::factory()->create([
            'name' => 'Jane Doe',
            'logo_id' => $logo2->id
        ]);

        $customer2->salesAgent()->attach($salesAgent);
        $customer2->csAgent()->attach($csAgent);
    }
}
