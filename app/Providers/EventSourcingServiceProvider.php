<?php

namespace App\Providers;

use App\Domains\FactoryOrder\Reactors\QuotationReactor;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function register()
    {
        Projectionist::addReactor(QuotationReactor::class);
    }
}
