<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FreightChargesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'region' => $this->region,
            'amount' => $this->amount,
            'gst_included' => (bool) $this->gst_include,
        ];
    }
}
