<?php

namespace App\Domains\Stock\Dtos;

use App\Models\MaterialInvoice;
use Spatie\DataTransferObject\DataTransferObject;

class StockOutItemInvoiceData extends DataTransferObject
{
    public MaterialInvoice $invoice;
    public float $usage;

    public static function fromRequest(array $data): StockOutItemInvoiceData
    {
        return new self([
            'invoice' => isset($data['invoice']['id']) ? MaterialInvoice::findOrFail($data['invoice']['id']) : null,
            'usage' => $data['usage']
        ]);
    }
}
