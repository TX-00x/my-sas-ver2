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
            'number' => $this->number,
            'created_at' => $this->created_at->toDateTimeString(),
            'customer' => new CustomerResource($this->customer),
            'type' => $this->type,
            'club' => $this->club,
            'attention_person' => $this->attention_person,
            'items' => ItemResource::collection($this->whenLoaded('items')),
            'freight' => new FreightResource($this->freight),
            'gross_amount' => $this->floatWith2DecimalPoints($this->quotation_gross_amount),
            'sales_agent' => new UserResource($this->sales_agent),
            'customer_agent' => new UserResource($this->customer_agent),
            'created_by' => new UserResource($this->created_by),
            'requires_sales_approval' => $this->requires_sales_approval && $this->sales_action === null,
            'sales_action_taken_by' => new UserResource($this->sales_action_taken_by),
            'sales_action' => $this->sales_action,
            'sales_rejected_reason' => nl2br($this->sales_rejected_reason),
//            'customer_action_taken_by' => new UserResource($this->customer_action_taken_by),
            'customer_action' => $this->customer_action,
            'customer_rejected_reason' => $this->customer_rejected_reason,
            'customer_action_taken_at' => $this->customer_action_taken_at?->toDateTimeString(),
        ];
    }
}
