<template>
    <div>
        <div class="grid grid-cols-3 gap-3">
            <div>
                <el-select class="w-full" @change="onSelectCustomer" placeholder="Select customer" v-model="selected_customer">
                    <el-option
                        v-for="item in customerOptions"
                        :key="item.id"
                        :label="item.name"
                        :value="item">
                    </el-option>
                </el-select>
            </div>
            <div>
                <el-select class="w-full" @change="onselectCsPerson" placeholder="Select customer service person" v-model="selected_cs_person">
                    <el-option
                        v-for="item in csPersonOptions"
                        :key="item.id"
                        :label="item.name"
                        :value="item">
                    </el-option>
                </el-select>
            </div>
            <div class="flex flex-col justify-center items-center">
                <div class="py-1">Quotation type</div>
                <div>
                    <el-radio class="py-1" @change="onSelectQuoteType" v-model="quotation_type" label="General"></el-radio>
                </div>
                <div>
                    <el-radio class="py-1" @change="onSelectQuoteType" v-model="quotation_type" label="Funding"></el-radio>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <div>
                <el-select class="w-full" v-model="selected_club_id" placeholder="Team/Club/School">
                    <el-option
                        v-for="item in clubOptions"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div>
                <el-select class="w-full" v-model="selected_sales_person" @change="onSelectSalesPerson" placeholder="Customer sales person">
                    <el-option
                        v-for="item in salesPersonsOptions"
                        :key="item.id"
                        :label="item.name"
                        :value="item">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-3 py-8">
            <div>
                <el-input @change="onChangeAttentionPersonName" placeholder="Attention person name"  v-model="attention_person_name"></el-input>
            </div>
            <div>
                <el-input
                    type="textarea"
                    @change="onChangeDeliveryAddress"
                    :rows="2"
                    placeholder="Delivery address"
                    v-model="delivery_address">
                </el-input>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CustomerInformation",
    props: {
        customerOptions: {
            type: Array,
            required: true
        },
        clubOptions: {
            type: Array,
            required: true
        },
    },
    data(){
        return {
            selected_customer: null,
            selected_cs_person: null,
            selected_sales_person: null,
            quotation_type: '',
            selected_club_id: null,
            attention_person_name: '',
            delivery_address: '',
            csPersonOptions: [],
            salesPersonsOptions:[]
        }
    },
    methods:{
        onSelectCustomer(value) {
            this.csPersonOptions.push(value.cs_agent)
            this.onselectCsPerson(this.csPersonOptions[0])
            this.selected_cs_person = value.cs_agent

            this.salesPersonsOptions.push(value.sales_agent)
            this.onSelectSalesPerson(this.salesPersonsOptions[0])
            this.selected_sales_person = value.sales_agent

            this.$emit('customer-selected', value)
        },
        onselectCsPerson(value) {
            this.$emit('cs-selected', value)
        },
        onSelectSalesPerson(value) {
            this.$emit('sales-selected', value)
        },
        onSelectQuoteType(value) {
            this.$emit('quote-type-selected', value)
        },
        onChangeAttentionPersonName(value) {
            this.$emit('attention-person', value)
        },
        onChangeDeliveryAddress(value) {
            this.$emit('delivery-address', value)
        }
    }
}
</script>

<style scoped>

</style>
