<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quotation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function freight(): HasOne
    {
        return $this->hasOne(QuotationFreight::class);
    }

    public function sales_agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_agent_id');
    }

    public function customer_agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_agent_id');
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function sales_action_taken_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_action_taken_by_id');
    }

    public function customer_action_taken_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_action_taken_by_id');
    }
}
