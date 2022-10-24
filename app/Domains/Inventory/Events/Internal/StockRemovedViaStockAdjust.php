<?php

namespace App\Domains\Inventory\Events\Internal;

class StockRemovedViaStockAdjust extends \Spatie\EventSourcing\StoredEvents\ShouldBeStored
{
    public string $unit;
    public float $quantity;
    public ?string $reason;
    public int $userId;
    public array $invoices;

    public function __construct(string $unit, float $quantity, int $userId, array $invoices, ?string $reason = null)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->userId = $userId;
        $this->invoices = $invoices;
        $this->reason = $reason;
    }
}
