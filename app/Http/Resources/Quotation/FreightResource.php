<?php

namespace App\Http\Resources\Quotation;

use App\Http\Resources\FreightChargesResource;
use App\Supports\NumberFormatHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class FreightResource extends JsonResource
{
    use NumberFormatHelper;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cost' => $this->floatWith2DecimalPoints($this->freight_cost),
            'box_count' => $this->boxes_count,
            'surcharge' => $this->surcharge_percentage > 0 ? $this->surcharge_percentage.'%' : null,
            'total_cost' => $this->floatWith2DecimalPoints($this->total_freight_cost),
            'default_freight_costs' => new FreightChargesResource($this->defaultFreightCost),
        ];
    }
}
