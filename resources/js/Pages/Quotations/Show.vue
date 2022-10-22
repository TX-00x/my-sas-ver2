<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quotation
            </h2>
        </template>
        <div class="flex flex-col w-full mt-5 -mb-10 py-5 bg-white max-w-7xl mx-auto sm:px-6 border-2 border-gray-200 shadow-lg">
            <div class="flex flex-row justify-between">
                <div class="my-2 text-green-900 font-bold">
                    Your Approval is needed to send this to customer
                </div>

                <div class="flex justify-end">
                    <button class="mr-5 bg-green-500 shadow-lg px-3 py-1 text-white hover:bg-green-600">Approve</button>
                    <button class="mr-5 bg-red-500 shadow-lg px-5 py-1 text-white hover:bg-red-600">Reject</button>
                </div>
            </div>

            <div class="flex flex-col flex-wrap content-end mt-5">
                <textarea placeholder="Give a reason why you are rejecting" class="w-1/4"></textarea>
                <button class="mt-5 w-56 mr-5 shadow-lg px-3 py-1 text-red-600 border-2 border-red-600">Reject with reason</button>
            </div>
        </div>
        <quotation-preview
            :quotation="quotation"
        ></quotation-preview>
    </app-layout>
</template>

<script>
import QuotationPreview from "./QuotationPreview";
export default {
    name: "Show",
    components: {QuotationPreview},

    props: {
        propQuotation: {
            type: Object,
            required: true,
        }
    },
    computed: {
        quotation() {
            return this.propQuotation.data
        }
    }
}
</script>

<style scoped>


</style>
