<?php

namespace App\Domains\Inventory\Events\Internal;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class InventoryMaterialAdded extends ShouldBeStored
{
    public int $variationId;
    public int $userId;
    public int $supplierId;
    public int $factoryId;

    public function __construct(int $variationId, int $supplierId, int $factoryId, $userId)
    {
        $this->variationId = $variationId;
        $this->userId = $userId;
        $this->supplierId = $supplierId;
        $this->factoryId = $factoryId;
    }
}
