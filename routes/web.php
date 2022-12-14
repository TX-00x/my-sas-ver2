<?php
declare(strict_types=1);

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ExternalStylesController;
use App\Http\Controllers\FactoryOrderController;
use App\Http\Controllers\InternalStylesController;
use App\Http\Controllers\CustomizedStylesController;
use App\Http\Controllers\InventoryAdjustmentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SettingsEmbellishmentsController;
use App\Http\Controllers\SettingsItemTypesController;
use App\Http\Controllers\MaterialSupplierController;
use App\Http\Controllers\NewCustomizedStylesController;
use App\Http\Controllers\SettingCategoriesController;
use App\Http\Controllers\SettingsColourController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SettingsCurrencyController;
use App\Http\Controllers\SettingsCurrencyExchangeRateController;
use App\Http\Controllers\SettingsFactoryController;
use App\Http\Controllers\SettingSizesController;
use App\Http\Controllers\SettingsMaterialController;
use App\Http\Controllers\SettingsWarehouseController;
use App\Http\Controllers\SettingsOutletController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\SupplierAddressController;
use App\Http\Controllers\SupplierContactsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomerContactsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    Route::get('/settings/factories', [SettingsFactoryController::class, 'index'])->name('settings.factories.index');
    Route::post('/settings/factories', [SettingsFactoryController::class, 'store'])->name('settings.factories.store');
    Route::get('/settings/factories/create', [SettingsFactoryController::class, 'create'])->name('settings.factories.create');
    Route::get('/settings/factories/{factory}/edit', [SettingsFactoryController::class, 'edit'])->name('settings.factories.edit');
    Route::put('/settings/factories/{factory}', [SettingsFactoryController::class, 'update'])->name('settings.factories.update');
    Route::delete('/settings/factories/{factory}', [SettingsFactoryController::class, 'delete'])->name('settings.factories.delete');


    Route::get('/settings/warehouses', [SettingsWarehouseController::class, 'index'])->name('settings.warehouses.index');
    Route::get('/settings/warehouses/create', [SettingsWarehouseController::class, 'create'])->name('settings.warehouses.create');
    Route::post('/settings/warehouses', [SettingsWarehouseController::class, 'store'])->name('settings.warehouses.store');
    Route::get('/settings/warehouses/{warehouse}/edit', [SettingsWarehouseController::class, 'edit'])->name('settings.warehouses.edit');
    Route::put('/settings/warehouses/{warehouse}', [SettingsWarehouseController::class, 'update'])->name('settings.warehouses.update');
    Route::delete('/settings/warehouses/{warehouse}', [SettingsWarehouseController::class, 'delete'])->name('settings.warehouses.delete');

    Route::get('/settings/outlets', [SettingsOutletController::class, 'index'])->name('settings.outlets.index');
    Route::get('/settings/outlets/create', [SettingsOutletController::class, 'create'])->name('settings.outlets.create');
    Route::post('/settings/outlets', [SettingsOutletController::class, 'store'])->name('settings.outlets.store');
    Route::get('/settings/outlets/{outlet}/edit', [SettingsOutletController::class, 'edit'])->name('settings.outlets.edit');
    Route::put('/settings/outlets/{outlet}', [SettingsOutletController::class, 'update'])->name('settings.outlets.update');
    Route::delete('/settings/outlets/{outlet}', [SettingsOutletController::class, 'delete'])->name('settings.outlets.delete');

    Route::get('/settings/materials', [SettingsMaterialController::class, 'index'])->name('settings.materials.index');
    Route::get('/settings/material/create', [SettingsMaterialController::class, 'create'])->name('settings.materials.create');
    Route::post('/settings/materials', [SettingsMaterialController::class, 'store'])->name('settings.materials.store');
    Route::get('/settings/materials/{materials}/edit', [SettingsMaterialController::class, 'edit'])->name('settings.materials.edit');
    Route::put('/settings/materials/{materials}', [SettingsMaterialController::class, 'update'])->name('settings.materials.update');
    Route::delete('/settings/materials/{materials}', [SettingsMaterialController::class, 'delete'])->name('settings.materials.delete');


    Route::get('/settings/colours', [SettingsColourController::class, 'index'])->name('settings.colours.index');
    Route::get('/settings/colours/create', [SettingsColourController::class, 'create'])->name('settings.colours.create');
    Route::post('/settings/colours', [SettingsColourController::class, 'store'])->name('settings.colours.store');
    Route::get('/settings/colours/{colour}/edit', [SettingsColourController::class, 'edit'])->name('settings.colours.edit');
    Route::put('/settings/colours/{colour}', [SettingsColourController::class, 'update'])->name('settings.colours.update');
    Route::delete('/settings/colours/{colour}', [SettingsColourController::class, 'delete'])->name('settings.colours.delete');

    Route::get('/settings/currency-exchange-rates', [SettingsCurrencyExchangeRateController::class, 'index'])->name('settings.currency-exchange-rates.index');
    Route::post('/settings/currency-exchange-rates', [SettingsCurrencyExchangeRateController::class, 'store'])->name('settings.currency-exchange-rates.store');
    Route::get('/settings/currency-exchange-rates/create', [SettingsCurrencyExchangeRateController::class, 'create'])->name('settings.currency-exchange-rates.create');
    Route::get('/settings/currency-exchange-rates/{currencyExchangeRate}/edit', [SettingsCurrencyExchangeRateController::class, 'edit'])->name('settings.currency-exchange-rates.edit');
    Route::put('/settings/currency-exchange-rates/{currencyExchangeRate}', [SettingsCurrencyExchangeRateController::class, 'update'])->name('settings.currency-exchange-rates.update');
    Route::delete('/settings/currency-exchange-rates/{currencyExchangeRate}', [SettingsCurrencyExchangeRateController::class, 'delete'])->name('settings.currency-exchange-rates.delete');

    Route::get('/settings/currencies', [SettingsCurrencyController::class, 'index'])->name('settings.currencies.index');
    Route::post('/settings/currencies', [SettingsCurrencyController::class, 'store'])->name('settings.currencies.store');
    Route::get('/settings/currencies/create', [SettingsCurrencyController::class, 'create'])->name('settings.currencies.create');
    Route::get('/settings/currencies/{currency}/edit', [SettingsCurrencyController::class, 'edit'])->name('settings.currencies.edit');
    Route::put('/settings/currencies/{currency}', [SettingsCurrencyController::class, 'update'])->name('settings.currencies.update');
    Route::delete('/settings/currencies/{currency}', [SettingsCurrencyController::class, 'delete'])->name('settings.currencies.delete');

    Route::get('/settings/sizes', [SettingSizesController::class, 'index'])->name('settings.sizes.index');
    Route::get('/settings/sizes/create', [SettingSizesController::class, 'create'])->name('settings.sizes.create');
    Route::post('/settings/sizes', [SettingSizesController::class, 'store'])->name('settings.sizes.store');
    Route::delete('/settings/sizes/{size}', function (){
        return back()->with(['message' => 'Not allowed']);
    })->name('settings.sizes.delete');

    Route::get('/settings/categories', [SettingCategoriesController::class, 'index'])->name('settings.categories.index');
    Route::get('/settings/categories/create', [SettingCategoriesController::class, 'create'])->name('settings.categories.create');
    Route::post('/settings/categories', [SettingCategoriesController::class, 'store'])->name('settings.categories.store');
    Route::delete('/settings/categories/{category}', function (){
        return back()->with(['message' => 'Not allowed']);
    })->name('settings.categories.delete');

    Route::get('/settings/item-types', [SettingsItemTypesController::class, 'index'])->name('settings.item-types.index');
    Route::get('/settings/item-types/create', [SettingsItemTypesController::class, 'create'])->name('settings.item-types.create');
    Route::post('/settings/item-types', [SettingsItemTypesController::class, 'store'])->name('settings.item-types.store');
    Route::delete('/settings/item-types/{itemType}', function (){
        return back()->with(['message' => 'Not allowed']);
    })->name('settings.item-types.delete');

    Route::get('/settings/embellishments', [SettingsEmbellishmentsController::class, 'index'])->name('settings.embellishments.index');
    Route::get('/settings/embellishments/create', [SettingsEmbellishmentsController::class, 'create'])->name('settings.embellishments.create');
    Route::post('/settings/embellishments', [SettingsEmbellishmentsController::class, 'store'])->name('settings.embellishments.store');

    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::put('/users/{user}/reset-password', [UsersController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('/users/deactivate', [UsersController::class, 'deactivateUser'])->name('users.deactivate');

    Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomersController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomersController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomersController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomersController::class, 'update'])->name('customers.update');
    Route::delete('/customer/{customer}', [CustomersController::class, 'delete'])->name('customers.delete');

    Route::post('/upload-logo', [FileUploadController::class, 'store'])->name('logo.create');
    Route::get('/get-logo/{id}', [FileUploadController::class, 'show'])->name('logo.show');

    Route::get('/customers/contacts/{customer}', [CustomerContactsController::class, 'show'])->name('customers.contacts.show');
    Route::post('/customers/contacts', [CustomerContactsController::class, 'store'])->name('customers.contacts.store');
    Route::put('/customers/contacts/{customerContact}', [CustomerContactsController::class, 'update'])->name('customers.contacts.update');
    Route::delete('/customers/contacts/{customerContact}', [CustomerContactsController::class, 'delete'])->name('customers.contacts.delete');

    Route::post('/customers/addresses', [AddressController::class, 'store'])->name('customers.addresses.store');
    Route::put('/customers/addresses/{address}', [AddressController::class, 'update'])->name('customers.addresses.update');
    Route::delete('/customers/addresses/{address}', [AddressController::class, 'delete'])->name('customers.addresses.delete');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/{materialInventory}/details', [InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/inventory/{materialInventory}/summary', [InventoryController::class, 'viewInvoiceDetails'])->name('inventory.summary');

    Route::get('/suppliers', [SuppliersController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SuppliersController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SuppliersController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{supplier}/edit', [SuppliersController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{supplier}', [SuppliersController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [SuppliersController::class, 'delete'])->name('suppliers.delete');

    Route::get('/suppliers/contacts/{supplier}', [SupplierContactsController::class, 'show'])->name('suppliers.contacts.show');
    Route::post('/suppliers/contacts', [SupplierContactsController::class, 'store'])->name('suppliers.contacts.store');
    Route::put('/suppliers/contacts/{supplierContact}', [SupplierContactsController::class, 'update'])->name('suppliers.contacts.update');
    Route::delete('/suppliers/contacts/{supplierContact}', [SupplierContactsController::class, 'delete'])->name('suppliers.contacts.delete');

    Route::post('/suppliers/addresses', [SupplierAddressController::class, 'store'])->name('suppliers.addresses.store');
    Route::put('/suppliers/addresses/{address}', [SupplierAddressController::class, 'update'])->name('suppliers.addresses.update');
    Route::delete('/suppliers/addresses/{address}', [SupplierAddressController::class, 'delete'])->name('suppliers.addresses.delete');

    Route::post('/suppliers/material-supplier', [MaterialSupplierController::class, 'store'])->name('suppliers.material-supplier.store');
    Route::put('/suppliers/material-supplier/{materialSupplier}', [MaterialSupplierController::class, 'update'])->name('suppliers.material-supplier.update');
    Route::delete('/suppliers/material-supplier/{materialSupplier}', [MaterialSupplierController::class, 'delete'])->name('suppliers.material-supplier.delete');


    Route::get('/invoices/create/{materialPurchaseOrder?}', [InvoicesController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoicesController::class, 'store'])->name('invoice.store');
    Route::get('/invoices/{invoice}', [InvoicesController::class, 'show'])->name('invoices.show');

    Route::post('/inventory/{inventory}/adjust', [InventoryAdjustmentController::class, 'store'])->name('inventory.adjust');

    Route::get('/internal-styles/create', [InternalStylesController::class, 'create'])->name('style.internal.create');
    Route::get('/external-styles/create', [ExternalStylesController::class, 'create'])->name('style.external.create');

    Route::get('/factory', [FactoryOrderController::class, 'index'])->name('factory.orders.index');
    Route::get('/factory/create', [FactoryOrderController::class, 'create'])->name('factory.orders.create');
    Route::post('/factory/order', [FactoryOrderController::class, 'store'])->name('factory.orders.store');
    Route::get('/factory/order/show', [FactoryOrderController::class, 'show'])->name('factory.orders.show');
    Route::get('/internal-styles/show/{style}', [InternalStylesController::class, 'show'])->name('style.internal.show');
    Route::get('/internal-styles/edit/{style}', [InternalStylesController::class, 'edit'])->name('style.internal.edit');
    Route::get('/internal-styles', [InternalStylesController::class, 'index'])->name('style.internal.index');
    Route::post('/internal-styles', [InternalStylesController::class, 'store'])->name('style.internal.store');
    Route::put('/internal-styles/{style}', [InternalStylesController::class, 'update'])->name('style.internal.update');

    Route::get('/customized-styles', [CustomizedStylesController::class, 'index'])->name('style.customized.index');
    Route::get('/customized-styles/create', [CustomizedStylesController::class, 'create'])->name('style.customized.create');
    Route::post('/customized-styles', [CustomizedStylesController::class, 'store'])->name('style.customized.store');
    Route::get('/customized-styles/edit/{style}', [CustomizedStylesController::class, 'edit'])->name('style.customized.edit');
    Route::put('/customized-styles/{style}', [CustomizedStylesController::class, 'update'])->name('style.customized.update');

    Route::get('/new-customized-styles', [NewCustomizedStylesController::class, 'index'])->name('style.new-customized.index');
    Route::get('/new-customized-styles/create', [NewCustomizedStylesController::class, 'create'])->name('style.new-customized.create');
    Route::post('/new-customized-styles', [NewCustomizedStylesController::class, 'store'])->name('style.new-customized.store');
    Route::get('/new-customized-styles/edit/{style}', [NewCustomizedStylesController::class, 'edit'])->name('style.new-customized.edit');
    Route::put('/new-customized-styles/{style}', [NewCustomizedStylesController::class, 'update'])->name('style.new-customized.update');

    Route::get('/external-styles/edit/{style}', [ExternalStylesController::class, 'edit'])->name('style.external.edit');
    Route::get('/external-styles', [ExternalStylesController::class, 'index'])->name('style.external.index');

    Route::get('/purchase-order/show-completed/{purchase_order}', [\App\Http\Controllers\PurchaseOrderController::class, 'showCompleted'])->withTrashed()->name('purchase.orders.completed');
    Route::resource('purchase-order', \App\Http\Controllers\PurchaseOrderController::class, ['names' => 'purchase.orders']);
    Route::post('/approve-purchase-order/{materialPurchaseOrder}', \App\Http\Controllers\ApprovePurchaseOrderController::class)->name('purchase.orders.approve');
    Route::post('/reject-purchase-order/{materialPurchaseOrder}', \App\Http\Controllers\RejectPurchaseOrderController::class)->name('purchase.orders.reject');
    Route::resource('stock-out', \App\Http\Controllers\StockOutController::class, ['names' => 'stock.out']);
});
