<template>
    <div>
        <div class="grid grid-cols-3 gap-3">
            <div>
                <div>
                    <label for="customer" class="block">Customer name</label>
                </div>
                <el-select v-model="form.customer" name="customer" class="w-full" placeholder="Select customer">
                    <el-option
                        v-for="customer in customerOptions"
                        :key="customer.id"
                        :label="customer.name"
                        :value="customer.id">
                    </el-option>
                </el-select>
            </div>
            <div>
                <div>
                    <label for="cs-agent" class="block">Customer service name</label>
                </div>
                <el-select class="w-full" name="cs-agent" placeholder="Select customer service person" v-model="form.customer_service_agent">
                    <el-option
                        v-for="csAgent in propCustomerSupportAgents"
                        :key="csAgent.id"
                        :label="csAgent.name"
                        :value="csAgent.id">
                    </el-option>
                </el-select>
            </div>
            <div class="flex flex-col justify-center items-center">
                <div>
                    <label for="quotation-type" class="block">Quotation type</label>
                </div>
                <div>
                    <el-radio class="py-1" v-model="form.type" label="general">General</el-radio>
                </div>
                <div>
                    <el-radio class="py-1" v-model="form.type" label="funding">Funding</el-radio>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <div>
                <div>
                    <label for="club_name" class="block">Team/Club/School</label>
                </div>
                <el-input class="w-full" name="club_name" placeholder="Team/Club/School"  v-model="form.club"></el-input>
            </div>
            <div>
                <div>
                    <label for="customer_sales_person" class="block">Customer sales person</label>
                </div>
                <el-select class="w-full" v-model="form.sales_agent" name="customer_sales_person" placeholder="Customer sales person">
                    <el-option
                        v-for="saleAgent in propSalesAgents"
                        :key="saleAgent.id"
                        :label="saleAgent.name"
                        :value="saleAgent.id">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-3 py-8">
            <div>
                <div>
                    <label for="attention_person" class="block">Attention person</label>
                </div>
                <el-input placeholder="Attention person name" name="attention_person" v-model="form.attention_person"></el-input>
            </div>
            <div>
                <div>
                    <label for="delivery_address" class="block">Delivery address</label>
                </div>
                <el-input
                    type="textarea"
                    :rows="2"
                    placeholder="Delivery address"
                    v-model="form.delivery_address">
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
        propSalesAgents: {
            type: Array,
            required: true,
        },
        propCustomerSupportAgents: {
            type: Array,
            required: true
        },
        value: {
            type: Object,
            required: true,
        }
    },
    data(){
        return {
            form:{
                customer: null,
                sales_agent: null,
                type:'general',
                club: null,
                attention_person: null,
                delivery_address: null,
            },
        }
    },
    watch: {
        form: {
            deep: true,
            handler(newValue) {
                const valueForEmmit = this.value;
                valueForEmmit.customer_id = newValue.customer;
                valueForEmmit.sales_agent_id = newValue.sales_agent;
                valueForEmmit.customer_service_agent_id = newValue.customer_service_agent;
                valueForEmmit.type = newValue.type;
                valueForEmmit.club = newValue.club;
                valueForEmmit.attention_person = newValue.attention_person;
                valueForEmmit.delivery_address = newValue.delivery_address;

                this.$emit('input', valueForEmmit)
            }
        }
    }
}
</script>

<style scoped>

</style>
