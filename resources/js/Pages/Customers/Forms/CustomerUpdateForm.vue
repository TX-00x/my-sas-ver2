<template>
    <form @submit.prevent="onSubmit" enctype="multipart/form-data">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-x-8 gap-y-4">
                    <div>
                        <div class="pt-2 pb-4">
                            <label for="customer_logo" class="block text-base font-medium text-gray-700">Customer
                                Logo</label>
                            <div
                                class="mt-1 pb-4 border-dotted h-48 rounded-lg border-dashed border-2 border-gray-400 flex justify-center items-center">

                                    <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden">
                                        <img class="w-32" v-if="fileUploadUrl" :src="fileUploadUrl" alt="uploaded-file-thumbnail">
                                    </div>

                                <div class="p-2 flex flex-col justify-between leading-normal">

                                    <label class="bg-gray-300 w-52 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded inline-flex items-center">
                                        <i class="fas fa-file-upload fa-lg"></i>
                                        <span class="pl-2">Upload the logo</span>
                                        <input v-on:change="onFileChange" ref="logo" type="file"
                                               class="opacity-0 w-2" name="customer_logo"
                                               id="customer_logo">
                                    </label>

                                </div>

                            </div>
                        </div>
                        <div class="pt-2 pb-4">
                            <label for="full_name" class="block text-base font-medium text-gray-700">Full
                                name</label>
                            <input v-model="customer.name" type="text" name="full_name" id="full_name"
                                   autocomplete="given-name"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="pt-2 pb-4">
                            <label for="email_address" class="block text-base font-medium text-gray-700">Email
                                address</label>
                            <input v-model="customer.email" type="email" name="email_address"
                                   id="email_address" autocomplete="email"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div>
                        <div class="pt-2 pb-4">
                            <label for="cs_agent" class="block text-base font-medium text-gray-700">Customer
                                service agent</label>
                            <el-select class="w-full" v-model="customer.csAgents" multiple placeholder="Select">
                                <el-option
                                    v-for="(csAgent,index) in csAgents"
                                    :key="csAgent.id"
                                    :label="csAgent.name"
                                    :value="csAgent.id">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="pt-2 pb-4">
                            <label for="sales_agent"
                                   class="block text-base font-medium text-gray-700">Sales agent</label>
                            <el-select class="w-full" v-model="customer.salesAgents" multiple placeholder="Select">
                                <el-option
                                    v-for="saleAgent in salesAgents"
                                    :key="saleAgent.id"
                                    :label="saleAgent.name"
                                    :value="saleAgent.id">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="pt-2 pb-4">
                            <label for="description" class="block text-base font-medium text-gray-700">Details</label>
                            <textarea v-model="customer.description" type="text" name="description"
                                      id="description"
                                      class="mt-1 resize-none focus:ring-indigo-500 focus:border-indigo-500 block w-full h-28 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <form-button>
                Update
            </form-button>
        </div>
    </form>



</template>

<script>
import CustomerContactsForm from "@/Pages/Customers/Forms/CustomerAddressesForm";
import FormButton from "@/UIElements/FormButton";
export default {
    name: "CustomerUpdateForm",
    components: {
        CustomerContactsForm,
        FormButton
    },
    props: {
        initCustomer: {
            required: true,
            type: Object
        },
        csAgents: {
            required: true,
            type: Array
        },
        salesAgents: {
            required: true,
            type: Array
        }
    },
    mounted() {
        this.customer = {
            name: this.initCustomer.name,
            email: this.initCustomer.email,
            description: this.initCustomer.description,
            // cs_agent_id: this.initCustomer.cs_agent_id,
            // sales_agent_id: this.initCustomer.sales_agent_id,
            csAgents: this.initCustomer.csAgents.map(agent => agent.id),
            salesAgents: this.initCustomer.salesAgents.map(sale => sale.id),
            logo_id: this.initCustomer.logo_id,
        }
        const headers = {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
        axios.get('/get-logo/'+this.customer.logo_id, { headers: headers}).
        then(response => {
            this.uploads.currentLogo = response.data;
            this.fileUploadUrl = this.uploads.currentLogo;
        }).catch(error => {
            console.log(error);
        });
    },
    data() {
        return {
            customer: {},
            fileUploadUrl: null,
            uploadInstructions: true,
            submitted: false,
            uploads: {
                logo:'',
                currentLogo:''
            },
        }
    },
    methods: {
        onFileChange(e) {
            this.uploads.logo = e.target.files[0];
            const isUploaded = e.target.files.length;
            if (isUploaded !== 0) {
                const headers = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
                const form = new FormData();
                form.append('logo', this.uploads.logo);

                axios.post('/upload-logo', form, { headers: headers}).
                then(response => {
                    this.customer.logo_id = response.data.logo_id;
                }).catch(error => {
                    console.log(error);
                });

                this.fileUploadUrl = URL.createObjectURL(this.uploads.logo);
                this.uploadInstructions = false;
            } else {
                this.uploadInstructions = true;
                this.fileUploadUrl = this.uploads.currentLogo;
            }
        },
        onSubmit() {
            this.$emit('onSubmit', this.customer)
        }
    }
}
</script>

<style scoped>

</style>
