<template>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Embellishment
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Embellishment cost
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                No of Embellishments
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Total embellishments cost
            </th>
            <th scope="col"
                v-show="!acountPayment"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Set up cost
            </th>
            <th scope="col"
                v-show="!acountPayment"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                No of Set ups
            </th>
            <th scope="col"
                v-show="!acountPayment"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Total set up cost
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <tr v-if="cut_and_sew_embellishments_table.length > 0" v-for="embellishment in cut_and_sew_embellishments_table">
            <td class="px-6 py-3 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">
                    {{embellishment.embellishment_name}}
                </div>
            </td>
            <td class="px-6 py-3 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">
                    {{embellishment.embellishment_cost}}
                </div>
            </td>
            <td class="px-6 py-3 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">
                    <el-input placeholder="No of embellishment" @change="onChangeEmbellishmentNumber" type="number" v-model.number="embellishment.no_of_embellishments"></el-input>
                </div>
            </td>
            <td class="px-6 py-3 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">
                    {{embellishment.total_embellishment_cost}}
                </div>
            </td>
            <td class="px-6 py-3 whitespace-nowrap" v-show="!acountPayment">
                <div class="text-sm font-medium text-gray-900">
                    {{embellishment.setup_cost}}
                </div>
            </td>
            <td class="px-6 py-3 whitespace-nowrap" v-show="!acountPayment">
                <div class="text-sm font-medium text-gray-900">
                    <el-input placeholder="No of setup" type="number" @change="onChangeSetupsNumber" v-model.number="embellishment.no_of_setups"></el-input>
                </div>
            </td>
            <td class="px-6 py-3 whitespace-nowrap" v-show="!acountPayment">
                <div class="text-sm font-medium text-gray-900">
                    {{embellishment.total_setup_cost}}
                </div>
            </td>
            <td class="px-6 py-3 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900 py-1">
                    <el-button size="mini">{{embellishment.actions[0]}}</el-button>
                </div>
                <div class="text-sm font-medium text-gray-900 py-1">
                    <el-button size="mini">{{embellishment.actions[1]}}</el-button>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "CutAndSewTable",
    props:{
        acountPayment: {
            type: Boolean,
            required: true
        }
    },
    data(){
        return {
            cut_and_sew_embellishments_table: [
                {
                    embellishment_name: 'Heat Transfer',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment_name: 'Screen Print',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment_name: 'Embroidery',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment_name: 'Applique',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment_name: 'Tackle Twill',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment_name: 'Partial Sublimation',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                },
                {
                    embellishment_name: 'Patch',
                    embellishment_cost: 0,
                    no_of_embellishments: 0,
                    total_embellishment_cost: 0,
                    setup_cost: 0,
                    no_of_setups: 0,
                    total_setup_cost: 0,
                    actions: ['Edit', 'Clear']
                }
            ],
        }
    },
    methods:{
        onChangeEmbellishmentNumber(value){
            this.$emit('cut-and-sew-table', this.cut_and_sew_embellishments_table)
        },
        onChangeSetupsNumber(value){
            this.$emit('cut-and-sew-table', this.cut_and_sew_embellishments_table)
        }
    }
}
</script>

<style scoped>

</style>
