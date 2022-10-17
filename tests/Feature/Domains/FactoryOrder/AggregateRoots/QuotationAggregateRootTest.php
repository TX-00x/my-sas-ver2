<?php
declare(strict_types=1);

namespace Tests\Feature\Domains\FactoryOrder\AggregateRoots;

use App\Domains\FactoryOrder\AggregateRoots\QuotationAggregateRoot;
use App\Domains\FactoryOrder\Data\QuotationCreateData;
use App\Domains\FactoryOrder\Data\QuotationCreateEmbellishmentData;
use App\Domains\FactoryOrder\Data\QuotationFreightData;
use App\Domains\FactoryOrder\Data\QuotationItemData;
use App\Domains\FactoryOrder\Events\Internal\QuotationCreated;
use Illuminate\Support\Str;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;
use Spatie\EventSourcing\StoredEvents\StoredEvent;
use Tests\TestCase;

class QuotationAggregateRootTest extends TestCase
{
    public function test_create_quotation(): void
    {
        $quotationData = new QuotationCreateData(
            customerId: 1,
            salesAgentId: 2,
            customerSalesAgentId: 3,
            type: 'generic',
            club: 'School',
            attentionPerson: 'Foo person name',
            deliveryAddress: '1 foo address, country',
            items: [
                new QuotationItemData(
                    styleCodeId: 1,
                    categoryId:1,
                    quantity: 10,
                    priceType:'default',
                    unitPrice:12.10,
                    totalUnitPrice:100.22,
                    embellishmentType:'cut_and_sew',
                    embellishments: [
                        new QuotationCreateEmbellishmentData(
                            position: 'left',
                            quantity:10,
                            cost:5.99,
                            totalEmbellishmentCost: 50.90,
                            setupQuantity:1,
                            setupCost:1.99,
                            totalSetupCost:1.99,
                            totalCost:20.99
                        )
                    ],
                    note: null,
                    embellishmentCostTotal:9999.99
                )
            ],
            freight: new QuotationFreightData(
                unitAmount: 10.23,
                boxCount:1,
                surgePercentage: 6.34,
                surgeAdded: false,
                totalAmount:10.99,
            ),
            itemsNetPrice:100.50,
            grossAmount:120.99,
        );

        QuotationAggregateRoot::fake()
            ->when(function (QuotationAggregateRoot $quotationAggregateRoot) use ($quotationData) {
                $quotationAggregateRoot->createQuotation($quotationData);
            })->assertRecorded(new QuotationCreated($quotationData));
    }
}
