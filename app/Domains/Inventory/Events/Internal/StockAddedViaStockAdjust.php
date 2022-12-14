<?php

namespace App\Domains\Inventory\Events\Internal;

class StockAddedViaStockAdjust extends \Spatie\EventSourcing\StoredEvents\ShouldBeStored
{
    public string $unit;
    public float $quantity;
    public ?string $reason;
    public int $userId;
    public array $invoices;

    public function __construct(string $unit, float $quantity, int $userId, ?string $reason = null, array $invoices)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->userId = $userId;
        $this->reason = $reason;
        $this->invoices = $invoices;
    }
}
