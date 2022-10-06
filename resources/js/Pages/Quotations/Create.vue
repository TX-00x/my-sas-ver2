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
                            :club-options="club_options"
                            @customer-selected="customerSelected"
                            @cs-selected="csPersonSelected"
                            @sales-selected="salesPersonSelected"
                            @quote-type-selected="quoteTypeSelected"
                            @attention-person="onChangeAttentionPersonName"
                            @delivery-address="onChangeDeliveryAddress"
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
                                <el-checkbox v-model="account_payment" label="Send payment on 20th of the month"></el-checkbox>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Quotation Items</h4>
                    </div>

                    <div class="p-5">
                        <quotation-items
                            :category-options="category_options"
                            :style-code-options="style_code_options"
                            :acoount-payment="account_payment"
                            @style-selected="onChangeStyleCode"
                            @category-selected="onChangeCategory"
                            @garment-qty="onChangeGarmentQuantity"
                            @garment-price-selected="onChangeGarmentPriceType"
                            @setup-cost-table="onChangeEmbellishmentOptions"
                            @quotation-notes="onChangeQuotationNotes"
                            @garment-price="onChangeGarmentPrice"
                            @cut-and-sew-table="onChangeCutAndSewTable"
                            @sublimations-table="onChangeSublimationsTable"
                        ></quotation-items>

                        <div class="py-2 flex flex-row justify-between">
                            <el-button type="danger" plain>Reset table</el-button>
                            <el-button type="primary">Add</el-button>
                        </div>

                        <div id="cut_and_show_selected_items" class="flex flex-row justify-center" v-if="show_cut_and_sew_table">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Style code
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Production
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total product price
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Embellishment price
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font

                                        -medium text-gray-500 uppercase tracking-wider">
                                        Final price
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr></tr>
                                    <tr>
                                        <td class="px-6 py-3 text-sm" colspan="3"></td>
                                        <td class="px-6 py-3 text-sm">
                                            <div class="text-sm font-medium text-gray-900 w-full">
                                                Total of product price: <span class="text-lg">$0.00</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-sm">
                                            <div class="text-sm font-medium text-gray-900">
                                                Total of embellishment price: <span class="text-lg">$0.00</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-3 text-sm">
                                            <div class="text-sm font-medium text-gray-900">
                                                Total garment price: <span class="text-lg">$0.00</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div id="sublimation_selected_items" class="flex flex-row justify-center" v-if="show_sublimation_table">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Style code
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Production
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total product price
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Embellishment price
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Final price
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr></tr>
                                <tr>
                                    <td class="px-6 py-3 text-sm" colspan="3"></td>
                                    <td class="px-6 py-3 text-sm">
                                        <div class="text-sm font-medium text-gray-900 w-full">
                                            Total of product price: <span class="text-lg">$0.00</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-sm">
                                        <div class="text-sm font-medium text-gray-900">
                                            Total of embellishment price: <span class="text-lg">$0.00</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-sm">
                                        <div class="text-sm font-medium text-gray-900">
                                            Total garment price: <span class="text-lg">$0.00</span>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


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
                                    <el-select v-model="selected_freight_charge_region" placeholder="Region">
                                        <el-option
                                            v-for="item in freight_charge_region"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div>
                                    <div class="text-sm text-center">Cost per region: <span class="text-lg">$0.00</span></div>
                                </div>
                                <div>
                                    <el-input placeholder="No of boxes" type="number" v-model.number="number_of_boxes"></el-input>
                                </div>
                                <div class="text-sm text-center">
                                    Total freight charge: <span class="text-lg">$0.00</span>
                                </div>
                                <div>
                                    <el-checkbox v-model="surcharge_applied" label="Apply 6% air freight surcharge"></el-checkbox>
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
                                Total quotation charge (incl. 15% GST) : <span class="text-lg">$0.00</span>
                            </div>
                            <div class="px-2">
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
        QuotationItems
    },
    props: {
        customerOptions:{
            type: Array,
            required: true
        }
    },
    data() {
        return {
            selected_customer_id: null,
            selected_cs_person_id: null,
            selected_sales_person_id: null,
            attention_person_name:'',
            delivery_address:'',
            selected_style_code: null,
            selected_category:null,
            garment_quantity: null,
            selected_garment_price: null,
            cut_and_sew_table: [],
            sublimations_table:[],
            style_code_options:[{
                value: 'style 1',
                label: 'Style 1'
            },{
                value: 'style 2',
                label: 'Style 2'
            }],
            category_options:[{
                value: 'category 1',
                label: 'Category 1'
            },{
                value: 'category 2',
                label: 'Category 2'
            }],
            club_options:[{
                value: 'club 1',
                label: 'Club 1'
            },{
                value: 'club 2',
                label: 'Club 2'
            }],
            quotation_type: '',
            selected_embellishment_type: '',
            selected_style_code_id:null,
            selected_category_id:null,
            show_cut_and_sew_table: false,
            show_sublimation_table: false,
            quotation_notes:'',
            editable_garment_price: false,
            garment_price_value: '',
            freight_charge_region:[{
                value: 'nothern region',
                label: 'Northern Region'
            }],
            selected_freight_charge_region: '',
            number_of_boxes: null,
            surcharge_applied: false,
            account_payment: false,
        }
    },
    methods: {
        customerSelected(value){
            this.selected_customer_id = value.id
        },
        csPersonSelected(value){
            this.selected_cs_person_id = value.id
        },
        salesPersonSelected(value){
            this.selected_sales_person_id = value.id
        },
        quoteTypeSelected(value){
            this.quotation_type = value
        },
        onChangeAttentionPersonName(value) {
            this.attention_person_name = value
        },
        onChangeDeliveryAddress(value) {
            this.delivery_address = value
        },
        onChangeStyleCode(value) {
            this.selected_style_code = value
        },
        onChangeCategory(value) {
            this.selected_category = value
        },
        onChangeGarmentQuantity(value) {
            this.garment_quantity = value
        },
        onChangeGarmentPriceType(value) {
            this.selected_garment_price = value
        },
        onChangeGarmentPrice(value) {
            this.garment_price_value = value
        },
        onChangeEmbellishmentOptions(value) {
            this.selected_embellishment_type = value
        },
        onChangeQuotationNotes(value){
            this.quotation_notes = value
        },
        onChangeCutAndSewTable(value) {
            this.cut_and_sew_table = value
        },
        onChangeSublimationsTable(value) {
            this.show_sublimation_table = value
        }
    },

}
</script>

<style scoped>

</style>
