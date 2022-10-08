<template>
    <div>
        <div class="container px-4 mx-auto">
            <div class="p-6 h-full border border-coolGray-100 overflow-hidden bg-white rounded-md shadow-dashboard">
                <div class="pb-6 border-b border-coolGray-100">
                    <div class="flex flex-wrap items-center justify-between -m-2" contenteditable="false">
                        <div class="w-full md:w-auto p-2">
                            <h2 class="text-coolGray-900 text-lg font-semibold" contenteditable="false">Quotation #56789</h2>
                            <p class="text-xs text-coolGray-500 font-medium" contenteditable="false">SAS Sports, New Zealand</p>
                        </div>
                        <div class="w-full md:w-auto p-2">
                            <div class="flex flex-wrap justify-between -m-1.5">
                                <div class="w-full md:w-auto p-1.5">
                                    <button class="flex flex-wrap justify-center w-full px-4 py-2 font-medium text-sm bg-white rounded-md shadow-button text-gray-600 border-gray-600 border" contenteditable="false">
                                        <p>Print</p>
                                    </button>
                                </div>
                                <div class="w-full md:w-auto p-1.5">
                                    <button class="flex flex-wrap justify-center w-full px-4 py-2 font-medium text-sm border rounded-md shadow-button border-gray-600 hover:bg-green-600 hover:text-gray-100">
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
