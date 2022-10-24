<?php


namespace App\Domains\Stock\Models;


use App\Models\Colour;
use App\Models\Materials;
use App\Models\StockOutItemsInvoice;
use App\Models\Style;
use App\Models\StylePanel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class StockOutItem extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];


    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class, 'style_id');
    }

    public function stylePanel(): BelongsTo
    {
        return $this->belongsTo(StylePanel::class, 'style_panel_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Materials::class, 'material_id');
    }

    public function colour(): BelongsTo
    {
        return $this->belongsTo(Colour::class, 'colour_id');
    }

    public function invoices()
    {
        return $this->hasMany(StockOutItemsInvoice::class);
    }
}
