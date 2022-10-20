<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create a new invoices
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Invoice details</h4>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <el-select class="w-full" v-model="customerId" placeholder="Select customer">
                                    <el-option
                                        v-for="item in customerOptions"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                    </el-option>
                                </el-select>
                            </div>
                            <div>
                                <el-input placeholder="Quotation ID" type="text" v-model="quotationId"></el-input>
                            </div>
                            <div class="flex flex-row">
                                <div>
                                    <el-input placeholder="Xero invoice ID"></el-input>
                                </div>
                                <div class="px-1">
                                    <el-button>Get invoice</el-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>View invoice</h4>
                    </div>
                    <div class="p-5 h-[900px]">
                        <iframe
                            :src="`/storage/invoice-template.html`"
                            width="100%"
                            height="900px"
                            frameborder="0" >
                        </iframe>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-5">
                    <div class="flex flex-row justify-end py-10 px-5">
                        <div class="px-2">
                            <el-button>Save & Send email</el-button>
                        </div>
                        <div class="px-2">
                            <el-button type="primary">Save</el-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
export default {
    name: "Create",
    props:{
        customerOptions:{
            type: Array,
            required: true
        },
    },
    data() {
        return {
            customerId: null,
            quotationId: '',
            hostUrl: process.env.APP_URL
        }
    }
}
</script>

<style scoped>

</style>
