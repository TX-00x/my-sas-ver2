<?php

namespace App\Actions\DataMigration;

use App\Models\Country;
use App\Models\Customer;
use App\Models\ItemType;
use App\Models\MySas\Factory;
use App\Models\MySas\Style;
use App\Models\MySas\Warehouse;
use App\Models\Size;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\DB;

class StyleCodeMigrationAction
{
    public function execute()
    {
        $output = new ConsoleOutput();

        $mysasStyleCodes = Style::with('category')->get();
        $progress = new ProgressBar($output, Style::count());
        $progress->start();

        $total_records_migrated = DB::transaction(function () use ($mysasStyleCodes, $progress) {
            $total_records_migrated = 0;
            foreach ($mysasStyleCodes as $mysasStyle) {

                $customer_id = null;
                if ($mysasStyle->customer_id) {
                    $customer_name = $mysasStyle->customer->company;
                    $customer = Customer::where('name', $customer_name)->first();
                    if ($customer) {
                        $customer_id = $customer->id;
                    }
                }

                $type_id = null;
                if ($mysasStyle->category) {
                    $category_name = $mysasStyle->category->title;
                    $item_type = ItemType::where('name',$category_name)->first();
                    if (!$item_type) {
                        $item_type = ItemType::create([
                            'name' => $category_name
                        ]);
                    }
                    $type_id = $item_type->id;
                }


                $data = [
                    'code' => $mysasStyle->code,
                    'name' => $mysasStyle->title,
                    'production_time' => $mysasStyle->production_time,
                    'customer_id' => $customer_id,
                    'type_id' => $type_id,
                    'description' => $mysasStyle->description,
                    'belongs_to' => 'external',
                    'status' => $mysasStyle->active == 1 ? 'active': 'inactive',
                ];


                if (!(\App\Models\Style::where('code',$mysasStyle->code)->first())) {

                    $style = \App\Models\Style::create($data);

                    foreach ($mysasStyle->sizes as $mysasSize) {

                        $size = Size::where('name',$mysasSize->size)->first();
                        if (!$size) {
                            $size = Size::create([
                                'name' => $mysasSize->size,
                                'slug' => Str::slug($mysasSize->size)
                            ]);
                        }
                        $style->sizes()->syncWithoutDetaching([$size->id]);
                    }
                }





                //dd($mysasStyle->category);
                //dd($mysasStyle->customer);
                //dd($mysasStyle->sports);
                //dd($mysasStyle->sizes);

                $progress->advance();
            }

            return $total_records_migrated;
        });


        $progress->finish();
        return $total_records_migrated;
    }
}
