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
                        <h4>Customer information</h4>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <el-select class="w-full" v-model="value" placeholder="Select customer">
                                    <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
export default {
    name: "Create"
}
</script>

<style scoped>

</style>
