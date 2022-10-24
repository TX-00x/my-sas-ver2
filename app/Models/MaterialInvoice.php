<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class MaterialInvoice extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];


    public function getInvoicedDateAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y H:i:s');
    }

    public function items(): HasMany
    {
        return $this->hasMany(MaterialInvoiceItem::class);
    }

    public function sawingFactory(): BelongsTo
    {
        return $this->belongsTo(Factory::class, 'factory_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

    public function inventoryLog()
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function inventorySummaries()
    {
        return $this->hasMany(InventorySummary::class);
    }
}
