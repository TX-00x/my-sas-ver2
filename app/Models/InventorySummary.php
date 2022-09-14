<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventorySummary extends Model
{
    use HasFactory, Timestamp;
    public $timestamps = true;

    protected $guarded = [];

    public function materialVariation()
    {
        return $this->belongsTo(MaterialVariation::class);
    }

    public function materialInvoice()
    {
        return $this->belongsTo(MaterialInvoice::class);
    }
}
