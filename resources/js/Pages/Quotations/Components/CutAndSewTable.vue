<template>
    <div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Embellishment
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Location
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Cost
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Quantity
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Total Cost
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Setup Cost
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    No of Set ups
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Total set up cost
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Total (NZD)
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr v-if="embellishments.length > 0" v-for="embellishment in embellishments">
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        {{embellishment.name}}
                    </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        <div>
                            <el-select v-model="embellishment.position">
                                <el-option :value="null" label="Not decided yet" />
                                <el-option value="left" label="Left" />
                                <el-option value="right" label="Right" />
                                <el-option value="top" label="Top" />
                                <el-option value="Bottom" label="Bottom" />
                            </el-select>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        {{embellishment.cost}}
                    </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        <el-input placeholder="No of embellishment" type="number" v-model.number="embellishment.quantity"></el-input>
                    </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        {{ embellishment.total_cost = embellishment.quantity * embellishment.cost }}
                    </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        {{embellishment.setup_cost}}
                    </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        <el-input placeholder="No of setup" type="number" v-model="embellishment.setup_quantity" ></el-input>
                    </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        {{(embellishment.total_setup_cost = embellishment.setup_cost * embellishment.setup_quantity )}}
                    </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                        <b>{{ embellishment.total = (embellishment.quantity * embellishment.cost) + (embellishment.setup_cost * embellishment.setup_quantity )}}</b>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
import DialogModal from "@/Jetstream/DialogModal";
import AppSelect from "@/UIElements/AppSelect";

export default {
    name: "CutAndSewTable",
    props:{
        value: {
            type: Array,
            required: true
        }
    },
    components: {
        DialogModal,
        AppSelect
    },
    data(){
        return {
            embellishments: [],
        }
    },
    watch: {
        value: {
            deep: true,
            handler(embellishments) {
                this.embellishments = embellishments;
            }
        },
        embellishments: {
            deep: true,
            handler(embellishments) {
                this.$emit('updated', embellishments)
            }
        }
    },
}
</script>

<style scoped>

</style>
