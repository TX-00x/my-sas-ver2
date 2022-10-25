<template>
    <div>
        <div class="grid grid-cols-3 gap-3 pb-8">
            <div>
                <div>
                    <label for="customer" class="block">Customer name</label>
                </div>
                <el-select v-model="form.customer_id" name="customer" class="w-full" placeholder="Select customer">
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
                <el-select class="w-full" name="cs-agent" placeholder="Select customer service person" v-model="form.customer_service_agent_id">
                    <el-option
                        v-for="csAgent in propCustomerSupportAgents"
                        :key="csAgent.id"
                        :label="csAgent.name"
                        :value="csAgent.id">
                    </el-option>
                </el-select>
            </div>
            <div>
                <div>
                    <div>
                        <label for="quotation-type" class="block py-1">Quotation type</label>
                    </div>
                    <div class="flex flex-row">
                        <div>
                            <el-radio class="p-1" v-model="form.type" label="general">General</el-radio>
                        </div>
                        <div>
                            <el-radio class="p-1" v-model="form.type" label="funding">Funding</el-radio>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-3 pb-8">
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
                <el-select class="w-full" v-model="form.sales_agent_id" name="customer_sales_person" placeholder="Customer sales person">
                    <el-option
                        v-for="saleAgent in propSalesAgents"
                        :key="saleAgent.id"
                        :label="saleAgent.name"
                        :value="saleAgent.id">
                    </el-option>
                </el-select>
            </div>
            <div>
                <div>
                    <label for="attention_person" class="block">Attention person</label>
                </div>
                <el-input placeholder="Attention person name" name="attention_person" v-model="form.attention_person"></el-input>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-3">

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
    computed:{
        form: {
            get() {
                return this.value;
            },
            set(val) {
                const valueForEmmit = this.value;
                valueForEmmit.customer_id = val.customer_id;
                valueForEmmit.sales_agent_id = val.sales_agent_id;
                valueForEmmit.customer_service_agent_id = val.customer_service_agent_id;
                valueForEmmit.type = val.type;
                valueForEmmit.club = val.club;
                valueForEmmit.attention_person = val.attention_person;
                valueForEmmit.delivery_address = val.delivery_address;

                this.$emit('input', valueForEmmit);
            }
        }
    }
}
</script>

<style scoped>

</style>
