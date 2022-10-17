<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuotationItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function embellishments(): HasMany
    {
        return $this->hasMany(QuotationItemEmbellishment::class);
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class);
    }
}
