<template>
    <div>
        <div>
            <el-divider content-position="left"><h3 class="text-lg font-bold">General</h3></el-divider>
            <div class="py-4">
                <form>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">

                            <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 gap-4">
                                <div class="col-span-1 sm:col-span-1">
                                    <label for="style_code_general_style"
                                           class="block text-sm font-medium text-gray-700">
                                        Style code</label>
                                    <input type="text" name="style_code_general_style"
                                           v-model="form.code"
                                           id="style_code_general_style"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                <!-- End of Panel Add form -->
                <div class="p-5 border-2 border-gray-200">
                    <el-table
                        :data="form.panels"
                        stripe
                        style="width: 100%"
                    >

                        <el-table-column
                            prop="name"
                            label="Name"
                            width="180">
                        </el-table-column>

                        <el-table-column
                            label="Fabrics"
                        >
                            <template slot-scope="scope">
                                {{ scope.row.fabrics.map(fabric => fabric.name).join(', ') }}
                            </template>
                        </el-table-column>

                        <el-table-column
                            prop="color.name"
                            label="Color"
                            width="180">
                        </el-table-column>

                        <el-table-column
                            label="Consumption"
                            width="180">
                            <template slot-scope="scope">
                                <div v-for="consumption in scope.row.consumption">
                                    <label> <b>{{ consumption.size.name }} : </b></label>
                                    <span> {{ consumption.amount }}</span>
                                </div>
                            </template>
                        </el-table-column>

                        <el-table-column
                            label="Action"
                            width="180">
                            <template slot-scope="scope">
                                <form-button @handle-on-click="handleEditPanelRow(scope.row)">
                                    Edit
                                </form-button>
                            </template>
                        </el-table-column>

                    </el-table>
                </div>
                <!-- Panel Add form -->
                <div>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 bg-white sm:p-6">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 pb-6">
                                <label class="block text-sm text-gray-700 mb-2" for="grid-first-name">
                                    Component Name
                                </label>
                                <input
                                    class="appearance-none block w-full text-gray-700 border rounded leading-tight focus:outline-none focus:bg-white"
                                    id="grid-first-name"
                                    type="text"
                                    v-model="panel.name"
                                >
                            </div>

                            <div class="w-full px-3 mb-6 md:mb-0 pb-6">
                                <label class="block text-gray-700 text-sm mb-2" for="grid-first-name">
                                    Fabrics
                                </label>

                                <div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <app-select
                                                v-model="panel.fabrics"
                                                filterable
                                                multiple
                                                :multiple-limit="1"
                                                placeholder="Select Fabric"
                                                :options="materials"
                                                @change="selectedMaterial"
                                                option-label="name"
                                                option-value="id"
                                            ></app-select>
                                        </div>

                                        <div>
                                            <app-select
                                                v-model="panel.color"
                                                filterable
                                                placeholder="Select fabric colour"
                                                no-data-text="No colours selected"
                                                no-match-text="No Result"
                                                :options="colours"
                                                option-label="name"
                                                option-value="id"
                                            ></app-select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 pb-6">
                                <label class="block text-sm text-gray-700 mb-2" for="grid-first-name">
                                    Consumption
                                </label>

                                <div>
                                    <div class="consumption mb-2" v-for="(consumption, index) in panel.consumption">
                                        <el-input placeholder="Enter Consumption" v-model="consumption.amount">
                                            <template slot="append">{{ consumption.size.name }}</template>
                                        </el-input>
                                    </div>

                                    <div v-if="selectedSizes.length === 0">
                                        <span><i class="text-sm text-gray-500">No Sizes selected for this style code</i></span>
                                    </div>

                                </div>

                            </div>
                            <hr>

                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 pb-6">
                                <form-button @handle-on-click="addPanel">
                                    Add Panel
                                </form-button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <el-divider content-position="left"><h3 class="text-lg font-bold">Trims / Accessories</h3></el-divider>
            <div class="py-4">
                <form>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 gap-4">
                                <div class="w-64">
                                    <label for="trims_accessories_general_style" class="text-base font-medium text-gray-700">Trims/Accessories</label>
                                    <select name="trims_accessories_general_style" id="trims_accessories_general_style"
                                            v-model="form.trims_accessories"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="">Select option</option>
                                        <option value="mid-dritech-nub">Mid Dritech NUB</option>
                                        <option value="mid-dritech-grandeur">Mid Dritech Grandeur</option>
                                        <option value="mid-dritech-jongstit">Mid Dritech Jongstit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                        <el-input
                            v-model="item.position"
                            placeholder="Select a position"
                        ></el-input>
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
</template>

<script>
import FormButton from "@/UIElements/FormButton";
import EditButton from "@/UIElements/EditButton";
import DeleteButton from "@/UIElements/DeleteButton";
import AppSelect from "@/UIElements/AppSelect";
import Label from "@/Jetstream/Label";

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
                panels: []
            },
            panel: this.defaultPanel(),
            component_materials : [],
            show_panel_form: false
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
        }
    },
    methods: {
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
        selectedMaterial(value) {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    material_id: value[0]
                },
            })
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
            this.form.embellishments_form[i].already_uploaded = false
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
