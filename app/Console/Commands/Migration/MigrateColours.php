<?php

namespace App\Console\Commands\Migration;

use App\Models\Colour;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateColours extends Command
{
    protected $signature = 'data-migrate:colours';

    protected $description = 'Migrate colours from old database to new';

    public function handle()
    {
        $colours = DB::connection('old_database')
            ->table('colour')
            ->get();

        $colours->each(function ($colour) {
            $colourExist = Colour::query()
                ->where(DB::raw('LCASE(REPLACE(name, " ", ""))'), strtolower(str_replace(' ', '', $colour->Colour)))
                ->get();
            if ($colourExist->count() > 0) {
                $this->warn('[!] Colour '. $colour->Colour. ' already exists. skipping !');
                return;
            }

            Colour::create([
                'name' => $colour->Colour,
                'type' => 'fabric',
                'is_active' => true
            ]);
        });
        $this->info('');
        $this->info('[✓] All Colours seeded');
    }
}
