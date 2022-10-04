<?php

namespace App\Models\OldDatabase;

use Illuminate\Database\Eloquent\Model;

class OldSupplier extends Model
{
    protected $connection = 'old_database';
    protected $guarded = [];

    protected $table = 'suppliers';
}

