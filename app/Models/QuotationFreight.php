<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuotationFreight extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function defaultFreightCost(): BelongsTo
    {
        return $this->belongsTo(FreightCharge::class, 'freight_charge_id');
    }
}
