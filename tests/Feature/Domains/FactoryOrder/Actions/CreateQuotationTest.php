<?php

namespace Tests\Feature\Domains\FactoryOrder\Actions;

use App\Domains\FactoryOrder\Actions\CreateQuotation;
use App\Domains\FactoryOrder\Data\QuotationCreateData;
use App\Domains\FactoryOrder\Data\QuotationCreateEmbellishmentData;
use App\Domains\FactoryOrder\Data\QuotationFreightData;
use App\Domains\FactoryOrder\Data\QuotationItemData;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Embellishment;
use App\Models\FreightCharge;
use App\Models\Quotation;
use App\Models\Style;
use App\Models\User;
use Tests\TestCase;

class CreateQuotationTest extends TestCase
{
    public function test_it_creates_quotation()
    {
        $category = Category::factory()->create();
        $style = Style::factory()->create([
            'code' => 'style-001',
        ]);
        $style->categories()->attach($category->id);
        $customer = Customer::factory()->create();
        $salesAgent = User::factory()->create();
        $customerServiceAgent = User::factory()->create();

        $embellishment1 = Embellishment::factory()->create([
            'name' => 'Emb 1',
            'cost' => 4.99,
            'setup_cost' => 5.99
        ]);
        $embellishment2 = Embellishment::factory()->create([
            'name' => 'Emb 2',
            'cost' => 3.99,
            'setup_cost' => 6.99
        ]);
        $freight = FreightCharge::factory()->create([
            'region' => 'Auckland',
            'amount' => 6.99,
            'gst_included' => 1,
        ]);

        $quotationData = new QuotationCreateData(
            createdById: $customerServiceAgent->id,
            customerId: $customer->id,
            salesAgentI: $salesAgent->id,
            customerSalesAgentId: $customerServiceAgent->id,
            type: 'generic',
            club: 'School',
            attentionPerson: 'Foo person name',
            deliveryAddress: '1 foo address, country',
            items: [
                new QuotationItemData(
                    styleCodeId: $style->id,
                    categoryId: $category->id,
                    quantity: 10,
                    priceType:'default',
                    unitPrice:12.10,
                    totalUnitPrice:121,
                    embellishmentType:'cut_and_sew',
                    embellishments: [
                        new QuotationCreateEmbellishmentData(
                            embellishmentId: $embellishment1->id,
                            position: 'left',
                            quantity:10,
                            cost:$embellishment1->cost,
                            totalEmbellishmentCost: 49.9,
                            setupQuantity:2,
                            setupCost:$embellishment1->setup_cost,
                            totalSetupCost:11.98,
                            totalCost:61.88
                        ),
                        new QuotationCreateEmbellishmentData(
                            embellishmentId: $embellishment2->id,
                            position: 'right',
                            quantity:5,
                            cost:$embellishment2->cost,
                            totalEmbellishmentCost: 19.95, // 3.99 * 5
                            setupQuantity:2,
                            setupCost:$embellishment2->setup_cost, // 6.99 * 2
                            totalSetupCost:13.98,
                            totalCost:33.93 // 19.95 + 13.98
                        )
                    ],
                    note: null,
                    embellishmentCostTotal:95.81
                )
            ],
            freight: new QuotationFreightData(
                freightId: $freight->id,
                unitAmount: $freight->amount,
                boxCount:2,
                surgePercentage: 3.99,
                surgeAdded: true,
                totalAmount:10.99,
            ),
            itemsNetPrice:216.81,
            grossAmount:120.99,
        );


        /** @var CreateQuotation $action */
        $action = resolve(CreateQuotation::class);
        $action->execute($quotationData);

        $quotation = Quotation::first();
        $this->assertEquals($customer->id, $quotation->customer_id);
        $this->assertEquals($salesAgent->id, $quotation->sales_agent_id);
        $this->assertEquals($customerServiceAgent->id, $quotation->customer_agent_id);
        $this->assertEquals('generic', $quotation->type);
        $this->assertEquals('School', $quotation->club);
        $this->assertEquals('Foo person name', $quotation->attention_person);
        $this->assertEquals(216.81, $quotation->items_net_amount);
        $this->assertEquals(231.35, $quotation->quotation_gross_amount);
    }
}
