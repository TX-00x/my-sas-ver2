<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create a new quotation
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Customer information</h4>
                    </div>
                    <div class="p-5">
                        <customer-information
                            :customer-options="customerOptions"
                            :prop-sales-agents="propSalesAgents"
                            :prop-customer-support-agents="propCustomerSupportAgents"
                            v-model="form"
                        ></customer-information>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Payment scheme</h4>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-row">
                            <div class="px-2">
                                <el-checkbox v-model="form.payment_term_20" label="Send payment on 20th of the month"></el-checkbox>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Quotation Items</h4>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Style Name
                            </th>

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity
                            </th>

                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Cost
                            </th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="item in form.items">
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.style_code.code}}
                                    </div>
                                </td>

                                <td class="px-6 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.quantity}}
                                    </div>
                                </td>

                                <td class="px-6 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.gross_price}}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Add items</h4>
                    </div>
                    <div class="p-5 mt-10">
                        <quotation-items
                            v-model="form.items"
                            :prop-categories="propCategories"
                            :prop-style-codes="propStyleCodes"
                            :prop-embellishments="propEmbellishments"
                            :prop-acoount-payment="true"
                        >
                        </quotation-items>
                    </div>
                </div>


                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Freight charges</h4>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-row justify-start">
                            <div class="grid grid-cols-5 gap-3">
                                <div>
                                    <div>
                                        <label for="region" class="block">Region</label>
                                    </div>
                                    <el-select value-key="id" v-model="form.freight" placeholder="Region">
                                        <el-option
                                            v-for="freight in propFreightCharges"
                                            :key="freight.id"
                                            :label="freight.region"
                                            :value="freight"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                                <div>
                                    <div>
                                        <label for="cost_per_region" class="block">Cost per region</label>
                                    </div>
                                    <div class="text-sm text-left"><span class="text-lg">NZD {{ form.freight.amount }}</span></div>
                                </div>
                                <div>
                                    <div>
                                        <label for="no_of_boxes" class="block">No of boxes</label>
                                    </div>
                                    <el-input-number placeholder="No of boxes" :min="0" v-model="form.freightBoxesCount"></el-input-number>
                                </div>
                                <div class="text-sm text-center">
                                    <div>
                                        <label for="total_freight_charge" class="block">Total freight charge</label>
                                    </div>
                                    <span class="text-lg">NZD {{ form.totalFreightCost = totalFreightCost}}</span>
                                </div>
                                <div>
                                    <el-checkbox v-model="form.freightSurgeAdded" label="Apply 6% air freight surcharge"></el-checkbox>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Final Quotation</h4>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-row justify-end">
                            <div class="text-sm text-center px-2">
                                Total quotation charge (incl. 15% GST) : <span class="text-lg">NZD {{ form.gross_price }}</span>
                            </div>
                            <div @click="save" class="px-2">
                                <el-button type="primary">Save</el-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import CustomerInformation from "@/Pages/Quotations/Components/CustomerInformation";
import QuotationItems from "@/Pages/Quotations/Components/QuotationItems";


export default {
    name: "Create",
    components: {
        CustomerInformation,
        QuotationItems,
    },
    props: {
        customerOptions:{
            type: Array,
            required: true
        },
        propSalesAgents: {
            type: Array,
            required: true
        },
        propCustomerSupportAgents: {
            type: Array,
            required: true
        },
        propStyleCodes: {
            type: Array,
            required: true
        },
        propCategories: {
            type: Array,
            required: true
        },
        propEmbellishments: {
            type: Array,
            required: true
        },
        propFreightCharges: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                customer_id: null,
                sales_agent_id: null,
                customer_service_agent_id: null,
                type: null,
                club: null,
                attention_person: null,
                delivery_address: null,
                freight:  {amount: 0},
                freightBoxesCount: 0,
                freightSurgePercentageAmount: 6,
                freightSurgeAdded: false,
                totalFreightCost: 0,
                items_net_price: 0,
                gross_price: 0,
                items: [],
                payment_term_20: false,
            }),
        }
    },
    methods: {
        save() {
            this.form.post(route('quotations.store'))
        },
    },
    watch: {
        updatedQuotation: {
            deep: true,
            handler(quotation) {
                // Calculate items total
                let itemsTotalPrice = 0;
                this.form.items.forEach(item => {
                    itemsTotalPrice = itemsTotalPrice + item.gross_price;
                })
                this.form.items_net_price = itemsTotalPrice;

                // Calculate gross price
                this.form.gross_price = this.form.items_net_price + this.form.totalFreightCost;
            }
        }
    },
    computed: {
        totalFreightCost() {
            let total = this.form.freight.amount * this.form.freightBoxesCount
            if (this.form.freightSurgeAdded) {
                total = total + (total *  (this.form.freightSurgePercentageAmount / 100) )
            }

            return total;
        },
        updatedQuotation() {
            return this.form;
        }
    },
}
</script>

<style scoped>

</style>
