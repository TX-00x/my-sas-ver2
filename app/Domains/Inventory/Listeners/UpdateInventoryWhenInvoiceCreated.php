<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Listeners;

use App\Domains\Inventory\Actions\AdjustStock;
use App\Domains\Inventory\Actions\InventoryCreate;
use App\Domains\Inventory\AggregateRoots\InventoryAggregateRoot;
use App\Domains\Inventory\Repositories\InventoryRepository;
use App\Domains\Invoices\Events\InvoiceCreated;
use App\Models\MaterialInvoiceItem;
use App\Models\Supplier;
use Illuminate\Support\Str;

class UpdateInventoryWhenInvoiceCreated
{
    private InventoryRepository $inventoryRepository;

    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function handle(InvoiceCreated $invoiceCreated)
    {
        $invoiceCreated->invoice->loadMissing(['items']);
        $invoice = $invoiceCreated->invoice;

        $invoice->items->each(function (MaterialInvoiceItem $invoiceItem) use ($invoiceCreated) {
            $material = $this->inventoryRepository->getMaterial(
                $invoiceItem->material_variation_id,
                $invoiceCreated->invoice->supplier_id,
                $invoiceCreated->invoice->factory_id,
            );

            $materialNotCreated = $material === null;
            $inventoryAggregateRoot = InventoryAggregateRoot::retrieve($materialNotCreated ? Str::uuid()->toString() : $material->aggregate_id );

            if ($materialNotCreated) {
                $inventoryAggregateRoot->createMaterial(
                    $invoiceItem->material_variation_id,
                    $invoiceCreated->invoice->supplier_id,
                    $invoiceCreated->invoice->factory_id,
                    auth()->user()->id
                );
            }

            $inventoryAggregateRoot->addStock(
                $invoiceItem->unit,
                $invoiceItem->quantity,
                $invoiceItem->id,
                $invoiceItem->unit_price,
                $invoiceItem->currency,
                auth()->user()->id,
            );

            $inventoryAggregateRoot->persist();
        });
    }
}
