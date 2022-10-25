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
            'category_id' => $this->category_id,
            'style_code' => new StyleResource($this->style),
            'quantity' => $this->quantity,
            'unit_price' => $this->floatWith2DecimalPoints($this->unit_price),
            'unit_price_total' => $this->floatWith2DecimalPoints($this->unit_price_total),
            'embellishment_total' => $this->floatWith2DecimalPoints($this->embellishment_total),
            'embellishments' => $this->embellishments,
            'type' => $this->production_type,
            'price_type' => $this->price_type,
            'notes' => $this->note,
            'gross_price' => $this->floatWith2DecimalPoints($this->item_gross_total),
        ];
    }
}
