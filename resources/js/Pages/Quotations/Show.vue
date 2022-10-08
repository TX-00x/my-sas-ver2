<template>
    <div>
        <div class="container px-4 mx-auto">
            <div class="p-6 h-full border border-coolGray-100 overflow-hidden bg-white rounded-md shadow-dashboard">
                <div class="pb-6 border-b border-coolGray-100">
                    <div class="flex flex-wrap items-center justify-between -m-2" contenteditable="false">
                        <div class="w-full md:w-auto p-2">
                            <h2 class="text-coolGray-900 text-lg font-semibold" contenteditable="false">Quotation
                                #56789</h2>
                            <p class="text-xs text-coolGray-500 font-medium" contenteditable="false">SAS Sports, New
                                Zealand</p>
                        </div>
                        <div class="w-full md:w-auto p-2">
                            <div class="flex flex-wrap justify-between -m-1.5">
                                <div class="w-full md:w-auto p-1.5">
                                    <button
                                        class="flex flex-wrap justify-center w-full px-4 py-2 font-medium text-sm bg-white rounded-md shadow-button text-gray-600 border-gray-600 border"
                                        contenteditable="false">
                                        <p>Print</p>
                                    </button>
                                </div>
                                <div class="w-full md:w-auto p-1.5">
                                    <button
                                        class="flex flex-wrap justify-center w-full px-4 py-2 font-medium text-sm border rounded-md shadow-button border-gray-600 hover:bg-green-600 hover:text-gray-100">
                                        <p contenteditable="false">Approve</p>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container px-4 mx-auto">
            <div class="px-10 py-5 flex flex-row">
                <div class="w-full md:w-1/3 p-3 flex flex-col">
                    <p class="text-gray-800 font-semibold">Customer name:</p>
                    <div class="py-2">
                        John Doe
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-3 flex flex-col">
                    <p class="text-gray-800 font-semibold">Customer service person</p>
                    <div class="py-2">
                        Brad Chavik
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-3 flex flex-col">
                    <p class="text-gray-800 font-semibold">Quotation type</p>
                    <div class="py-2">
                        <div class="px-3 py-1 text-center bg-blue-200 bg-opacity-70 rounded-full">
                            <span class="text-sm font-bold text-blue-500 leading-6">General</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-10 py-5 flex flex-row">
                <div class="w-full md:w-1/3 p-3 flex flex-col">
                    <p class="text-gray-800 font-semibold">Team/Club/School:</p>
                    <div class="py-2">
                        New Zealand National Team
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-3 flex flex-col">
                    <p class="text-gray-800 font-semibold">Customer sales person:</p>
                    <div class="py-2">
                        Brad Chavik
                    </div>
                </div>
            </div>
            <div class="px-10 py-5 flex flex-row">
                <div class="w-full md:w-1/3 p-3 flex flex-col">
                    <p class="text-gray-800 font-semibold">Attention person name:</p>
                    <div class="py-2">
                        Joe Satriani
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-3 flex flex-col">
                    <p class="text-gray-800 font-semibold">Delivery address:</p>
                    <div class="py-2">
                        932 Langosh Loop
                    </div>
                </div>
            </div>
            <!--   Quotation Items-->
            <div class="py-12 px-8 md:px-12 mb-14 xl:mb-9 bg-white rounded-3xl bg-gray-100">
                <div class="px-10 py-5 flex flex-row">
                    <div class="w-full md:w-1/4 p-3 flex flex-col">
                        <p class="text-gray-800 font-semibold">Style code:</p>
                        <div class="py-2">
                            Tee 01
                        </div>
                    </div>
                    <div class="w-full md:w-1/4 p-3 flex flex-col">
                        <p class="text-gray-800 font-semibold">Category</p>
                        <div class="py-2">
                            Basketball
                        </div>
                    </div>
                    <div class="w-full md:w-1/4 p-3 flex flex-col">
                        <p class="text-gray-800 font-semibold">Quantity</p>
                        <div class="py-2">
                            56
                        </div>
                    </div>
                    <div class="w-full md:w-1/4 p-3 flex flex-col">
                        <p class="text-gray-800 font-semibold">Garment price</p>
                        <div class="py-2">
                            $20.00
                        </div>
                    </div>
                </div>
                <div class="px-10 py-5 flex flex-row">
                    <div class="w-full md:w-1/2 p-3 flex flex-col">
                        <p class="text-gray-800 font-semibold">Embellishment type</p>
                        <div class="py-2">
                            Sublimation
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 p-3 flex flex-col">
                        <p class="text-gray-800 font-semibold">Additional notes</p>
                        <div class="py-2">
                            Please note: Lorem ipsum dollar sumit.
                        </div>
                    </div>
                </div>

                <section class="py-8">
                    <div class="container px-4 mx-auto">
                        <div class="p-7 pb-12 pt-12 bg-white rounded-5xl">
                            <h2 class="pl-10 xl:pl-24 text-2xl font-heading font-medium">Quotation items</h2>
                            <div class="overflow-x-auto">
                                <div class="inline-block min-w-full overflow-hidden">
                                    <table class="mb-10 table-auto w-full">
                                        <thead>
                                        <tr>
                                            <th class="pl-10 xl:pl-24 h-20 bg-white text-left">
                                                <span
                                                    class="block text-sm text-body text-opacity-40 font-heading font-semibold uppercase min-w-max">Style code</span>
                                            </th>
                                            <th class="p-5 h-20 bg-white">
                                                <span
                                                    class="block text-sm text-body text-opacity-40 font-heading font-semibold uppercase min-w-max">Production</span>
                                            </th>
                                            <th class="p-5 h-20 bg-white">
                                                <span
                                                    class="block text-sm text-body text-opacity-40 font-heading font-semibold uppercase min-w-max">Quantity</span>
                                            </th>
                                            <th class="p-5 h-20 bg-white">
                                                <span
                                                    class="block text-sm text-body text-opacity-40 font-heading font-semibold uppercase min-w-max">Total product price</span>
                                            </th>
                                            <th class="p-5 h-20 bg-white">
                                                <span
                                                    class="block text-sm text-body text-opacity-40 font-heading font-semibold uppercase min-w-max">Total Embellishment price</span>
                                            </th>
                                            <th class="p-5 h-20 bg-white">
                                                <span
                                                    class="block text-sm text-body text-opacity-40 font-heading font-semibold uppercase min-w-max">Final price</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center pl-10 xl:pl-24 h-20 bg-blueGray-50 border-l border-t border-b border-gray-100 rounded-tl-5xl rounded-bl-5xl">
                                                    <span class="text-lg font-heading font-medium">WX90013</span>
                                                </div>
                                            </td>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-r border-gray-100 rounded-tr-5xl rounded-br-5xl">
                                                    <span
                                                        class="py-1 px-3 text-sm text-green-700 font-heading font-medium bg-green-200 rounded-full">Sublimation</span>
                                                </div>
                                            </td>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-gray-100">
                                                    <span class="text-lg text-darkBlueGray-400 font-heading">5</span>
                                                </div>
                                            </td>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-gray-100">
                                                    <span
                                                        class="text-lg text-darkBlueGray-400 font-heading">$70.00</span>
                                                </div>
                                            </td>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-gray-100">
                                                    <span
                                                        class="text-lg text-darkBlueGray-400 font-heading">$70.00</span>
                                                </div>
                                            </td>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-gray-100">
                                                    <span
                                                        class="text-lg text-darkBlueGray-400 font-heading">$140.00</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center pl-10 xl:pl-24 h-20 bg-blueGray-50 border-l border-t border-b border-gray-100 rounded-tl-5xl rounded-bl-5xl">
                                                    <span class="text-lg font-heading font-medium">WX90013</span>
                                                </div>
                                            </td>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-r border-gray-100 rounded-tr-5xl rounded-br-5xl">
                                                    <span
                                                        class="py-1 px-3 text-sm text-green-700 font-heading font-medium bg-green-200 rounded-full">Sublimation</span>
                                                </div>
                                            </td>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-gray-100">
                                                    <span class="text-lg text-darkBlueGray-400 font-heading">5</span>
                                                </div>
                                            </td>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-gray-100">
                                                    <span
                                                        class="text-lg text-darkBlueGray-400 font-heading">$70.00</span>
                                                </div>
                                            </td>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-gray-100">
                                                    <span
                                                        class="text-lg text-darkBlueGray-400 font-heading">$70.00</span>
                                                </div>
                                            </td>
                                            <td class="p-0">
                                                <div
                                                    class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-gray-100">
                                                    <span
                                                        class="text-lg text-darkBlueGray-400 font-heading">$140.00</span>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--   item totals-->
                        <div class="lg:flex xl:items-center py-10">
                            <div class="mb-10 xl:mb-0 lg:w-2/12 xl:w-1/12">
                                <h3 class="text-lg font-heading font-medium" contenteditable="false">Item totals</h3>
                            </div>
                            <div class="sm:flex sm:flex-wrap lg:justify-end lg:w-10/12 xl:w-11/12"
                                 contenteditable="false">
                                <div class="sm:pr-3 lg:px-3 mb-6 xl:mb-0 w-full sm:w-1/2 lg:w-4/12 xl:w-3/12">
                                    <div
                                        class="relative flex items-center justify-between py-4 px-10 leading-8 bg-white bg-opacity-50 font-medium rounded-3xl">
                                        <div
                                            class="absolute left-3 flex justify-center items-center w-20 h-20 bg-white rounded-full">
                                            <div
                                                class="flex justify-center items-center w-11 h-11 text-xl text-white font-bold bg-blue-500 rounded-full">
                                                2
                                            </div>
                                        </div>
                                        <span class="ml-16">Style codes</span>
                                    </div>
                                </div>
                                <div class="sm:pl-3 lg:px-3 mb-3 xl:mb-0 w-full sm:w-1/2 lg:w-4/12 xl:w-3/12">
                                    <div
                                        class="flex items-center justify-between py-4 px-10 leading-8 bg-white bg-opacity-50 font-heading font-medium rounded-3xl">
                                        <span class="text-sm">Total of product price:</span>
                                        <span class="flex items-center">
                                          <span class="mr-1">$</span>
                                          <span class="text-xl">140</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="sm:pr-3 lg:px-3 mb-10 sm:mb-0 w-full sm:w-1/2 lg:w-4/12 xl:w-3/12">
                                    <div
                                        class="flex items-center justify-between py-4 px-10 leading-8 bg-white font-heading font-medium rounded-3xl">
                                        <span class="text-sm">Total of embellishment price:</span>
                                        <span class="flex items-center text-blue-500">
                                          <span class="mr-1">$</span>
                                          <span class="text-xl">140</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="sm:pl-3 w-full sm:w-1/2 lg:max-w-max lg:ml-auto xl:ml-0">
                                    <div
                                        class="flex items-center justify-between py-4 px-10 leading-8 bg-white font-heading font-medium rounded-3xl">
                                        <span class="text-sm">Total garment price</span>
                                        <span class="flex items-center text-blue-500">
                                          <span class="mr-1">$</span>
                                          <span class="text-xl">140</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--   Freight charges-->
                        <div class="lg:flex xl:items-center py-10">
                            <div class="mb-10 xl:mb-0 lg:w-2/12 xl:w-1/12">
                                <h3 class="font-heading font-medium" contenteditable="false">Freight charges</h3>
                            </div>
                            <div class="sm:flex sm:flex-wrap lg:justify-end lg:w-10/12 xl:w-11/12"
                                 contenteditable="false">
                                <div class="sm:pr-3 lg:px-3 mb-10 sm:mb-0 w-full sm:w-1/2 lg:w-4/12 xl:w-3/12">
                                    <div
                                        class="flex items-center justify-between py-4 px-10 leading-8 font-heading font-medium rounded-3xl">
                                        <span class="text-sm">Region:</span>
                                        <span class="flex items-center text-blue-500">
                                          <span class="text-xl">Nothern Region</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="sm:pr-3 lg:px-3 mb-10 sm:mb-0 w-full sm:w-1/2 lg:w-4/12 xl:w-3/12">
                                    <div
                                        class="flex items-center justify-between py-4 px-10 leading-8 font-heading font-medium rounded-3xl">
                                        <span class="text-sm">Cost per region:</span>
                                        <span class="flex items-center text-blue-500">
                                          <span class="mr-1">$</span>
                                          <span class="text-xl">10</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="sm:pl-3 w-full sm:w-1/2 lg:max-w-max lg:ml-auto xl:ml-0">
                                    <div
                                        class="flex items-center justify-between py-4 px-10 leading-8 font-heading font-medium rounded-3xl">
                                        <span class="text-sm">No of boxes</span>
                                        <span class="flex items-center text-blue-500">
                                          <span class="text-xl">10</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="sm:pl-3 w-full sm:w-1/2 lg:max-w-max lg:ml-auto xl:ml-0">
                                    <div
                                        class="flex items-center justify-between py-4 px-10 leading-8 bg-white font-heading font-medium rounded-3xl">
                                        <span class="text-sm">Total freight charge</span>
                                        <span class="flex items-center text-blue-500">
                                            <span class="mr-1">$</span>
                                            <span class="text-xl">50</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Quotation total-->
                        <div class="lg:flex xl:items-center py-10">
                            <div class="sm:flex sm:flex-wrap lg:justify-end lg:w-full xl:w-full">
                                <div class="sm:pl-3 lg:px-3 mb-3 xl:mb-0 w-full sm:w-1/2 lg:w-1/2 xl:w-1/2">
                                    <div
                                        class="flex items-center justify-between py-4 px-10 leading-8 bg-white bg-opacity-50 font-heading font-medium rounded-3xl">
                                        <span>Total quotation charge (incl. 15% GST):</span>
                                        <span class="flex items-center">
                                          <span class="mr-1">$</span>
                                          <span class="text-xl">400</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Show"
}
</script>

<style scoped>

</style>
