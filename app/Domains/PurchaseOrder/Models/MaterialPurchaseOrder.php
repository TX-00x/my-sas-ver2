<?php

namespace App\Domains\PurchaseOrder\Models;

use App\Domains\PurchaseOrder\State\MaterialPurchaseOrderState;
use App\Models\Factory;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class MaterialPurchaseOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => MaterialPurchaseOrderState::class
    ];

    public function items(): HasMany
    {
        return $this->hasMany(MaterialPurchaseOrderItem::class);
    }

    public function factory(): BelongsTo
    {
        return $this->belongsTo(Factory::class, 'factory_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function getState(): MaterialPurchaseOrderState
    {
        return new $this->status($this);
    }
}
