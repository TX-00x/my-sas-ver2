<?php


namespace App\Http\Controllers;


use App\Domains\PurchaseOrder\Actions\ApprovePurchaseOrderAction;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\Http\RedirectResponse;

class ApprovePurchaseOrderController extends Controller
{
    public function __invoke(MaterialPurchaseOrder $materialPurchaseOrder): RedirectResponse
    {
        try {

            (new ApprovePurchaseOrderAction())->execute($materialPurchaseOrder);

            return redirect()->route('purchase.orders.index',['status' => 'Pending'])
                ->with('message', "The purchase order has been approved successfully.");

        } catch (\Exception $ex) {
            return redirect()->route('purchase.orders.index')
                ->with('message', "The purchase order has been failed approved.");
        }

    }
}
