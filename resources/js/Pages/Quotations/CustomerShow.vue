<template>
    <div class="bg-gray-100 h-screen pt-10">
        <div class="flex flex-col w-full mt-5 -mb-10 py-5 bg-white max-w-7xl mx-auto sm:px-6 border-2 border-gray-200">
            <div v-if="showActionButtons">
                <div class="flex flex-col">
                    <div class="text-sm text-gray-600 font-bold justify-end text-right">
                        Please give your feedback by approving or rejecting this quotation
                    </div>
                    <div class="flex justify-end mt-2">
                        <button @click="submitApprove" :disabled="disableApproveButton" class="disabled:opacity-50 mr-5 bg-green-500 shadow-lg px-3 py-1 text-white hover:bg-green-600">Approve</button>
                        <button @click="rejecting = true" :disabled="disableRejectButton" class="disabled:opacity-50  bg-red-500 shadow-lg px-5 py-1 text-white hover:bg-red-600">Reject</button>
                    </div>
                </div>
                <div v-if="rejecting" class="flex flex-col flex-wrap content-end mt-5">
                    <textarea v-model="rejectForm.reason" :rows="7" placeholder="Give a reason why you are rejecting" class="w-2/4"></textarea>
                    <div class="flex flex-row justify-end">
                        <button @click="submitReject" class="disabled:opacity-50 mt-2 w-56 mr-5 shadow-lg px-3 py-1 text-red-600 border-2 border-red-600">
                            <span v-if="rejectForm.processing">Rejecting..</span>
                            <span v-else>Reject with reason</span>
                        </button>
                        <button :disabled="rejectForm.processing" @click="rejecting = false" class="mt-2 bg-gray-50 shadow-lg px-3 py-1 border-2 border-gray-500">Cancel</button>
                    </div>
                </div>
            </div>

            <div v-else class="">
                <div v-if="propQuotation.data.customer_action == 'approved'" class="text-green-600 font-semibold flex flex-cols">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>

                    <div class="ml-2">
                        Approved quotation at {{ propQuotation.data.customer_action_taken_at }}
                    </div>
                </div>

                <div v-if="propQuotation.data.customer_action == 'rejected'" class="text-red-600 font-semibold flex flex-cols">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>

                    <div class="ml-2">
                        Rejected quotation with the following reason
                        <div>
                            {{ propQuotation.data.customer_rejected_reason }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <quotation-preview
            :quotation="propQuotation.data"
        ></quotation-preview>
    </div>
</template>

<script>
import QuotationPreview from "./QuotationPreview";
export default {
    name: "CustomerShow",
    components: {QuotationPreview},
    props: {
        propQuotation: {
            required: true,
            type: Object,
        }
    },
    data() {
        return {
            rejecting: false,
            rejectForm: this.$inertia.form({
                action: 'rejected',
                reason: null,
            }),
            approveForm: this.$inertia.form({
                action: 'approved'
            })
        }
    },
    computed: {
        disableApproveButton()
        {
            return this.rejecting
        },
        disableRejectButton()
        {
            return this.rejecting
        },
        showActionButtons() {
            return this.propQuotation.data.customer_action == null;
        }
    },
    methods: {
        submitReject() {
            this.rejectForm.post(route('public.customer.quotation.store', {quotation: this.propQuotation.data.number}))
        },
        submitApprove() {
            this.approveForm.post(route('public.customer.quotation.store', {quotation: this.propQuotation.data.number}))
        }
    }
}
</script>

<style scoped>

</style>
