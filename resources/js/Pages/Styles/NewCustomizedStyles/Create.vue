<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <template v-if="styleData.id">
                    Edit Style - {{styleData.code}}
                </template>
                <template v-else>
                    Add a new - New customized style
                </template>

            </h2>
        </template>

        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-5">
                    <el-alert
                        v-if="errors.length > 0"
                        title="Failed to create style"
                        type="error"
                        show-icon
                    >
                        <ul>
                            <li v-for="error in errors">
                                {{ error}}
                            </li>
                        </ul>
                    </el-alert>
                </div>

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
                                               :class="{'bg-contain bg-center bg-no-repeat' : uploadFieldNotEmpty}" :style="{ backgroundImage: 'url('+url+')'}"
                                               class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div class="flex flex-col justify-center items-center pt-5 pb-6" v-if="url === ''">
                                                <svg class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">JPEG, JPG or PNG</p>
                                            </div>
                                            <input name="style_image" id="dropzone-file" type="file" @change="previewImage" ref="style_code_image" class="hidden" />
                                        </label>
                                        <div class="absolute top-4 right-4 cursor-pointer" v-show="uploadFieldNotEmpty" @click="setUploadFieldEmpty">
                                            <el-tooltip content="Remove image" placement="top">
                                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                            </el-tooltip>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div>
                                <div>
                                    <div v-if="styleForm.styles_type !== 'General'">
                                        <div class="pt-2 pb-4">

                                            <label
                                                for="customer_name"
                                                class="block text-base font-medium text-gray-700"
                                            >
                                                Customer Name
                                            </label>

                                            <v-select
                                                id="customer_name"
                                                v-model="styleForm.customer"
                                                label="name"
                                                item-id="id"
                                                :options="customers"
                                                :reduce="customer => customer.id"
                                                @input="setSelectedCustomerId"
                                            ></v-select>
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
                            <general-style-form
                                @general-style-data="save"
                                :reset-form="reset_forms"
                                :categories="categories"
                                :materials="materials"
                                :colours="colours"
                                :item-types="itemTypes"
                                :sizes="sizes"
                                :embellishments="embellishments"
                                :factories="factories"
                                v-model="styleForm"
                                :errors="errors"
                                :styleCodeType="styleForm.styles_type"
                            ></general-style-form>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6" v-if="styleData.id">
                    <form-button @handle-on-click="update">
                        Update
                    </form-button>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6" v-else>
                    <form-button @handle-on-click="save">
                        save
                    </form-button>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import FormButton from "@/UIElements/FormButton";
import EditButton from "@/UIElements/EditButton";
import DeleteButton from "@/UIElements/DeleteButton";
import GeneralStyleForm from "@/Pages/Styles/NewCustomizedStyles/GeneralStyleForm";
import CustomStyleForm from "@/Pages/Styles/InternalStyles/CustomStyleForm";
import NewCustomStyleForm from "@/Pages/Styles/InternalStyles/NewCustomStyleForm";

export default {
    name: "Create",
    props: {
        customers: {
            type: Array,
            required: true
        },
        categories: {
            type: Array,
            required: true
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
        styles: {
            type: Array,
            required: true
        },
        styleType: {
            type: String
        },
        customer: {
            type: String
        },
        colours:{
            type: Array,
            required: true,
        },
        assetUrl: {
            type: String,
            required: true,
        }
    },
    components: {
        FormButton,
        EditButton,
        DeleteButton,
        GeneralStyleForm,
        CustomStyleForm,
        NewCustomStyleForm
    },
    data() {
        return {
            is_customized: false,
            show_new_customized_form: false,
            show_customized_fields: false,
            show_customized_form: false,
            payload: {
                select_style_code: '',
                select_customer: 2,
                style_information: {}
            },
            reset_forms: false,
            styleForm: {},
            url: '',
        }
    },
    mounted() {
        this.styleForm.styles_type = "General"
        this.styleForm = this.styleData

        if (this.styleType != null) {
            this.styleForm.styles_type = this.styleType
        }

        if (this.customer != null) {
            this.styleForm.customer = this.customers.find(item => {
                return item.id == this.customer
            });
        }

        if ( this.styleForm.style_image === "" || this.styleForm.style_image == null) {
            this.url = ''
        } else {
            this.url = this.assetUrl+this.styleForm.style_image;
        }

        if (this.styleForm.embellishments_form.length > 0) {
            let newEmbellishmentArr = [];
            for (const [index, embellishmentsKey] of this.styleForm.embellishments_form.entries()) {
                newEmbellishmentArr[index] = {
                    id:embellishmentsKey.id,
                    image: "",
                    image_url: embellishmentsKey.public_image_path,
                    position: embellishmentsKey.position,
                    type: embellishmentsKey.embellishment_type,
                    already_uploaded: true
                }
            }

            this.styleForm.embellishments_form.length = 0
            this.styleForm.embellishments_form = newEmbellishmentArr.slice();
        }
    },
    methods: {
        selectStyleType() {
            if (this.is_customized) {
                this.show_customized_fields = true;
            } else {
                this.payload.select_style_code = "";
                this.payload.select_customer = "";
                this.show_customized_fields = false;
            }
        },
        selectExtendedStyle(e) {
            e.preventDefault();
            if (this.payload.select_style_code !== '' && this.payload.select_customer !== '') {
                this.show_customized_form = true;
                this.show_new_customized_form = false;
            } else if (this.payload.select_style_code === '' && this.payload.select_customer !== '') {
                this.show_new_customized_form = true;
                this.show_customized_form = false;
            } else {
                this.show_customized_form = false;
            }
        },
        save() {
            if (this.$refs.style_code_image) {
                this.styleForm.image = this.$refs.style_code_image.files[0];
            }

            this.$inertia.post('/new-customized-styles', this.styleForm)
        },
        update() {
            if (this.$refs.style_code_image) {
                this.styleForm.image = this.$refs.style_code_image.files[0];
            }
            this.styleForm._method = 'put'
            this.$inertia.post('/new-customized-styles/' + this.styleForm.id, this.styleForm)
        },
        setSelectedStyleCode(value) {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    parent_id: value.id
                },
                onSuccess: () => {
                    if (this.parentStyleCode !== null) {
                        this.styleForm = this.parentStyleCode;
                        this.styleForm.parent_style_code = this.parentStyleCode.code;
                        this.styleForm.code = "";
                        this.styleForm.name = "";
                        this.styleForm.id = null;
                        this.styleForm.parent_style_id = value.id;
                        this.styleForm.parent_style = {
                            'id' : value.id,
                            'name' : value.name,
                        };

                        if (this.styleType != null) {
                            this.styleForm.styles_type = this.styleType
                        }

                        if (this.customer != null) {
                            this.styleForm.customer = this.customers.find(item => {
                                return item.id == this.customer
                            });
                        }
                    }
                },
            })
        },
        setSelectedCustomerId(value) {

            this.styleForm.customer = this.customers.find(item => {
                return item.id === value
            });

            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    customer: value
                }
            })

        },
        setStyleType(value) {
            this.$inertia.visit(this.$inertia.page.url, {
                preserveState: true,
                preserveScroll: true,
                data: {
                    type: value
                },
                onSuccess: () => {
                    this.styleForm.styles_type = value
                }
            })
        },
        previewImage(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        },
        setUploadFieldEmpty(){
            this.url = '';
            this.$refs.style_code_image.value = null;
        },
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    },
    computed: {
        uploadFieldNotEmpty(){
            return this.url !== '';
        }
    }
}
</script>

<style scoped>
input:checked ~ .dot {
    transform: translateX(100%);
    background-color: #374151;
}

</style>
