<?php

namespace App\Http\Resources;

use App\Http\Resources\Quotation\CustomerResource;
use App\Http\Resources\Quotation\FreightResource;
use App\Http\Resources\Quotation\ItemResource;
use App\Supports\NumberFormatHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
{
    use NumberFormatHelper;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => 'Q-'. $this->id,
            'created_at' => $this->created_at->toDateTimeString(),
            'customer' => new CustomerResource($this->customer),
            'items' => ItemResource::collection($this->whenLoaded('items')),
            'freight' => new FreightResource($this->freight),
            'gross_amount' => $this->floatWith2DecimalPoints($this->quotation_gross_amount),
            'sales_agent' => new UserResource($this->sales_agent),
            'customer_agent' => new UserResource($this->customer_agent),
            'created_by' => new UserResource($this->created_by),
        ];
    }
}
