<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quotation
            </h2>
        </template>
        <div v-if="showRequiredApprovalCard" class="flex flex-col w-full mt-5 -mb-10 py-5 bg-white max-w-7xl mx-auto sm:px-6 border-2 border-gray-200 shadow-lg">
            <div class="flex flex-row justify-between">
                <div class="my-2 text-green-900 font-bold">
                    Your Approval is needed to send this to customer
                </div>

                <div class="flex justify-end">
                    <button @click="submitApprove" :disabled="disableApproveButton" class="disabled:opacity-50 mr-5 bg-green-500 shadow-lg px-3 py-1 text-white hover:bg-green-600">Approve</button>
                    <button @click="rejecting = true" :disabled="disableRejectButton" class="disabled:opacity-50 mr-5 bg-red-500 shadow-lg px-5 py-1 text-white hover:bg-red-600">Reject</button>
                </div>
            </div>

            <div v-if="rejecting" class="flex flex-col flex-wrap content-end mt-5">
                <textarea v-model="rejectForm.reason" :rows="7" placeholder="Give a reason why you are rejecting" class="w-2/4"></textarea>
                <div class="flex flex-row justify-end">
                    <button @click="submitReject" :disabled="rejectForm.processing" class="disabled:opacity-50 mt-2 w-56 mr-5 shadow-lg px-3 py-1 text-red-600 border-2 border-red-600">
                        <span v-if="rejectForm.processing">Rejecting..</span>
                        <span v-else>Reject with reason</span>
                    </button>
                    <button :disabled="rejectForm.processing" @click="rejecting = false" class="mt-2 bg-gray-50 shadow-lg px-3 py-1 border-2 border-gray-500">Cancel</button>
                </div>
            </div>
        </div>


        <div v-if="showRequiredApprovalCard == false" class="flex flex-col w-full mt-5 -mb-10 py-5 bg-white max-w-7xl mx-auto sm:px-6 border-2 border-gray-400 shadow-lg">
            <div class="font-semibold" v-if="(quotation.requires_sales_approval || quotation.sales_action_taken_by)">
                <!-- When no one has approved -->
                <div v-if="quotation.sales_action_taken_by == null">
                    <span class="text-xs text-gray-600" >Sales Approval : <b class="text-gray-400">(Waiting an approval from {{ quotation.sales_agent.name }})</b> </span>
                </div>


                <div v-if="quotation.sales_action_taken_by">
                    <span class="text-xs text-gray-600" >Sales Action taken By: <b>{{ quotation.sales_action_taken_by.name}}</b> </span>
                    <br>
                    <span class="text-xs text-gray-600 capitalize">
                    Sales Action:
                        <b :class="{'text-red-600': quotation.sales_action === 'rejected', 'text-green-600': quotation.sales_action === 'approved'}" >
                        {{ quotation.sales_action}}
                    </b>
                    </span>
                    <br>
                    <span v-if="quotation.sales_action === 'rejected'"  class="text-xs text-gray-600">
                        Rejected Reason:  <div class=" text-red-600" v-html="quotation.sales_rejected_reason"></div>
                    </span>
                </div>

                <div v-if="quotation.sales_action === 'approved'">
                    <div v-if="quotation.customer_action == null">
                        <span class="text-xs text-gray-600" >Customer Approval : <b class="text-gray-400">(Approval pending)</b> </span>
                    </div>

                    <div v-if="quotation.customer_action == 'approved'">
                        <span class="text-xs text-gray-600" >Customer Action : <b class="text-green-400">Approved</b> </span>
                    </div>

                    <div v-if="quotation.customer_action == 'rejected'">
                        <span class="text-xs text-gray-600" >Customer Action : <b class="text-red-600">Rejected</b> </span>
                        <br>
                        <span class="text-xs text-gray-600">Rejected Reason:  <div class="text-red-600" v-html="quotation.sales_rejected_reason"></div></span>
                    </div>

                </div>

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
        },
        disableApproveButton()
        {
            return this.rejecting
            || this.approveForm.progress
        },
        disableRejectButton()
        {
            return this.rejecting
        },
        showRequiredApprovalCard() {
            if (this.quotation.requires_sales_approval == false) {
                return false;
            }

            return this.quotation.sales_agent.id == this.$inertia.page.props.user.id
        }
    },
    mounted() {

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
    methods: {
        submitReject() {
            this.rejectForm.post(route('quotations.sales.action', {quotation: this.quotation.id}))
        },
        submitApprove() {
            this.approveForm.post(route('quotations.sales.action', {quotation: this.quotation.id}))
        }
    }
}
</script>

<style scoped>


</style>
