<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Inventory\Actions\AdjustStock;
use App\Domains\Inventory\Actions\IncreaseAvailableQuantity;
use App\Models\InventoryIn;
use App\Models\MaterialInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InventoryAdjustmentController
{
    public function store(
        AdjustStock       $adjustStock,
        MaterialInventory $inventory,
        Request           $request
    ) {
        try {
            $validator = Validator::make($request->all(), [
                'invoice_usages' => 'required|array',
                'invoice_usages.*.usage' => 'required|numeric|not_in:0',
                'reason' => 'required'
            ]);

            if ($validator->fails()) {
                Session::flash('message', $validator->messages()->first());
                return back()->withInput()->withErrors(['message' => $validator->messages()->first()]);
            }

            $adjustStock->execute(
                inventory: $inventory,
                invoice: null,
                invoicesUsages: $request->input('invoice_usages'),
                adjustByAddingStock: $request->adjustByAddingStock,
                userId: auth()->user()->id,
                reason: $request->input('reason')
            );

            Session::flash('message', 'Stock adjusted successfully');
            return Redirect::route('inventory.show', ['materialInventory' => $inventory->id])
                ->with(['message', 'Stock adjusted successfully']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}
