<template>
    <div id="cut_and_show_selected_items" class="flex flex-row justify-center" v-if="true">
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
</template>

<script>
export default {
    name: "CutAndSewPricingTable"
}
</script>

<style scoped>

</style>
