<template>
    <div>
        <div>
            <el-divider content-position="left"><h3 class="text-lg font-bold">General</h3></el-divider>
            <div class="py-4">
                <form>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                <div class="col-span-1 sm:col-span-1" v-if="styleCodeType == 'Customized'">
                                    <label class="block text-sm font-medium text-gray-700">Parent Style code</label>
                                    <input type="text" name="parent_style_code"
                                           :disabled="(styleCodeType == 'Customized')"
                                           v-model="form.parent_style_code"
                                           id="parent_style_code"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-1 sm:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">Style code extension</label>
                                    <el-tooltip class="item" effect="dark" :content="'type the new extension to change the current extension - '+form.code" placement="top-start">
                                        <el-input placeholder="Extension" v-model="customized_style_code" @change="styleCodeChange">
                                            <template slot="prepend">{{form.parent_style_code}}</template>
                                        </el-input>
                                    </el-tooltip>
                                    <p class="text-xs">Customized style code: {{form.code}}</p>
                                </div>
                                <div class="col-span-1 sm:col-span-1">
                                    <label for="style_name_general_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Style name</label>
                                    <input type="text" name="style_name_general_style"
                                           v-model="form.name"
                                           id="style_name_general_style"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-1 sm:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Category
                                    </label>
                                    <app-select
                                        :filterable="true"
                                        :multiple="true"
                                        :options="categories"
                                        option-label="name"
                                        no-data-text="No Categories available"
                                        no-match-text="Category not found"
                                        v-model="form.categories"
                                        placeholder="Select Category"
                                    ></app-select>
                                </div>
                            </div>
                            <div class="mt-5">
                                <div>
                                    <label for="style_description_general_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Description</label>
                                    <textarea name="style_description_general_style"
                                              v-model="form.description"
                                              id="style_description_general_style"
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                            <div class="mt-5 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Item type
                                    </label>
                                    <app-select
                                        :disabled="(styleCodeType == 'Customized')"
                                        :filterable="true"
                                        :multiple="false"
                                        :options="itemTypes"
                                        option-label="name"
                                        no-data-text="No Categories available"
                                        no-match-text="Category not found"
                                        v-model="form.item_type"
                                        placeholder="Select Type"
                                    ></app-select>
                                </div>
                                <div>
                                    <label
                                        for="production_time_general_style"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Production time
                                    </label>
                                    <input type="number"
                                           :disabled="(styleCodeType == 'Customized')"
                                           v-model="form.production_time"
                                           id="production_time_general_style"
                                           name="production_time_general_style"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                           step="1" min="0"
                                    />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Sizes
                                    </label>
                                    <app-select
                                        :filterable="true"
                                        :multiple="true"
                                        :options="sizes"
                                        option-label="name"
                                        no-data-text="No Categories available"
                                        no-match-text="Category not found"
                                        v-model="form.sizes"
                                        placeholder="Select Sizes"
                                    ></app-select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Factory
                                    </label>
                                    <app-select
                                        :filterable="true"
                                        :multiple="true"
                                        :options="factories"
                                        option-label="name"
                                        no-data-text="No Factory available"
                                        no-match-text="Factory not found"
                                        v-model="form.factories"
                                        placeholder="Select Factories"
                                    ></app-select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <el-divider content-position="left"><h3 class="text-lg font-bold">Panels</h3></el-divider>
            <div class="py-4">
                <!-- Panel Table -->
                <div class="p-5 border-2 border-gray-200">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <td>Panel</td>
                                <td>Material</td>
                                <td>Colour</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="panel in parentStyle.panels" :key="panel.id">
                                <td>{{ panel.name }}</td>
                                <td>
                                    <select class="px-2 my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5" @change="(event) => panelFabricSelected(panel.id, event.target.value)">
                                        <option>Select Material</option>
                                        <option v-for="fabric in panel.fabrics" :key="fabric.id" :value="fabric.id"> {{ fabric.name }}</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="px-2 my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5" @change="(event) => colourSelected(panel.id, event.target.value)" >
                                        <option>Select Colour</option>
                                        <option v-for="colour in panelColours[panel.id]" :key="colour.id" :value="colour.id"> {{ colour.name }} </option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <el-divider content-position="left"><h3 class="text-lg font-bold">Embellishments</h3></el-divider>
            <div class="py-4">
                <div class="flex flex-row justify-end pb-10">
                    <div><el-button @click="addEmbellishmentItem" size="small" type="primary">Add</el-button></div>
                </div>
                <el-row class="py-4" :gutter="10" justify="center" :key="index" v-for="(item, index) in form.embellishments_form">
                    <el-col :xs="6" :sm="6" :md="6" :lg="6" :xl="6">
                        <app-select
                            :filterable="true"
                            :multiple="false"
                            :options="embellishments"
                            option-label="type"
                            no-data-text="No Types available"
                            no-match-text="Type not found"
                            v-model="item.type"
                            placeholder="Select Embellishment type name"
                        ></app-select>
                    </el-col>
                    <el-col :xs="6" :sm="6" :md="6" :lg="6" :xl="6">
                        <app-select
                            :filterable="true"
                            :multiple="false"
                            :options="[{name:'Top', value:'top'}, {name:'Bottom', value:'bottom'}]"
                            option-label="name"
                            option-value="value"
                            no-data-text="No Positions available"
                            no-match-text="Position not found"
                            v-model="item.position"
                            placeholder="Select a position"
                        ></app-select>
                    </el-col>
                    <el-col :xs="6" :sm="6" :md="6" :lg="6" :xl="6">
                        <label :for="'dropzone-embellishments_'+index"
                               :class="{'bg-contain bg-center bg-no-repeat' : item.image_url !== ''}" :style="{ backgroundImage: 'url('+item.image_url+')'}"
                               class="flex flex-col justify-center items-center w-full h-32 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col justify-center items-center pt-5 pb-6">
                                <svg class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">JPEG, JPG or PNG</p>
                            </div>
                            <input :name="'style_image_'+index" :id="'dropzone-embellishments_'+index" type="file" @change="previewEmbImage($event, index)" ref="embellishments_images" class="hidden" />
                        </label>
                        <div class="absolute top-4 cursor-pointer" v-show="item.image_url !== ''" @click="setEmbellishmentUploadFieldEmpty(index)">
                            <el-tooltip content="Remove image" placement="top">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </el-tooltip>
                        </div>
                    </el-col>
                    <el-col :xs="6" :sm="6" :md="6" :lg="6" :xl="6">
                        <el-button @click="removeEmbellishmentItem(index)" size="small" type="danger">-</el-button>
                    </el-col>
                </el-row>
            </div>
        </div>
    </div>
</template>

<script>
import FormButton from "@/UIElements/FormButton";
import EditButton from "@/UIElements/EditButton";
import DeleteButton from "@/UIElements/DeleteButton";
import AppSelect from "@/UIElements/AppSelect";
import Label from "@/Jetstream/Label";
import Vue from "vue";

export default {
    name: "GeneralStyleForm",
    components: {
        Label,
        AppSelect,
        FormButton,
        EditButton,
        DeleteButton
    },
    props: {
        resetForm: Boolean,
        parentStyle: {
            required: true,
            type: Object
        },
        styleCodeType: String,
        categories: {
            required: true,
            type: Array
        },
        itemTypes: {
            type: Array,
            required: true
        },
        sizes: {
            type: Array,
            required: true
        },
        embellishments: {
            type: Array,
            required: true
        },
        factories: {
            type: Array,
            required: true
        },
        value: {
            type: Object,
            required: true
        },
        materials: {
            type: Array,
            required: true
        },
        colours: {
            type: Array,
            required: true
        },
        parentPanels:{
            required: true
        },
        componentFabrics:{
            type: Array,
            required: true
        },
        errors: {
            type: Object,
            required: false,
            default: {}
        }
    },
    data() {
        return {
            form: {
                sizes: [],
                panels: [],
                customized_panels: [],
            },
            // embellishments_form: [
            //     {type:'',position:'',image_url:'' }
            // ],
            selectedPanelOptions:{},
            panelColours: {},
            customized_style_code: '',
            panel: this.defaultPanel(),
            component_materials : [],
            show_panel_form: false,
        }
    },
    mounted() {
        this.form = this.value
    },
    watch: {
        resetForm: function (newValue, oldValue) {
            if (newValue === true) {
                this.resetFormField();
            }
        },
        value: {
            handler(newValue) {
                this.form = newValue
            },
            deep: true
        },
        form: {
            handler: function (newForm) {
                this.updateConsumptionWhenSizeChanges()
                this.$emit('input', newForm)
            },
            deep: true
        },
    },
    methods: {
        colourSelected(panelId, colourId) {
            this.selectedPanelOptions[panelId].colourId = parseInt(colourId)
            this.form.customized_panels.push(this.selectedPanelOptions[panelId]);
            this.$forceUpdate();
        },

        panelFabricSelected(panelId, fabricId) {
            console.log('fabric selected', panelId, fabricId)
            this.selectedPanelOptions[panelId] = {
                id: panelId,
                fabricId: parseInt(fabricId),
                colourId: null,
            };
            const panel = this.parentStyle.panels.filter(panel => {
                return panel.id == panelId
            })[0];

            const fabric = panel.fabrics.filter(fabric => {
                return fabric.id == fabricId
            })[0];

            if(fabric == undefined) {
                alert('No Fabrics for panel ' + panel.name)
                return false;
            }

            if(fabric.variations.length  == 0 ) {
                alert('No Colours for fabric ' + fabric.name)
                return false;
            }

            const colours = fabric.variations.map(variation => {
                return variation.colour
            })

            this.panelColours[panelId] = colours;
            this.$forceUpdate();
        },

        styleCodeChange(code) {
            this.form.code = this.form.parent_style_code+' '+code
        },
        defaultPanel() {
            return {
                name: null,
                fabrics: [],
                default_fabric: {id: null},
                consumption: []
            }
        },
        resetPanels() {
            this.panel = this.defaultPanel()
        },
        updateConsumptionWhenSizeChanges() {
            /*
            this.panel.consumption = this.form.sizes.map(size => {
                console.log(">>>",size)
               return {
                   size: size,
                   amount: null
               }
            });
             */

             let temp_consumption = [...this.panel.consumption]
             this.panel.consumption = this.form.sizes.map(selected_size => {
                 let amount = null

                 let already_set_consumption = temp_consumption.filter((already_set_consumption) => {
                     return already_set_consumption.size.id === selected_size.id
                 })

                 if (already_set_consumption.length > 0) {
                     amount = already_set_consumption[0].amount;
                 }

                 return  {
                     size: {
                         id: selected_size.id,
                         name: selected_size.name
                     },
                     amount: amount
                 }
             })
        },

        resetFormField() {
        },
        addPanel() {
            this.form.panels.push(this.panel)
            this.panel = {
                name: null,
                fabric_ids: [],
                default_fabric: {id: null},
                consumption: []
            }
            this.show_panel_form = false;
        },
        handleEditPanelRow(dataRow) {
            this.show_panel_form = true;
            this.panel = dataRow;

            if (this.form.id != null) {
                this.panel.id = dataRow.id;
            } else {
                this.panel.id = null;
            }

            this.component_materials = [];
            if (typeof this.panel.fabrics != 'undefined') {
                this.panel.fabrics.forEach((item) => {
                    this.component_materials.push({
                        id: item.id,
                        name: item.name
                    });
                });
            }
            for (let [index, val] of this.form.panels.entries()) {
                if (dataRow.name == val.name) {
                    this.form.panels.splice(index, 1);
                }
            }
        },
        setEmbellishmentUploadFieldEmpty(i){
            this.form.embellishments_form[i].image_url = '';
            this.$refs.embellishments_images[i].value = null;
        },
        previewEmbImage(e, i) {
            const file = e.target.files[0];
            this.form.embellishments_form[i].image_url = URL.createObjectURL(file);
            this.form.embellishments_form[i].image = file;
        },
        addEmbellishmentItem() {
            if(typeof this.form.embellishments_form === 'undefined') {
                this.form.embellishments_form = [];
                this.form.embellishments_form.push({ type:'',position:'',image_url:'', image:'', already_uploaded: false })
            } else {
                this.form.embellishments_form.push({ type:'',position:'',image_url:'', image:'', already_uploaded: false })
            }

        },
        removeEmbellishmentItem(index) {
            this.form.embellishments_form.splice(index, 1)
        }
    },
    computed: {
        selectedFabrics() {
            return this.panel.fabrics;
        },
        selectedSizes() {
            return this.form.sizes;
            // if (this.value.sizes === undefined) {
            //     return []
            // }
            //
            // return this.sizes.filter((size) => {
            //     return this.value.sizes.includes(size.id)
            // })
        },
        disableAddPanelButton() {
            return false;
        },
        uploadFieldNotEmpty(){
            return this.url !== '';
        }
    }
}
</script>

<style>
.dropdown-menu {
    z-index:10030 !important;
}

.consumption .el-input-group__append {
    width: 80px !important;
    text-align: center;
}
</style>


<style scoped>

</style>
