<?php

namespace App\Domains\Inventory\AggregateRoots;

use App\Domains\Inventory\Events\Internal\InventoryMaterialAdded;
use App\Domains\Inventory\Events\Internal\StockAdded;
use App\Domains\Inventory\Events\Internal\StockAddedViaStockAdjust;
use App\Domains\Inventory\Events\Internal\StockRemoved;
use App\Domains\Inventory\Events\Internal\StockRemovedViaStockAdjust;
use App\Domains\Inventory\Exceptions\InventoryException;
use App\Domains\Inventory\Repositories\InventoryRepository;
use App\Models\User;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class InventoryAggregateRoot extends AggregateRoot
{
    private InventoryRepository $inventoryRepository;
    public float $balance = 0;

    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function createMaterial(int $variationId, int $supplierId, int $factoryId, $userId)
    {
        if ($this->inventoryRepository->isMaterialExist($variationId, $supplierId, $factoryId)) {
            throw InventoryException::materialExists();
        }

        $this->recordThat(new InventoryMaterialAdded($variationId, $supplierId, $factoryId, $userId));

        return $this;
    }

    public function addStock(string $unit, float $quantity, ?int $invoiceItemId = null, ?float $unitPrice = null, ?string $currency = null, int $userId)
    {
        $this->recordThat(new StockAdded($unit, $quantity, $invoiceItemId, $unitPrice, $currency, $userId));

        return $this;
    }

    public function applyStockAdded(StockAdded $stockAdded)
    {
        $this->balance += $stockAdded->quantity;
    }

    public function removeStock(string $unit, float $quantity, int $stylePanelId, string $outOrderId, array $invoices, int $userId)
    {
        $this->recordThat(new StockRemoved(
            $userId,
            $unit,
            $quantity,
            $stylePanelId,
            $outOrderId,
            $invoices,
        ));
    }

    public function applyStockRemoved(StockRemoved $stockAdded)
    {
        $this->balance -= $stockAdded->quantity;
    }

    public function addStockViaStockAdjust(string $unit, float $quantity, int $userId, ?string $reason = null)
    {
        $this->recordThat(new StockAddedViaStockAdjust($unit, $quantity, $userId, $reason));

        return $this;
    }

    public function applyStockAddedViaStockAdjust(StockAddedViaStockAdjust $stockAddedViaStockAdjust)
    {
        $this->balance += $stockAddedViaStockAdjust->quantity;
    }

    public function removeStockViaStockAdjust(string $unit, float $quantity, int $userId, ?string $reason = null)
    {
        $this->recordThat(new StockRemovedViaStockAdjust($unit, $quantity, $userId, $reason));

        return $this;
    }

    public function applyStockRemovedViaStockAdjust(StockRemovedViaStockAdjust $stockRemovedViaStockAdjust)
    {
        $this->balance -= $stockRemovedViaStockAdjust->quantity;

        return $this;
    }
}
