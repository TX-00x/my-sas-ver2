<?php

namespace App\Console\Commands\Migration;

use App\Models\Address;
use App\Models\Country;
use App\Models\OldDatabase\OldSupplier;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use App\Models\SupplierContact;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Monolog\Handler\IFTTTHandler;

class MigrateSuppliers extends Command
{
    protected $signature = 'data-migrate:suppliers';

    protected $description = 'Migrate suppliers from old database to new';

    public function handle()
    {
        $suppliers = OldSupplier::query()
            ->where('IsActive', '1')
            ->get();

        $alreadyExistingSuppliers = collect([]);
        $suppliers->each(function (OldSupplier $oldDBSupplier) use ($alreadyExistingSuppliers) {
            if ($this->validateSupplierAlreadyExists($oldDBSupplier)) {
                $alreadyExistingSuppliers->push($oldDBSupplier);
                return;
            }

            try {
                $this->createSupplierInNewDatabase($oldDBSupplier);
            } catch (\Exception $exception) {
                $this->error('[!] Failed to import supplier '. $oldDBSupplier->Name.':'.$oldDBSupplier->Email .' due to reason' . $exception->getMessage());
            }
        });

        if ($alreadyExistingSuppliers->isNotEmpty()) {
            $this->warn('[!] The following suppliers skipped due to been already in the database');
            collect($alreadyExistingSuppliers)->each(function ($supplier) {
                $this->info('[-] ' . $supplier->Name .':' . $supplier->Email);
            });
        }

        $this->info('[+] Done !');

        return 0;
    }

    public function validateSupplierAlreadyExists($oldDBSupplier)
    {
        return Supplier::query()
            ->where('name', 'LIKE', "%$oldDBSupplier->Name%")
            ->orWhere('email', '=', $oldDBSupplier->Email)
            ->exists();
    }

    private function createSupplierInNewDatabase(OldSupplier $oldDBSupplier)
    {
        DB::transaction(function () use ($oldDBSupplier) {

            $supplier = Supplier::create([
                'name' => $oldDBSupplier->Name,
                'email' => $oldDBSupplier->Email ?? '',
                'description' => $oldDBSupplier->Notes ?? '',
                'currency' => '',
            ]);

            SupplierContact::create([
                'supplier_id' => $supplier->id,
                'first_name' => $oldDBSupplier->Name,
                'last_name' => '',
                'email' => $oldDBSupplier->Email ?? '',
                'contact_number' => $oldDBSupplier->Phone ?? '',
                'designation' => '-',
                'type' => SupplierContact::PRIMARY,
            ]);

            $countryName = 'New Zealand';

            if ($oldDBSupplier->VendorAddressCountry != null) {
                $countryName = Str::headline($oldDBSupplier->VendorAddressCountry);
            }

            $country = Country::query()
                ->where('name', $countryName)
                ->get()
                ->first();
            if ($country == null) {
                $country = Country::create([
                    'name' => $countryName,
                    'sort' => ''
                ]);
            }

            $address = Address::create([
                'line_1' => $oldDBSupplier->VendorAddressAddr2 ?? '',
                'line_2' => $oldDBSupplier->VendorAddressAddr3 ?? '',
                'line_3'=> $oldDBSupplier->VendorAddressAddr4 ?? '',
                'city'=> $oldDBSupplier->VendorAddressCity ?? '',
                'postal_code' => $oldDBSupplier->VendorAddressPostalCode ?? '',
                'country_id'=> $country?->id ?? null,
            ]);

            SupplierAddress::create([
                'supplier_id' => $supplier->id,
                'address_id' => $address->id
            ]);
        });
    }
}
