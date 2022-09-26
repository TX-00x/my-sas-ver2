<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create new Stock Out
            </h2>
        </template>
        <div class="py-12 z-30">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="p-5">
                        <div class="flex mb-8 justify-between">
                            <div class="w-2/4">

                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">
                                        Order ID
                                    </label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <input
                                            tabindex="0"
                                            @focusout="handleFocusOut"
                                            @keypress="handleOrderIdChange(stockOut.order_public_id)"
                                            :disabled="isItemReadOnly"
                                            v-model="stockOut.order_public_id"
                                            class="appearance-none w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            id="inline-full-name" type="text" placeholder="100001">
                                    </div>
                                </div>

                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Customer
                                        ID.</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <app-select
                                            class="w-48"
                                            placeholder="Select Customer"
                                            option-label="name"
                                            option-value="id"
                                            :filterable="true"
                                            :options="customers"
                                            v-model="stockOut.customer"
                                            :disabled="isItemReadOnly"
                                            @input="setSelectedCustomer"
                                        ></app-select>
                                    </div>
                                </div>

                            </div>

                            <div>

                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">
                                        Factory ID
                                    </label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <app-select
                                            class="w-48"
                                            placeholder="Select Factory"
                                            option-label="name"
                                            option-value="id"
                                            :filterable="true"
                                            :options="factories"
                                            v-model="stockOut.factory"
                                            :disabled="isItemReadOnly"
                                            @input="setFactoryId"
                                        ></app-select>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
                <div class="mt-5 bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Add Items</h4>
                    </div>
                    <div class="p-5 relative flex flex-row justify-center">
                        <div class="px-4 py-3 sm:px-6">
                            <form-button type="button" :disabled="handleAddItems" @handle-on-click="showStockOutModal = !showStockOutModal">
                                Add item
                            </form-button>
                        </div>
                        <dialog-modal :max-width="'3xl'" :show="showStockOutModal" @close="showStockOutModal = false">
                            <template #title>
                                <div class="flex flex-row justify-between">
                                    <div class="text-lg text-gray-500">Stock out items</div>
                                    <form-button type="button" button-type="textOnly" @click.native="showStockOutModal = false">
                                        X
                                    </form-button>
                                </div>
                            </template>
                            <template #content>
                                <div>
                                    <form class="w-full flex-row py-5">
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="">
                                                <div class="">
                                                    <label class="text-base font-medium text-gray-700">
                                                        Style code
                                                    </label>
                                                    <app-select
                                                        placeholder="Select Style code"
                                                        option-label="code"
                                                        option-value="id"
                                                        :filterable="true"
                                                        :options="styles"
                                                        v-model="stockOutItem.style"
                                                        @input="styleSelected"
                                                    ></app-select>
                                                </div>
                                            </div>

                                            <div class="">
                                                <div class="">
                                                    <label class="text-base font-medium text-gray-700">
                                                        Style Panel
                                                    </label>
                                                    <app-select
                                                        placeholder="Select Style code"
                                                        clearable
                                                        option-label="name"
                                                        option-value="id"
                                                        :filterable="true"
                                                        :options="style_panels"
                                                        v-model="stockOutItem.style_panel"
                                                        @input="stylePanelSelected"
                                                    ></app-select>
                                                </div>
                                            </div>

                                            <div class="">
                                                <div class="">
                                                    <label class="text-base font-medium text-gray-700">
                                                        Material
                                                    </label>
                                                    <app-select
                                                        placeholder="Select Material"
                                                        clearable
                                                        option-label="name"
                                                        option-value="id"
                                                        :filterable="true"
                                                        :options="materials"
                                                        v-model="stockOutItem.material"
                                                        @input="setSelectedMaterial"
                                                    ></app-select>
                                                </div>
                                            </div>

                                            <div class="">
                                                <div class="">
                                                    <label class="text-base font-medium text-gray-700">
                                                        Colour
                                                    </label>
                                                    <app-select
                                                        placeholder="Select Style code"
                                                        clearable
                                                        option-label="name"
                                                        option-value="id"
                                                        :filterable="true"
                                                        :options="colours"
                                                        v-model="stockOutItem.color"
                                                        @input="setSelectedColor"
                                                    ></app-select>
                                                </div>
                                            </div>

                                            <div class="">
                                                <div class="">
                                                    <label class="text-base font-medium text-gray-700">
                                                        Supplier
                                                    </label>
                                                    <app-select
                                                        placeholder="Select Supplier"
                                                        option-label="name"
                                                        option-value="id"
                                                        :filterable="true"
                                                        :options="suppliers"
                                                        v-model="stockOutItem.supplier"
                                                        @input="setSelectedSupplier"
                                                    ></app-select>
                                                </div>
                                            </div>

                                            <div class="flex flex-row">
                                                <div class="px-2">
                                                    <label class="text-base font-medium text-gray-700">
                                                        No of pieces
                                                    </label>
                                                    <input
                                                        v-model="stockOutItem.pieces"
                                                        class="h-9 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md w-20"
                                                        type="text">
                                                </div>
                                                <div class="px-2">
                                                    <label class="text-base font-medium text-gray-700">
                                                        Total Usage
                                                    </label>
                                                    <input
                                                        @change="recalculateUsage"
                                                        v-model.number="stockOutItem.usage"
                                                        class="h-9 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md w-20"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-row justify-center pt-5">
                                            <div v-if="stockOut.factory_id !== null">
                                                <el-tag>Selected factory: {{ stockOut.factory ? stockOut.factory.name : '' }}</el-tag>
                                            </div>
                                            <div v-else>
                                                <el-tag type="danger">You must select a factory to record a stock out.</el-tag>
                                            </div>
                                        </div>
                                        <div class="flex flex-row justify-center pt-5">
                                            <div v-if="materialInventory">
                                                <el-tag>Available materials quantity: {{ materialInventory.available_quantity }}</el-tag>
                                            </div>
                                        </div>
                                        <div class="py-10 px-10">
                                            <div class="border-b border-gray-200"></div>
                                        </div>
                                        <div>
                                            <el-row :gutter="20" v-for="(item, index) in stockOutItem.invoice_usages" :key="index">
                                                <el-col :span="2">
                                                    <div class="mt-5">
                                                        <form-button type="button" button-type="textOnly" @click.native="addStockItemInvoice" :disabled="index !== stockOutItem.invoice_usages.length - 1">
                                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path></svg>
                                                        </form-button>
                                                    </div>
                                                </el-col>
                                                <el-col :span="10">
                                                    <div>
                                                        <label class="text-base font-medium text-gray-700">
                                                            Invoice Number
                                                        </label>
                                                        <app-select
                                                            placeholder="Select invoice number"
                                                            option-label="invoice_number"
                                                            option-value="id"
                                                            :filterable="true"
                                                            :options="invoices"
                                                            v-model="item.invoice"
                                                            @input="styleSelected"
                                                        ></app-select>
                                                    </div>
                                                </el-col>
                                                <el-col :span="10">
                                                    <div>
                                                        <label class="text-base font-medium text-gray-700">
                                                            Usage
                                                        </label>
                                                        <div>
                                                            <div class="flex flex-wrap items-stretch w-full mb-4 relative">
                                                                <div class="flex -mr-px">
                                                                    <span
                                                                        class="flex items-center leading-normal bg-grey-lighter rounded rounded-r-none border border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">
                                                                            <template v-if="selectedMaterial">
                                                                                {{ selectedMaterial.unit }}
                                                                            </template>
                                                                            <template v-else>
                                                                               m
                                                                            </template>
                                                                    </span>
                                                                </div>
                                                                <input type="text"
                                                                       class="flex-shrink flex-grow flex-auto leading-normal w-20 flex-1 h-10 border-gray-300 rounded-md rounded-l-none focus:ring-indigo-500 focus:border-indigo-500 px-3 relative"
                                                                       placeholder="0.00"
                                                                       @change="recalculateErrorMessage(item.usage, index)"
                                                                       id="sub_total-value"
                                                                       v-model.number="item.usage">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </el-col>
                                                <el-col :span="2">
                                                    <div class="mt-5">
                                                        <danger-button type="button" button-type="textOnly" :disabled="index === 0" @click.native="removeStockItemInvoice(index)">
                                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                                                        </danger-button>
                                                    </div>
                                                </el-col>
                                            </el-row>
                                        </div>
                                    </form>
                                </div>
                            </template>
                            <template #footer>
                                <div class="flex flex-row justify-between">
                                    <danger-button button-type="textOnly" type="button" @click.native="resetStockOutItem">
                                        Reset form
                                    </danger-button>
                                    <div v-show="showTotalInvoiceUsageError" class="text-sm text-red-600 font-bold">
                                        Total invoice usage is greater than requested total usage!
                                    </div>
                                    <form-button :disabled="!stockAvailable" :class="{'opacity-25': !stockAvailable}" type="button" @handle-on-click="handleAddStockItems">
                                        Add item
                                    </form-button>
                                </div>
                            </template>
                        </dialog-modal>
                    </div>
                    <div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Style
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Panel
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Supplier
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Material
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Colour
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Pieces
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Usage
                                </th>
                                <th scope="col"
                                    class="px-1 w-20 text-center py-3 text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Invoices
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(item, index) in stockOut.items">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.style.code }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.style_panel.name }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.supplier.name }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.material.name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.color.name }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.pieces }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.usage }} {{ item.material.unit }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="py-2" v-for="(invoiceItem, index) in item.invoice_usages" :key="index">
                                        <el-tag type="info" effect="plain">
                                            {{ invoiceItem.invoice.invoice_number }} - {{ invoiceItem.usage }}
                                        </el-tag>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <button
                        class="mt-10 ml-5 mb-5 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                        @click="handleSaveStockOut">Save
                    </button>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import DialogModal from "@/Jetstream/DialogModal";
import FormButton from "@/UIElements/FormButton";
import SelectOrCreateInput from "@/Pages/Suppliers/SelectOrCreateInput";
import SearchAndSelect from "@/Pages/Suppliers/SearchAndSelect";
import AppSelect from "@/UIElements/AppSelect";
import DangerButton from "@/Jetstream/DangerButton";

export default {
    name: "StockOutCreate",
    props: {
        factories: {
            required: true,
            type: Array
        },
        invoices: {
            required: true,
            type: Array
        },
        styles: {
            required: true,
            type: Array
        },
        style_type: {
            required: true,
            type: String
        },
        style_panels: {
            required: true,
            type: Array
        },
        materials: {
            required: true,
            type: Array
        },
        colours: {
            required: true,
            type: Array
        },
        customers: {
            required: true,
            type: Array
        },
        suppliers: {
            required: true,
            type: Array
        },
        selectedMaterial: {
            type: Object
        },
        materialInventory: {
            type: Object
        },
        factoryId: {
            type: Number
        },
        stockAvailable: {
            type: Boolean
        }
    },
    components: {
        DialogModal,
        AppSelect,
        FormButton,
        SelectOrCreateInput,
        SearchAndSelect,
        DangerButton
    },
    data() {
        return {
            showStockOutModal: false,
            stockOut: {
                order_public_id: null,
                factory: null,
                factory_id: null,
                customer_id: null,
                created_by_id: null,
                customer: null,
                items: [],
            },
            stockOutItem: {
                invoice_usages: [],
                style: null,
                style_id: null,
                style_panel: null,
                style_panel_id: null,
                material: '',
                material_id: '',
                color: null,
                colour_id: null,
                supplier: null,
                supplier_id: null,
                pieces: null,
                usage: null,
                usageMeasurement: ''
            },
            stockOutItems: [],
            resetSelectOptions: false,
            isItemReadOnly: false,
            showTotalInvoiceUsageError: false,
        }
    },
    mounted() {
        this.stockOutItem.usageMeasurement = this.stockOutItem.material.unit;
        this.stockOutItem.invoice_usages = [{invoice:{}, usage:null}];
    },
    methods: {
        lockFieldsInStockOut(){
            if (this.stockOut.order_public_id !== null &&
                this.stockOut.customer !== null &&
                this.stockOut.factory !== null
            ){
                this.setItemsReadOnly()
            }
        },
        triggerInvoiceUsageErrorMessage() {
            this.showTotalInvoiceUsageError = true
            setTimeout(() => {
                this.showTotalInvoiceUsageError = false
            }, 4000)
        },
        addStockItemInvoice() {
            let totalInvoiceUsage = 0;
            this.stockOutItem.invoice_usages.forEach((element) => {
                totalInvoiceUsage = totalInvoiceUsage + parseInt(element.usage)
            });
            let calculatedUsage = this.stockOutItem.usage - totalInvoiceUsage
            if(calculatedUsage > 0) {
                this.showTotalInvoiceUsageError = false
                this.stockOutItem.invoice_usages.push({invoice:{}, usage:calculatedUsage})
            } else {
                this.triggerInvoiceUsageErrorMessage()
            }
        },
        removeStockItemInvoice(index) {
            if (index > 0) {
                this.stockOutItem.invoice_usages.splice(index, 1)
            }
        },
        handleAddStockItems() {
            if (this.isValidItem()) {
                this.stockOut.items.push(this.stockOutItem);
                if (this.stockOut.order_public_id !== null || this.stockOut.order_public_id !== ''){
                    this.lockFieldsInStockOut();
                }
                this.resetStockOutItem();
            }
        },
        handleOrderIdChange(value){
            this.stockOut.order_public_id = value.replaceAll(/\s/g,'')
        },
        handleFocusOut() {
            if (this.stockOut.order_public_id === " " || this.stockOut.order_public_id === "") {
                this.stockOut.order_public_id = null
            }

            if (this.stockOut.order_public_id !== null &&
                this.stockOut.items.length !== 0 ){
                this.lockFieldsInStockOut();
            }
        },
        handleSaveStockOut() {
            this.$inertia.post(route('stock.out.store'), this.stockOut)
        },
        handleLoadOrderData() {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    order_id: this.stockOut.order_public_id
                }
            })
        },
        styleSelected() {
            this.stockOutItem.style_id = this.stockOutItem.style.id;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    style_id: this.stockOutItem.style.id
                }
            })
        },
        stylePanelSelected() {
            this.stockOutItem.style_panel_id = this.stockOutItem.style_panel.id;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    style_panel_id: this.stockOutItem.style_panel.id
                }
            })
        },
        setSelectedMaterial() {
            this.stockOutItem.material_id = this.stockOutItem.material.id;
            this.stockOutItem.usageMeasurement = this.stockOutItem.material.unit;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    material_id: this.stockOutItem.material_id
                }
            })
        },
        setSelectedColor(value) {
            this.stockOutItem.colour_id = value.id;
            this.stockOutItem.colour = value;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    colour_id: value.id
                }
            })
        },
        setSelectedCustomer() {
            this.stockOut.customer_id = this.stockOut.customer.id;
            this.lockFieldsInStockOut();
        },

        setFactoryId(value) {
            this.stockOut.factory = value;
            this.stockOut.factory_id = value.id;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    factory_id: value.id
                }
            })
            this.lockFieldsInStockOut();
        },
        setSelectedSupplier(value) {
            this.stockOut.supplier = value;
            this.stockOut.supplier_id = value.id;
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    supplier_id: this.stockOut.supplier_id
                }
            })
        },
        resetStockOutItem() {
            this.stockOutItem = {
                style: null,
                style_id: null,
                style_panel: null,
                style_panel_id: null,
                material: '',
                material_id: '',
                supplier: null,
                supplier_id: null,
                color: null,
                colour_id: null,
                pieces: '',
                usage: null,
                invoice_usages: [{invoice:{}, usage:null}],
            };

            this.$inertia.visit(route('stock.out.create'), {
                preserveState: true,
                preserveScroll: true,
                data: {
                    factory_id: this.stockOut.factory_id
                }
            })
        },
        resetStockOut() {
            this.resetStockOutItem();
            this.stockOut = {
                order_public_id: null,
                factory_id: null,
                customer_id: null,
                created_by_id: null,
                items: [],
            }
        },
        recalculateUsage() {
            this.stockOutItem.invoice_usages[0].usage = this.stockOutItem.usage
        },
        recalculateErrorMessage(value, index) {
            if (value === "") {
                this.stockOutItem.invoice_usages[index].usage = 0
            }

            let totalInvoiceUsage = 0;
            this.stockOutItem.invoice_usages.forEach((element) => {
                totalInvoiceUsage = totalInvoiceUsage + parseInt(element.usage)
            });

            console.log(totalInvoiceUsage)

            if (totalInvoiceUsage > this.stockOutItem.usage) {
                this.showTotalInvoiceUsageError = true
            }

            if (totalInvoiceUsage <= this.stockOutItem.usage) {
                this.showTotalInvoiceUsageError = false
            }
        },
        isValidItem() {
            return true;
            if (this.stockOutItem.usage > this.materialInventory.available_quantity) {
                alert("Invalid usage");
                return false;
            }


        },
        setItemsReadOnly() {
            this.isItemReadOnly = true;
        },
    },
    computed: {
        handleAddItems() {
            if (
                this.stockOut.order_public_id === null
                || this.stockOut.customer_id === null
                || this.stockOut.factory_id === null) {
                return true
            } else {
                return false
            }
        },
    }
}
</script>

<style scoped>

</style>
