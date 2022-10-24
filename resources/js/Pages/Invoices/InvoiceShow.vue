<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Invoice #{{invoice[0].invoice_number}}
            </h2>
        </template>
        <div class="py-12 z-30">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="p-5">
                        <div class="flex mb-8 justify-between">
                            <div class="w-2/4">
                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Invoice
                                        No.</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <input
                                            disabled
                                            class="appearance-none w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            type="text" :value="invoice[0].invoice_number">
                                    </div>
                                </div>
                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Purchase
                                        Order No.</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <div class="flex-1">
                                        <input
                                            disabled
                                            class="appearance-none w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            type="text" :value="invoice[0].purchase_order_number">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Invoice
                                        date</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <input
                                        disabled
                                        class="appearance-none w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        type="text" :value="invoice[0].invoiced_date">
                                </div>
                                <div class="mb-1 md:mb-1 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Factory</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <input
                                        disabled
                                        class="appearance-none w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        type="text" :value="invoice[0].sawing_factory.name">
                                </div>
                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <div class="flex items-center mt-4">
                                        <label
                                            class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Supplier</label>
                                        <span class="mr-4 inline-block hidden md:block">:</span>
                                    </div>
                                    <div class="flex-1 items-center mt-4">
                                        <input
                                            disabled
                                            class="appearance-none w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            type="text" :value="invoice[0].supplier.name">
                                    </div>
                                </div>
                                <div class="mb-4 md:mb-4 md:flex items-center">
                                    <label class="w-32 text-gray-800 block font-bold text-xs uppercase tracking-wide">Invoice created date</label>
                                    <span class="mr-4 inline-block hidden md:block">:</span>
                                    <input
                                        disabled
                                        class="appearance-none w-48 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                        type="text" :value="invoice[0].created_at">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mt-5 bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>invoice items</h4>
                    </div>
                    <div class="p-5">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Material Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Colour
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Quantity
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Price
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-gray-800 uppercase tracking-wide text-xs font-bold">
                                    Currency
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(item, index) in invoice[0].items">
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.variation.material.name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.variation.colour.name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.quantity }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.sub_total }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.currency.toUpperCase() }}
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="this.invoice[0].items.length > 0">
                                <td class="px-6 py-4 font-bold whitespace-nowrap text-right" colspan="2">
                                    Total
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{total_qty}}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{this.invoice[0].items[0].currency.toUpperCase()}} {{total_amount}}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </app-layout>
</template>

<script>
export default {
    name: "InvoiceShow",
    props: {
        invoice: {
            type: Array,
            required: true
        }
    },
    data(){
        return {
            total_qty: 0,
            total_amount: 0,
        }
    },
    mounted() {
        this.total_amount = 0;
        this.total_qty = 0;
        for(let item of this.invoice[0].items) {
            this.total_amount = (((parseFloat(this.total_amount) + parseFloat(item.sub_total)) * 100) / 100).toFixed(2);
            this.total_qty = parseFloat(this.total_qty) + parseFloat(item.quantity);
        }
    },
    methods: {
        formatDate(date) {
            let convertedDate = new Date(date);
            return convertedDate.getFullYear()+'-' + (convertedDate.getMonth()+1) + '-'+convertedDate.getDate();
        },
    }
}
</script>

<style scoped>

</style>
