<?php

namespace App\Http\Resources\Quotation;

use App\Http\Resources\StyleResource;
use App\Supports\NumberFormatHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    use NumberFormatHelper;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'style' => new StyleResource($this->style),
            'quantity' => $this->quantity,
            'unit_price' => $this->floatWith2DecimalPoints($this->unit_price),
            'unit_price_total' => $this->floatWith2DecimalPoints($this->unit_price_total),
            'embellishment_total' => $this->floatWith2DecimalPoints($this->embellishment_total),
            'production_type' => $this->production_type,
            'note' => $this->note,
            'gross_total' => $this->floatWith2DecimalPoints($this->item_gross_total),
        ];
    }
}
