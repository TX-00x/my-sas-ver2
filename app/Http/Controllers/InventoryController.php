<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Factory;
use App\Models\InventoryIn;
use App\Models\InventoryLog;
use App\Models\InventoryReserv;
use App\Models\InventorySummary;
use App\Models\MaterialInventory;
use App\Models\MaterialInvoice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $factories = Factory::all()->toArray();

        if (!$request->has('factory')) {
            return redirect()->route('inventory.index', ['factory' => 1]);
        }

        $q = $request->get('q');


        $inventories = MaterialInventory::with(['variation.material', 'variation.colour'])
            ->where('factory_id', '=', $request->get('factory'))
            ->when($q, function ($query, $q) {
                $query
                    ->whereHas('variation.material', function ($query) use ($q) {
                        $query->where('name', 'LIKE', "%$q%");
                    })->orWhereHas('variation.colour', function ($query) use ($q) {
                        $query->where('name', 'LIKE', "%$q%");
                    })->orWhereHas('supplier', function ($query) use ($q) {
                        $query->where('name', 'LIKE', "%$q%");
                    });

            })
            ->paginate(15)
            ->withQueryString()
            ->through(function ($inventory) {
                return [
                    'id' => $inventory->id,
                    'unit' => $inventory->unit,
                    'available_quantity' => $inventory->available_quantity,
                    'allocated_quantity' => $inventory->allocated_quantity,
                    'usable_quantity' => $inventory->usable_quantity,
                    'factory_id' => $inventory->factory_id,
                    'material_name' => $inventory->variation->material->name,
                    'color_name' => $inventory->variation->colour->name,
                    'supplier_name' => $inventory->supplier->name,
                ];
            });


        return Inertia::render('Inventory/InventoryIndex',
            [
                'factories' => $factories,
                'inventory' => $inventories
            ]
        );
    }

    public function show(MaterialInventory $materialInventory, Request $request)
    {
        $invoices = MaterialInvoice::query()->select('id','invoice_number')->get();

        $totalValue = InventorySummary::query()
            ->where('material_inventory_id', $materialInventory->id)
            ->sum('total_price');

        return Inertia::render('Inventory/InventoryShow',
            [
                'inventory' => $materialInventory->loadMissing(['variation.material', 'variation.colour']),
                'totalValue' => $totalValue,
                'invoices' => $invoices,
                'stockIn' => InventoryLog::query()
                    ->where('material_inventories_aggregate_id', $materialInventory->aggregate_id)
                    ->with('invoiceItem.invoice')
                    ->paginate(15)
                    ->withQueryString(),
            ]
        );
    }

    public function viewInvoiceDetails(MaterialInventory $materialInventory, Request $request)
    {
        return Inertia::render('Inventory/InventorySummary', [
            'material' => $materialInventory->loadMissing(['variation.material', 'variation.colour']),
            'inventorySummary' => InventorySummary::query()
                ->where('material_inventory_id', $materialInventory->id)
                ->with('materialInvoice')
                ->orderBy('updated_at', 'DESC')
                ->paginate(15)
                ->withQueryString(),
        ]);
    }
}
