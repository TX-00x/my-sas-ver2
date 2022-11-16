<?php

namespace App\Console\Commands\Migration;

use App\Models\Address;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerContact;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class MigrateCustomers extends Command
{
    protected $signature = 'data-migrate:customers';

    protected $description = 'Migrate customers from old database to new';

    public function handle()
    {
        $customers = DB::connection('old_database')
            ->table('customers')
            ->where('status', 'Active')
            ->get();

        $this->confirm('We are about to import '. $customers->count() . ' from old database. Confirm ?');

        $customers->each(function ($customer) {
            DB::transaction(function () use ($customer) {
                $this->createCustomer($customer);
            });
        });
    }

    private function createCustomer($customer)
    {
        $emails = $this->extract_emails_from($customer->Email);
        $defaultEmail = '';

        if (count($emails) > 0) {
            $defaultEmail = $emails[0];
        }

        $customerExists = Customer::query()
            ->where('email', '=', $defaultEmail)
            ->where('name', '=', $customer->Name)
            ->exists();
        if ($customerExists) {
            $this->warn('[!] Customer ' .$customer->Name .':' . $defaultEmail . ' already exists in the database. Skipping !');
            return;
        }

        $createdCustomer = Customer::create([
            'name' => $customer->Name,
            'email' => $defaultEmail ?? '',
            'description' => $customer->Notes,
        ]);

        $splitContactName = explode(' ', $customer->Contact);
        CustomerContact::create([
            'customer_id' => $createdCustomer->id,
            'first_name' => $splitContactName[0] ?? '',
            'last_name' => $splitContactName[1] ?? '',
            'email' => $defaultEmail ?? '',
            'contact_no' => $customer->Phone ?? '',
            'designation' => '',
            'type' => 'primary',
        ]);

        if (isset($emails[1])) {
            CustomerContact::create([
                'customer_id' => $createdCustomer->id,
                'first_name' => '',
                'last_name' => '',
                'email' => $emails[1] ?? '',
                'contact_no' => '',
                'designation' => '',
                'type' => 'primary',
            ]);
        }

        $billingCountryId = $this->getEmptyCountry();
        if (!empty($customer->BillAddressCountry)) {
            $billingCountryId = $this->getCountry($customer->BillAddressCountry)->id;
        }


        $billingAddress = Address::create([
            'line_1' => $customer->BillAddressAddr2 ?? '',
            'line_2' => $customer->BillAddressAddr3 ?? '',
            'line_3' => $customer->BillAddressAddr4 ?? '',
            'city' => $customer->BillAddressCity ?? '',
            'postal_code' => $customer->BillAddressPostalCode ?? '',
            'country_id' => $billingCountryId,
        ]);

        CustomerAddress::create([
            'customer_id' => $createdCustomer->id,
            'address_id' => $billingAddress->id,
            'type' => 'billing',
        ]);

        $shippingAddressId = $this->getEmptyCountry();
        if (!empty($customer->ShipAddressCountry)) {
            $shippingAddressId = $this->getCountry($customer->ShipAddressCountry)->id;
        }

        $shippingAddress = Address::create([
            'line_1' => $customer->ShipAddressAddr2 ?? '',
            'line_2' => $customer->ShipAddressAddr3 ?? '',
            'line_3' => $customer->ShipAddressAddr4 ?? '',
            'city' => $customer->ShipAddressCity ?? '',
            'postal_code' => $customer->ShipAddressPostalCode ?? '',
            'country_id' => $shippingAddressId,
        ]);

        CustomerAddress::create([
            'customer_id' => $createdCustomer->id,
            'address_id' => $shippingAddress->id,
            'type' => 'shipping',
        ]);
    }

    private function getEmptyCountry(): int
    {
        $country = Country::query()
            ->where('name', '=','Unknown')
            ->get()
            ->first();
        if ($country) {
            return $country->id;
        }

        return Country::create([
            'name' => 'Unknown',
            'sort' => '-'
        ])->id;
    }

    private function getCountry($countryName): Country
    {
        $country = Country::query()
            ->where(DB::raw('LCASE(REPLACE(name, " ", ""))'), strtolower(str_replace(' ', '', $countryName)))
            ->get();
        if ($country->isNotEmpty()) {
            return $country->first();
        }

        $code = $this->getISO2Code($countryName);
        return Country::create([
            'name' => $countryName,
            'sort' => $code,
        ]);
    }

    private function getISO2Code($country): string
    {
        $country = preg_replace('/[^A-Za-z0-9. -]/', '', $country);
        $response =  json_decode(file_get_contents('https://public.opendatasoft.com/api/records/1.0/search/?dataset=countries-codes&q='. urlencode($country)));
        if (empty($response->records)) {
            return '';
        }

        return $response->records[0]->fields->iso2_code;
    }

    private function extract_emails_from($string){
        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
        return $matches[0];
    }
}
