<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quotations
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row justify-between">
                    <div>
                        <el-select v-model="value" placeholder="Select">
                            <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                            </el-option>
                        </el-select>
                        <el-checkbox v-model="checked1" label="My Quotations" border></el-checkbox>
                    </div>
                    <div>
                        <inertia-link class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                      href="/quotations/create">Create a new draft</inertia-link>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quotation ID
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created By
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created Date
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sales Person
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="quotation in quotations.data">
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ quotation.number }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ quotation.created_at }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ quotation.customer.name }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ quotation.created_by.name }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ quotation.created_at }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ quotation.sales_agent.name }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <inertia-link class="text-blue-500 font-semibold" :href="route('quotations.show', {quotation: quotation.id})">
                                        View
                                    </inertia-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>

export default {
    name: "Index",
    props: {
        quotations: {
            required: true,
            type: Object,
        }
    },
    data() {
        return {
            options: [{
                value: 'all',
                label: 'All'
            },{
                value: 'drafts',
                label: 'Drafts'
            },{
                value: 'customer_approved',
                label: 'Customer Approved'
            }, {
                value: 'customer_rejected',
                label: 'Customer Rejected'
            }, {
                value: 'sales_approval',
                label: 'Sales Approval'
            }],
            value: '',
            checked1: true,
        }
    }
}
</script>

<style scoped>

</style>
