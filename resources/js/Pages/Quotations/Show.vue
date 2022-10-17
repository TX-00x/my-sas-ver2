<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quotation
            </h2>
        </template>

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
