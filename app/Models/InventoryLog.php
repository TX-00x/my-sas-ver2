<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['total_price'];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d-M-Y H:i:s');
    }

    public function getTotalPriceAttribute()
    {
        return $this->balance * $this->in_unit_price;
    }

    public function invoiceItem()
    {
        return $this->belongsTo(MaterialInvoiceItem::class, 'in_invoice_item_id');
    }
}
