<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inventory: {{ inventory.variation.material.name }} - {{ inventory.variation.colour.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="flex flex-row justify-start">
                    <div class="bg-white shadow-xl p-5 rounded-md mx-2">
                        <h4 class="text-xl text-blue-700">Total Quantity</h4>
                        <div class="text-gray-600">{{ inventory.available_quantity }} {{ inventory.unit }}</div>
                    </div>

                    <div class="bg-white shadow-xl p-5 rounded-md mx-2">
                        <h4 class="text-xl text-blue-700">Total Value</h4>
                        <div class="text-gray-600">{{ totalValue }}<span class="px-1">NZD</span></div>
                        <inertia-link :href="'/inventory/'+inventory.id+'/summary'" class="text-xs">More details ></inertia-link>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5 p-5">
                    <el-tabs type="card">
                        <div class="px-6 flex justify-between">
                            <h3 class="text-lg">Inventory Log</h3>
                            <button
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                @click="showAdjustmentWindow = true"
                            >
                                Stock Adjustment
                            </button>
                        </div>

                        <table class="mt-5 min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date and Time
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Unit
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    In
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    P.O Number
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Out
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Balance
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Other Reason
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Unit Price
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Price
                                </th>

                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="stock in stockIn.data">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.created_at }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.unit }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap flex flex-row items-center justify-between">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.in }}
                                    </div>
                                    <div v-if="stock.invoice_item">
                                        <a class="cursor-pointer text-blue-500 text-sm"
                                           @click="showInvoice(stock.invoice_item.invoice.id)">
                                            #{{ stock.invoice_item.invoice.invoice_number }}
                                        </a>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div v-if="stock.invoice_item">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ stock.invoice_item.invoice.purchase_order_number }}
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.out }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.balance }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.reason }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ stock.in_unit_price }} {{ stock.in_unit_currency }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ showTotalPrice(stock.total_price) }} {{ stock.in_unit_currency }}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <paginator
                            :pagination="stockIn"
                        ></paginator>
                    </el-tabs>
                </div>
            </div>
        </div>
        <dialog-modal :show="showAdjustmentWindow" :max-width="'3xl'" >
            <template #title>
                Stock Adjustment
            </template>

            <template #content>
                <div class="flex flex-row justify-center py-5">
                    <div class="w-1/2">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                        <input v-model="adjustment.reason" type="text" name="reason" id="reason"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div>
                    <el-row :gutter="20" v-for="(item, index) in adjustment.invoice_usages" :key="index">
                        <el-col :span="2">
                            <div class="mt-5">
                                <form-button type="button" button-type="textOnly" @click.native="addStockItemInvoice"
                                             :disabled="index !== adjustment.invoice_usages.length - 1">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                              clip-rule="evenodd"></path>
                                    </svg>
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
                                            <span class="flex items-center leading-normal bg-grey-lighter rounded rounded-r-none border border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">
                                                <template>
                                                    m
                                                </template>
                                            </span>
                                        </div>
                                        <el-tooltip content="Add '-' before qty to decrease stock" placement="top">
                                        <input type="text"
                                               class="flex-shrink flex-grow flex-auto leading-normal w-20 flex-1 h-10 border-gray-300 rounded-md rounded-l-none focus:ring-indigo-500 focus:border-indigo-500 px-3 relative"
                                               placeholder="0.00"
                                               id="sub_total-value"
                                               v-model.number="item.usage">
                                        </el-tooltip>
                                    </div>
                                </div>
                            </div>
                        </el-col>
                        <el-col :span="2">
                            <div class="mt-5">
                                <danger-button type="button" button-type="textOnly" :disabled="index === 0"
                                               @click.native="removeStockItemInvoice(index)">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </danger-button>
                            </div>
                        </el-col>
                    </el-row>
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click.native="showAdjustmentWindow = false">
                    Nevermind
                </jet-secondary-button>

                <jet-button @click.native="adjust" class="ml-2">
                    Save
                </jet-button>
            </template>
        </dialog-modal>
        <main>
            <Notify :flash="$page.props.flash"></Notify>
            <slot></slot>
        </main>
    </app-layout>
</template>

<script>
import DialogModal from "@/Jetstream/DialogModal";
import Paginator from "@/UIElements/Paginator";
import Notify from "@/UIElements/Notify";
import AppSelect from "@/UIElements/AppSelect";
import DangerButton from "@/Jetstream/DangerButton";
import FormButton from "@/UIElements/FormButton";

export default {
    name: "InventoryShow",
    props: {
        inventory: {
            type: Object,
            required: true
        },
        stockIn: {
            type: Object,
            required: true
        },
        invoices: {
            required: true,
            type: Array
        },
        totalValue: {
            required: true,
            type: Number
        }
    },
    components: {
        DialogModal,
        Paginator,
        Notify,
        AppSelect,
        DangerButton,
        FormButton
    },
    data() {
        return {
            showAdjustmentWindow: false,
            adjustment: {
                reason: '',
                invoice_usages: [],
            }
        }
    },
    mounted() {
        this.adjustment.invoice_usages = [{invoice:{}, usage:null}];
    },
    methods: {
        adjust() {
            // console.log(this.adjustment)
            this.$inertia.post(`/inventory/${this.inventory.id}/adjust`, this.adjustment).then(function ({data}) {
                this.showAdjustmentWindow = false
            }).catch(error => {
                this.showAdjustmentWindow = false
            })
        },
        addStockItemInvoice() {
            let lestIndex = this.adjustment.invoice_usages.length - 1;
            this.adjustment.invoice_usages.push({invoice:{}, usage:null})
        },
        removeStockItemInvoice(index) {
            if (index > 0) {
                this.adjustment.invoice_usages.splice(index, 1)
            }
        },
        showInvoice(id) {
            this.$inertia.visit('/invoices/' + id);
        },
        showTotalPrice(price) {
            return price === 0 ? '' : price;
        }
    }
}
</script>

<style scoped>

</style>
