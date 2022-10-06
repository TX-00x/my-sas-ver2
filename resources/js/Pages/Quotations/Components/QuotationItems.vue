<template>
    <div>
        <div class="grid grid-cols-4 gap-3">
            <div>
                <el-select v-model="selected_style_code_id" @change="onChangeStyleCode" placeholder="Style code">
                    <el-option
                        v-for="item in styleCodeOptions"
                        :key="item.value"
                        :label="item.label"
                        :value="item">
                    </el-option>
                </el-select>
            </div>
            <div>
                <el-select v-model="selected_category_id" @change="onChangeCategory" placeholder="Category">
                    <el-option
                        v-for="item in categoryOptions"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div>
                <el-input placeholder="Quantity" v-model.number="garment_quantity" @change="onChangeGarmentQuantity"></el-input>
            </div>
            <div>
                <el-select placeholder="Default Garment Price" v-model="selected_garment_price" @change="onChangeGarmentPriceType">
                    <el-option
                        v-for="item in garment_price"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-3 py-8">
            <div>
                <el-select @change="onChangeSetupCostTable" v-model="selected_embellishment_type" placeholder="Select embellishment type">
                    <el-option
                        v-for="item in embellishment_options"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div class="col-span-2">
                <el-input
                    type="textarea"
                    :rows="2"
                    placeholder="Add notes"
                    @change="onChangeQuotationNotes"
                    v-model="quotation_notes">
                </el-input>
            </div>
            <div>
                <div class="flex flex-col">
                    <el-input :disabled="!editable_garment_price" @change="onChangeGarmentPrice" placeholder="Garment price" type="number" min="0" v-model.number="garment_price_value"></el-input>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-center">
            <cut-and-sew-table
                v-show="show_cut_and_sew_table"
                :acount-payment="acoountPayment"
                @cut-and-sew-table="onChangeCutAndSewTable"
            ></cut-and-sew-table>
            <sublimation-table
                v-show="show_sublimation_table"
                :acount-payment="acoountPayment"
                @sublimations-table="onChangeSublimationsTable"
            ></sublimation-table>
        </div>


    </div>
</template>

<script>
import CutAndSewTable from "@/Pages/Quotations/Components/CutAndSewTable";
import SublimationTable from "@/Pages/Quotations/Components/SublimationTable";

export default {
    name: "QuotationItems",
    components:{
        SublimationTable,
        CutAndSewTable
    },
    props: {
        styleCodeOptions: {
            type: Array,
            required: true
        },
        categoryOptions: {
            type: Array,
            required: true
        },
        acoountPayment: {
            type: Boolean,
            required: true
        }
    },
    data(){
        return {
            selected_style_code_id: null,
            selected_category_id: null,
            garment_quantity: null,
            selected_garment_price: null,
            garment_price: [{
                value: 'default garment price',
                label: 'Default garment price'
            },{
                value: 'custom garment price',
                label: 'Custom garment price'
            }],
            embellishment_options: [{
                value: 'cut and sew',
                label: 'Cut and sew'
            },{
                value: 'sublimation',
                label: 'Sublimation'
            }],
            selected_embellishment_type: '',
            editable_garment_price: false,
            quotation_notes: '',
            garment_price_value: 0.00,
            show_cut_and_sew_table: false,
            show_sublimation_table: false,
        }
    },
    methods:{
        onChangeStyleCode(value){
            this.$emit('style-selected', value)
        },
        onChangeCategory(value){
            this.$emit('category-selected', value)
        },
        onChangeGarmentQuantity(value){
            this.$emit('garment-qty', value)
        },
        onChangeGarmentPriceType(value){
            this.$emit('garment-price-selected', value)
            if (value === 'default garment price') {
                this.editable_garment_price = false
            }
            if (value === 'custom garment price') {
                this.editable_garment_price = true
            }
        },
        onChangeGarmentPrice(value){
            this.$emit('garment-price', value)
        },
        onChangeSetupCostTable(value){
            this.$emit('setup-cost-table', value)
            if (value === 'cut and sew') {
                this.show_cut_and_sew_table = true
                this.show_sublimation_table = false
            }

            if (value === 'sublimation') {
                this.show_sublimation_table = true
                this.show_cut_and_sew_table =  false
            }
        },
        onChangeQuotationNotes(value){
            this.$emit('quotation-notes', value)
        },
        onChangeCutAndSewTable(value){
            this.$emit('cut-and-sew-table', value)
        },
        onChangeSublimationsTable(value){
            this.$emit('sublimations-table', value)
        }
    }
}
</script>

<style scoped>

</style>
