<?php

namespace Database\Seeders;

use App\Domains\FactoryOrder\Actions\CreateQuotation;
use App\Domains\FactoryOrder\Data\QuotationCreateData;
use App\Domains\FactoryOrder\Data\QuotationCreateEmbellishmentData;
use App\Domains\FactoryOrder\Data\QuotationFreightData;
use App\Domains\FactoryOrder\Data\QuotationItemData;
use App\Models\Category;
use App\Models\Embellishment;
use App\Models\FreightCharge;
use App\Models\Quotation;
use App\Models\Style;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Predis\Configuration\Option\Aggregate;

class QuotationSeeder extends Seeder
{
    public function run()
    {
        $embellishment1 = Embellishment::find(1);
        $embellishment2 = Embellishment::find(2);
        $embellishment3 = Embellishment::find(3);
        $embellishment4 = Embellishment::find(4);
        $embellishment5 = Embellishment::find(5);
        $embellishment6 = Embellishment::find(6);
        $embellishment7 = Embellishment::find(7);
        $embellishments = [
            $this->createEmbellishmentData($embellishment1, 'left', 3, 2),
            $this->createEmbellishmentData($embellishment2, 'right', 1, 2),
            $this->createEmbellishmentData($embellishment3, 'top', 3, 2),
            $this->createEmbellishmentData($embellishment4, 'bottom', 2, 2),
            $this->createEmbellishmentData($embellishment5, 'left', 0, 0),
            $this->createEmbellishmentData($embellishment6, 'left', 1, 2),
            $this->createEmbellishmentData($embellishment7, 'left', 2, 2),
        ];

        $style001 = StyleSeeder::findTee001();
        $style002 = StyleSeeder::findTee002();
        $items = [
            $this->createItemData($style001->id, Category::find(1)->id, 10, 'custom', 12.42, 'cut_and_sew', $embellishments, ''),
            $this->createItemData($style002->id, Category::find(1)->id, 12, 'custom', 16.99, 'cut_and_sew', $embellishments, ''),
        ];

        $freight = FreightCharge::find(1);
        $data = new QuotationCreateData(
            aggregateId: Str::uuid()->toString(),
            createdById: UserSeeder::getCustomerAgentUser1()->id,
            customerId: CustomerSeeder::customer1()->id,
            salesAgentId: UserSeeder::getSalesUser1()->id,
            customerSalesAgentId: UserSeeder::getCustomerAgentUser1()->id,
            type:  'general',
            club:  'club',
            attentionPerson:  'Keith Shawn',
            deliveryAddress:  '22 fake address by, Fake City',
            items: $items,
            freight: new QuotationFreightData(
                freightId: $freight->id,
                unitAmount: $freight->amount,
                boxCount:2,
                surgePercentage: 6,
                surgeAdded: true,
                totalAmount: 0.0, // will get overriden when creating
            ),
            paymentTerm20: false,
            itemsNetPrice: 0.0, // will get overriden when creating
            grossAmount: 0.0,// will get overriden when creating
        );

        /** @var CreateQuotation $action */
        $action = resolve(CreateQuotation::class);
        $action->execute($data);
    }

    private function createEmbellishmentData($embellishment, $position, $quantity, $setupQuantity): QuotationCreateEmbellishmentData
    {
        return new QuotationCreateEmbellishmentData(
            embellishmentId: $embellishment->id,
            position: $position,
            quantity: $quantity,
            cost: (float)$embellishment->cost,
            totalEmbellishmentCost: $quantity * $embellishment->cost,
            setupQuantity: (int) $setupQuantity,
            setupCost: (float) $embellishment->setup_cost,
            totalSetupCost: $setupQuantity * $embellishment->setup_cost,
            totalCost: ($quantity * $embellishment->cost) + ($setupQuantity * $embellishment->setup_cost),
        );
    }

    private function createItemData(int $styleCodeId, int $categoryId, int $quantity, string $priceType, float $unitPrice, string $productionType, array $embellishments, string $note): QuotationItemData
    {
        return new QuotationItemData(
            styleCodeId: $styleCodeId,
            categoryId: $categoryId,
            quantity: (int) $quantity,
            priceType: $priceType,
            unitPrice: (float) $unitPrice,
            totalUnitPrice: (float) $quantity * $unitPrice,
            embellishmentType: $productionType,
            embellishments: $embellishments,
            note: $note,
            embellishmentCostTotal: 0.0, // this will get overiden when creating
        );
    }
}
