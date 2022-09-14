<?php

namespace App\Models;

use App\Domains\Stock\Models\StockOutItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOutItemsInvoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stockOutItem()
    {
        return $this->belongsTo(StockOutItem::class);
    }

    public function invoice()
    {
        return $this->belongsTo(MaterialInvoice::class);
    }
}
