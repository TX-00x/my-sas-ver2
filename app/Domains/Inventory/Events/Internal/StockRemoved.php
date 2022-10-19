<?php

namespace App\Domains\Inventory\Events\Internal;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class StockRemoved extends ShouldBeStored
{
    public string $unit;
    public float $quantity;
    public int $stylePanelId;
    public string $outOrderId;
    public int $userId;
    public array $invoices;

    public function __construct(int $userId, string $unit, float $quantity,int $stylePanelId, string $outOrderId, array $invoices)
    {
        $this->userId = $userId;
        $this->outOrderId = $outOrderId;
        $this->stylePanelId = $stylePanelId;
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->invoices = $invoices;
    }

}
