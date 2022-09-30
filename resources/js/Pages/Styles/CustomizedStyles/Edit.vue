<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <template v-if="styleData.id">
                    Edit customized style - {{styleData.code}}
                </template>
                <template v-else>
                    Create a customized style
                </template>

            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl rounded-md border">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-x-8 gap-y-4">
                            <div>
                                <div class="pt-2 pb-4">
                                    <label
                                        for="style_image"
                                        class="block text-base font-medium text-gray-700"
                                    >
                                        Style image
                                    </label>

                                    <div class="flex justify-center items-center w-full relative">
                                        <label for="dropzone-file"
                                               :style="{ backgroundImage: 'url('+styleData.style_image+')'}"
                                               class="bg-contain bg-center bg-no-repeat flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div>
                                <div>
                                    <div v-if="styleData.styles_type !== 'General'">
                                        <div class="pt-2 pb-4">

                                            <label
                                                for="customer_name"
                                                class="block text-base font-medium text-gray-700"
                                            >
                                                Customer Name
                                            </label>

                                            <input
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5"
                                                type="text"
                                                :placeholder="styleData.customer.name"
                                                disabled="true">
                                            </input>
                                        </div>
                                        <div class="pt-2 pb-4" v-if="styleData.styles_type === 'Customized'">
                                            <div class="pt-2 pb-4">

                                                <label for="parent_style_code"
                                                       class="block text-base font-medium text-gray-700">
                                                    Extending Parent Style Code
                                                </label>

                                                <input
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5"
                                                    type="text"
                                                    :placeholder="styleData.parent_style.code"
                                                    disabled="true">
                                                </input>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl rounded-md border mt-5">
                    <div class="bg-gray-500 pl-5 pt-2 pb-2 text-white">
                        <h4>Style information</h4>
                    </div>
                    <div class="p-5">
                        <div>
                            <el-divider content-position="left"><h3 class="text-lg font-bold">General</h3></el-divider>
                            <div class="py-4">
                                <form>
                                    <div class="shadow overflow-hidden sm:rounded-md">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                                <div class="col-span-1 sm:col-span-1">
                                                    <label class="block text-sm font-medium text-gray-700">Parent Style code</label>
                                                    <input type="text" name="parent_style_code"
                                                           :placeholder="styleData.parent_style.code"
                                                           :disabled="true"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="col-span-1 sm:col-span-1">
                                                    <label class="block text-sm font-medium text-gray-700">Style code extension</label>
                                                    <input type="text" name="parent_style_code"
                                                           :placeholder="styleData.code"
                                                           :disabled="true"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="col-span-1 sm:col-span-1">
                                                    <label for="style_name_general_style"
                                                           class="block text-sm font-medium text-gray-700">
                                                        Style name</label>
                                                    <input type="text" name="style_name_general_style"
                                                           :placeholder="styleData.name"
                                                           :disabled="true"
                                                           id="style_name_general_style"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div class="col-span-1 sm:col-span-1">
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Category
                                                    </label>
                                                    <div class="flex flex-row">
                                                        <div v-for="category in styleData.categories" class="mt-1 pr-1">
                                                            <div class="border border-gray-400 h-8 w-24 mb-4 md:mb-0 rounded-md inline-flex items-center justify-center">
                                                                <div tabindex="0" aria-label="gray border badge" class="focus:outline-none flex items-center">
                                                                    <span class="text-sm text-gray-700 dark:text-gray-100 font-normal">{{category.name}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-5">

                                            </div>
                                            <div class="mt-5 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-1 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Item type
                                                    </label>
                                                    <input type="text" name="parent_style_code"
                                                           :placeholder="styleData.item_type.name"
                                                           :disabled="true"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div>
                                                    <label
                                                        for="production_time_general_style"
                                                        class="block text-sm font-medium text-gray-700"
                                                    >
                                                        Production time
                                                    </label>
                                                    <input type="text" name="parent_style_code"
                                                           :placeholder="styleData.production_time"
                                                           :disabled="true"
                                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Sizes
                                                    </label>
                                                    <div class="flex flex-wrap">
                                                        <div v-for="size in styleData.sizes" class="mt-1 pr-1">
                                                            <div class="border border-gray-400 h-8 w-24 mb-4 md:mb-0 rounded-md inline-flex items-center justify-center">
                                                                <div tabindex="0" aria-label="gray border badge" class="focus:outline-none flex items-center">
                                                                    <span class="text-sm text-gray-700 dark:text-gray-100 font-normal">{{size.name}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Factory
                                                    </label>
                                                    <div class="flex flex-wrap">
                                                        <div v-for="factory in styleData.factories" class="mt-1 pr-1">
                                                            <div class="border border-gray-400 h-8 w-24 mb-4 md:mb-0 rounded-md inline-flex items-center justify-center">
                                                                <div tabindex="0" aria-label="gray border badge" class="focus:outline-none flex items-center">
                                                                    <span class="text-sm text-gray-700 dark:text-gray-100 font-normal">{{factory.name}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                        <tr v-for="panel in thisStyle.panels" :key="panel.id" v-show="selectedPanelsObj !== typeof('undefined')">
                                            <td>{{ panel.name }}</td>
                                            <td>
                                                <select v-model="selectedPanelsObj[panel.id].fabricId" class="px-2 my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5" @change="(event) => panelFabricSelected(panel.id, event.target.value)">
                                                    <option>Select Material</option>
                                                    <option v-for="fabric in panel.fabrics" :key="fabric.id" :value="fabric.id"> {{ fabric.name }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select v-model="selectedPanelsObj[panel.id].colourId"  class="px-2 my-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5" @change="(event) => colourSelected(panel.id, event.target.value)" >
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
                                <el-row class="py-4" :gutter="10" justify="center" type="flex" :key="index" v-for="(item, index) in form.embellishments_form">
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
                                            <div class="flex flex-col justify-center items-center pt-5 pb-6" v-if="item.image_url === ''">
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
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <form-button @handle-on-click="update">
                            Update
                        </form-button>
                    </div>
                </div>
            </div>
        </div>


    </app-layout>
</template>

<script>
import FormButton from "@/UIElements/FormButton";
import AppSelect from "@/UIElements/AppSelect";

export default {
    name: "Edit",
    components:{
        FormButton,
        AppSelect
    },
    props: {
        factories: {
            type: Array,
            required: true
        },
        styleData: {
            type: Object,
            required: true,
        },
        materials: {
            type: Array,
            required: true,
        },
        errors: {
            type: Object,
            required: false
        },
        parentStyleCode: {
            type: Object
        },
        styleType: {
            type: String
        },
        colours: {
            type: Array,
            required: true,
        },
        selectedPanels: {
            type: Object
        },
        parentStyle: {
            required: true,
            type: Object
        },
        embellishments: {
            type: Array,
            required: true
        },
        thisStyle: {
            required: true,
            type: Object
        },
        assetUrl: {
            required: true,
            type: String

        }
    },
    data() {
        return {
            form: {
                customized_panels: [],
                embellishments_form: [],
            },
            selectedPanelOptions:{},
            panelColours: {},
            customized_style_code: '',
            panel: this.defaultPanel(),
            component_materials : [],
            show_panel_form: false,
            selectedPanelsObj: {},
        }
    },
    mounted() {
        this.selectedPanelsObj = this.selectedPanels;
        this.form.customized_panels = [];
        Object.entries(this.selectedPanelsObj).forEach(item => {
            this.panelFabricSelected(item[1].id, item[1].fabricId)
            this.colourSelected(item[1].id, item[1].colourId)
        })
        this.form.customized_panels = [];

        if (this.styleData.embellishments_form.length > 0) {
            let newEmbellishmentArr = [];
            for (const [index, embellishmentsKey] of this.styleData.embellishments_form.entries()) {
                newEmbellishmentArr[index] = {
                    id:embellishmentsKey.id,
                    image: "",
                    image_url: embellishmentsKey.public_image_path,
                    position: { name:this.capitalizeFirstLetter(embellishmentsKey.position), value: embellishmentsKey.position },
                    type: embellishmentsKey.embellishment_type,
                    already_uploaded: true
                }
            }
            this.form.embellishments_form.length = 0
            this.form.embellishments_form = newEmbellishmentArr.slice();
        }
    },
    methods: {
        colourSelected(panelId, colourId) {
            this.selectedPanelOptions[panelId].colourId = parseInt(colourId)
            this.$forceUpdate();
        },

        panelFabricSelected(panelId, fabricId) {
            this.selectedPanelOptions[panelId] = {
                id: panelId,
                fabricId: parseInt(fabricId),
                colourId: null,
            };
            const panel = this.thisStyle.panels.filter(panel => {
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
        },
        setEmbellishmentUploadFieldEmpty(i){
            this.form.embellishments_form[i].image_url = '';
            this.$refs.embellishments_images[i].value = null;
        },
        previewEmbImage(e, i) {
            const file = e.target.files[0];
            this.form.embellishments_form[i].image_url = URL.createObjectURL(file);
            this.form.embellishments_form[i].image = file;
            this.form.embellishments_form[i].already_uploaded = false
        },
        update() {
            this.form.customized_panels = this.selectedPanelsObj;
            this.form._method = 'put'
            this.$inertia.post('/customized-styles/' + this.thisStyle.id, this.form)
        },
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    },
    computed: {
        selectedFabrics() {
            return this.panel.fabrics;
        },
        disableAddPanelButton() {
            return false;
        },
    }
}
</script>

<style scoped>

</style>
