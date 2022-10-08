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
                    Embellishment image
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
                        <div><el-button type="primary" @click="open_embellishment_image_modal = true">Open</el-button></div>
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
        <dialog-modal :show="open_embellishment_image_modal">
            <template #title>
                Embellishment images and positions
            </template>
            <template #content>
                <div class="py-4">
                    <div class="flex flex-row justify-end pb-10">
                        <div><el-button size="small" type="primary">Add another image</el-button></div>
                    </div>
                    <el-row class="py-4" :gutter="10" justify="center">
                        <el-col :xs="12" :sm="12" :md="12" :lg="12" :xl="12">
                            <app-select
                                :filterable="true"
                                :multiple="false"
                                :options="embellishmentsPositionsFromDB"
                                option-label="name"
                                option-value="id"
                                no-data-text="No Positions available"
                                no-match-text="Position not found"
                                v-model="embellishmentsPosition"
                                placeholder="Select a position"
                            ></app-select>
                        </el-col>
                        <el-col :xs="12" :sm="12" :md="12" :lg="12" :xl="12">
                            <label :for="'dropzone-embellishments_'"
                                   class="flex flex-col justify-center items-center w-full h-32 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col justify-center items-center pt-5 pb-6" >
                                    <svg class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">JPEG, JPG or PNG</p>
                                </div>
                                <input :name="'style_image_'" :id="'dropzone-embellishments_'" type="file"  ref="embellishments_images" class="hidden" />
                            </label>
                        </el-col>
                    </el-row>
                </div>
            </template>
            <template #footer>
                <jet-secondary-button @click.native="open_embellishment_image_modal = false">
                    Nevermind
                </jet-secondary-button>

                <jet-button @click.native="saveEmbellishmentImages" class="ml-2">
                    Save
                </jet-button>
            </template>
        </dialog-modal>
    </div>

</template>

<script>
import DialogModal from "@/Jetstream/DialogModal";
import AppSelect from "@/UIElements/AppSelect";

export default {
    name: "CutAndSewTable",
    props:{
        acountPayment: {
            type: Boolean,
            required: true
        }
    },
    components: {
        DialogModal,
        AppSelect
    },
    data(){
        return {
            open_embellishment_image_modal: false,
            embellishmentsPositionsFromDB: [
                {'id':1, 'name': 'Top'},
                {'id':2, 'name': 'Bottom'},
                {'id':3, 'name': 'Left'},
                {'id':4, 'name': 'Right'},
            ],
            embellishmentsPosition: '',
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
        },
        saveEmbellishmentImages(){
            console.log('saved')
        },
    }
}
</script>

<style scoped>

</style>
