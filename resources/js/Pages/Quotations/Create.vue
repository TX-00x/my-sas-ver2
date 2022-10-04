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
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <el-select class="w-full" v-model="selected_customer_id" placeholder="Select customer">
                                    <el-option
                                        v-for="item in customer_options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div>
                                <el-select class="w-full" v-model="selected_cs_person_id" placeholder="Select customer service person">
                                    <el-option
                                        v-for="item in cs_person_options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="flex flex-col justify-center items-center">
                                <div class="py-1">Quotation type</div>
                                <div>
                                    <el-radio class="py-1" v-model="quotation_type" label="General"></el-radio>
                                </div>
                                <div>
                                    <el-radio class="py-1" v-model="quotation_type" label="Funding"></el-radio>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <el-select class="w-full" v-model="selected_club_id" placeholder="Team/Club/School">
                                    <el-option
                                        v-for="item in club_options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div>
                                <el-select class="w-full" v-model="value" placeholder="Customer sales person">
                                    <el-option
                                        v-for="item in sales_persons_options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-3 py-8">
                            <div>
                                <el-input placeholder="Attention person name" v-model="input"></el-input>
                            </div>
                            <div>
                                <el-input
                                    type="textarea"
                                    :rows="2"
                                    placeholder="Delivery address"
                                    v-model="delivery_address">
                                </el-input>
                            </div>
                        </div>
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
                        <div class="grid grid-cols-4 gap-3">
                            <div>
                                <el-select v-model="selected_style_code_id" placeholder="Style code">
                                    <el-option
                                        v-for="item in style_code_options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div>
                                <el-select v-model="selected_category_id" placeholder="Category">
                                    <el-option
                                        v-for="item in category_options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div>
                                <el-input placeholder="Quantity" v-model.number="garment_quantity"></el-input>
                            </div>
                            <div>
                                <el-select @change="changeGarmentPrice" placeholder="Default Garment Price" v-model="selected_garment_price">
                                    <el-option
                                        v-for="item in garment_price"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-3 py-8">
                            <div>
                                <el-select @change="showSetUpCostTable" v-model="selected_embellishment_type" placeholder="Select embellishment type">
                                    <el-option
                                        v-for="item in embellishment_options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-span-2">
                                <el-input
                                    type="textarea"
                                    :rows="2"
                                    placeholder="Add notes"
                                    v-model="quotation_notes">
                                </el-input>
                            </div>
                            <div>
                                <div class="flex flex-col">
                                    <el-input :disabled="!editable_garment_price" placeholder="Garment price" v-model.number="garment_price_value"></el-input>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row justify-center">
                            <table v-if="show_cut_and_sew_table" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Embellishment
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Embellishment cost
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No of Embellishments
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total embellishments cost
                                    </th>
                                    <th scope="col"
                                        v-show="!account_payment"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Set up cost
                                    </th>
                                    <th scope="col"
                                        v-show="!account_payment"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No of Set ups
                                    </th>
                                    <th scope="col"
                                        v-show="!account_payment"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total set up cost
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-if="cut_and_sew_embellishments_table.length > 0" v-for="sublimations in cut_and_sew_embellishments_table">
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{sublimations.embellishment}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{sublimations.embellishment_cost}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <el-input placeholder="No of embellishment" v-model.number="sublimations.no_of_embellishments"></el-input>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{sublimations.total_embellishment_cost}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap" v-show="!account_payment">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{sublimations.setup_cost}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap" v-show="!account_payment">
                                        <div class="text-sm font-medium text-gray-900">
                                            <el-input placeholder="No of setup" v-model.number="sublimations.no_of_setups"></el-input>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap" v-show="!account_payment">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{sublimations.total_setup_cost}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 py-1">
                                            <el-button size="mini">{{sublimations.actions[0]}}</el-button>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900 py-1">
                                            <el-button size="mini">{{sublimations.actions[1]}}</el-button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <table v-if="show_sublimation_table" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Embellishment
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Embellishment cost
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No of Embellishments
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total embellishments cost
                                    </th>
                                    <th scope="col"
                                        v-show="!account_payment"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Set up cost
                                    </th>
                                    <th scope="col"
                                        v-show="!account_payment"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No of Set ups
                                    </th>
                                    <th scope="col"
                                        v-show="!account_payment"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total set up cost
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-if="sublimation_embellishments_table.length > 0" v-for="sublimations in sublimation_embellishments_table">
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{sublimations.embellishment}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{sublimations.embellishment_cost}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <el-input placeholder="No of embellishment" type="number" v-model.number="sublimations.no_of_embellishments"></el-input>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{sublimations.total_embellishment_cost}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap" v-show="!account_payment">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{sublimations.setup_cost}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap" v-show="!account_payment">
                                        <div class="text-sm font-medium text-gray-900">
                                            <el-input placeholder="No of setup" type="number" v-model.number="sublimations.no_of_setups"></el-input>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap" v-show="!account_payment">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{sublimations.total_setup_cost}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 py-1">
                                            <el-button size="mini">{{sublimations.actions[0]}}</el-button>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900 py-1">
                                            <el-button size="mini">{{sublimations.actions[1]}}</el-button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

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
export default {
    name: "Create",
    data() {
        return {
            customer_options: [{
                value: 'customer 1',
                label: 'Customer 1'
            },{
                value: 'customer 2',
                label: 'Customer 2'
            },{
                value: 'customer 3',
                label: 'Customer 3'
            }],
            cs_person_options:[{
                value: 'person 1',
                label: 'Person 1'
            },{
                value: 'person 2',
                label: 'Person 2'
            }],
            sales_persons_options:[{
                value: 'person 1',
                label: 'Person 1'
            },{
                value: 'person 2',
                label: 'Person 2'
            }],
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
            embellishment_options: [{
                value: 'cut and sew',
                label: 'Cut and sew'
            },{
                value: 'sublimation',
                label: 'Sublimation'
            }],
            club_options:[{
                value: 'club 1',
                label: 'Club 1'
            },{
                value: 'club 2',
                label: 'Club 2'
            }],
            value: '',
            garment_quantity: '',
            quotation_type: 'General',
            checked2: false,
            input: '',
            selected_embellishment_type: '',
            selected_customer_id: null,
            selected_cs_person_id: null,
            selected_style_code_id:null,
            selected_category_id:null,
            selected_club_id:null,
            show_cut_and_sew_table: false,
            show_sublimation_table: false,
            delivery_address:'',
            quotation_notes:'',
            garment_price: [{
                value: 'default garment price',
                label: 'Default garment price'
            },{
                value: 'custom garment price',
                label: 'Custom garment price'
            }],
            editable_garment_price: false,
            selected_garment_price: '',
            garment_price_value: '',
            cut_and_sew_embellishments_table: [
                {
                    embellishment: 'Heat Transfer',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment: 'Screen Print',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment: 'Embroidery',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment: 'Applique',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment: 'Tackle Twill',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment: 'Partial Sublimation',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment: 'Patch',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                }
            ],
            sublimation_embellishments_table:[
                {
                    embellishment: 'Sublimation',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                }
            ],
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
        showSetUpCostTable() {
            if (this.selected_embellishment_type === 'cut and sew') {
                this.show_cut_and_sew_table = true
                this.show_sublimation_table = false
            }

            if (this.selected_embellishment_type === 'sublimation') {
                this.show_sublimation_table = true
                this.show_cut_and_sew_table =  false
            }
        },
        changeGarmentPrice(value) {
            if (value === 'default garment price') {
                this.editable_garment_price = false
            }
            if (value === 'custom garment price') {
                this.editable_garment_price = true
            }
        }
    },

}
</script>

<style scoped>

</style>
