<template>
    <div class="">
        <div class="mt-12 py-10 bg-white max-w-7xl mx-auto sm:px-6 lg:px-8 pb-10">
            <!--                Invoice Header-->
            <div class="flex justify-between ">
                <div class="">
                    <div>
                        <div class="text-gray-500 text-xs">Customer Name</div>
                        <div class="text-sm text-gray-700 font-semibold">
                            {{ quotation.customer.name }}
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="text-gray-500 text-xs">Delivery Address</div>
                        <div class="text-sm text-gray-700 font-semibold">
                            No 43,<br>
                            Fake Lane, Fake City <br>
                            Country <br>
                            12231 <br>
                        </div>
                    </div>

                </div>

                <div class="">
                    <div>
                        <div class="text-gray-500 text-xs">Quotation ID</div>
                        <div class="text-sm text-gray-700 font-semibold">
                            {{ quotation.number }}
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="text-gray-500 text-xs">Created Date</div>
                        <div class="text-sm text-gray-700 font-semibold"> {{ quotation.created_at }}</div>
                    </div>
                </div>
            </div>
            <!-- End of invoice header-->

            <div class="w-full mt-5">
                <table class="table-auto border-collapse w-full border border-gray-300 p-10">
                    <colgroup>
                        <col span="1" style="width: 70%;">
                        <col span="1" style="width: 10%;">
                        <col span="1" style="width: 20%;">
                    </colgroup>
                    <thead>
                    <tr class="rounded-lg text-sm font-medium text-gray-700 text-left">
                        <th class="px-4 py-2 bg-gray-200" style="background-color:#f8f8f8">Item Detail</th>
                        <th class="px-4 py-2 bg-gray-200" style="background-color:#f8f8f8">Quantity</th>
                        <th class="px-4 py-2 bg-gray-200 text-right" style="background-color:#f8f8f8">Total Price</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="item in quotation.items" class="px-2 border-gray-200 text-sm text-gray-700 font-semibold border-b border-gray-50">
                        <td class="px-4 py-2">
                            {{ item.style.code }}
                            <br>
                            <div class="text-xs">
                                Embellishment Cost : {{ item.embellishment_total }} NZD
                            </div>
                            <div class="text-xs">
                                Cost : {{ item.unit_price }} NZD x {{ item.quantity}} = {{ item.unit_price_total }} NZD
                            </div>

                            <div class="text-xs">
                                Total Cost :  {{ item.embellishment_total }} NZD +   {{ item.unit_price_total }} NZD = {{ item.gross_total }} NZD
                            </div>

                        </td>

                        <td class="px-4 py-2">
                            {{ item.quantity }}
                        </td>

                        <td class="px-4 py-2 text-right text-sm text-gray-700 font-semibold">
                            {{ item.gross_total }} NZD
                        </td>
                    </tr>

                    <tr class="px-2 border-gray-200 text-sm text-gray-700 font-semibold border-b border-gray-10">
                        <td class="px-4 py-2">
                            Freight Charges
                            <div class="text-xs">
                                {{quotation.freight.default_freight_costs.region}} : {{ quotation.freight.cost}} NZD
                            </div>
                        </td>
                        <td class="px-4 py-2">
                            {{ quotation.freight.box_count}}
                        </td>
                        <td class="px-4 py-2 text-right text-sm text-gray-700 font-semibold">
                            {{ quotation.freight.total_cost}} NZD
                        </td>
                    </tr>

                    <tr class="px-2 border-gray-200 text-sm text-gray-700 font-semibold border-b border-gray-10">
                        <td class="px-4 py-2">
                            <b>Total</b>
                        </td>
                        <td class="px-4 py-2"></td>
                        <td class="px-4 py-2 text-right text-sm text-gray-700 font-semibold">
                            <b class="border-double border-b-4 border-black">
                                {{ quotation.gross_amount}} NZD
                            </b>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-12 flex justify-between">
                <div class="">
                    <div>
                        <div class="text-gray-500 text-xs">Sales Agent</div>
                        <div class="text-sm text-gray-700 font-semibold">
                            {{ quotation.sales_agent.name }}
                        </div>
                        <div class="text-xs text-gray-600 font-semibold">
                            {{ quotation.sales_agent.email }}
                        </div>
                    </div>

                    <div class="mt-10">
                        <div class="text-gray-500 text-xs">Customer Service Agent</div>
                        <div class="text-sm text-gray-700 font-semibold">
                            {{ quotation.customer_agent.name }}
                        </div>
                        <div class="text-xs text-gray-600 font-semibold">
                            {{ quotation.customer_agent.email }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "QuotationPreview",
    props: {
        quotation: {
            required: true,
            type: Object,
        }
    }
}
</script>

<style scoped>

</style>
