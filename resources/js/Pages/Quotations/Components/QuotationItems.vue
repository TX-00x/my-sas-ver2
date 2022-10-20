<template>
    <div>
        <div class="grid grid-cols-4 gap-3">
            <div>
                <div>
                    <label for="category" class="block">Category</label>
                </div>
                <el-select @change="onCategoryChanged" name="category" v-model="item.category_id" placeholder="Category">
                    <el-option
                        v-for="category in propCategories"
                        :key="category.id"
                        :label="category.name"
                        :value="category.id"
                    >
                    </el-option>
                </el-select>
            </div>

            <div>
                <div>
                    <label for="style_code" class="block">Style code</label>
                </div>
                <el-select name="style_code" @change="onStyleCodeChange" value-key="id" :disabled="propStyleCodes.length === 0" filterable v-model="item.style_code" placeholder="Style code">
                    <el-option
                        v-for="item in propStyleCodes"
                        :key="item.id"
                        :label="item.name"
                        :value="item"
                    >
                    </el-option>
                </el-select>
            </div>

            <div>
                <div>
                    <label for="quantity" class="block">Quantity</label>
                </div>
                <el-input placeholder="Quantity" name="quantity" v-model.number="item.quantity"></el-input>
            </div>
            <div>
                <div>
                    <label for="garment_price" class="block">Garment price</label>
                </div>
                <el-select @change="onItemPriceChange" name="garment_price" placeholder="Default Garment Price" v-model="item.price_type">
                    <el-option value="default" label="Default" />
                    <el-option value="custom" label="Custom" />
                </el-select>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-3 py-8">
            <div>
                <div>
                    <label for="embellishment_type" class="block">Embellishment type</label>
                </div>
                <el-select v-model="item.type" name="embellishment_type" placeholder="Select embellishment type">
                    <el-option value="cut_and_sew" label="Cut and Saw" />
                    <el-option value="sublimation" label="Sublimation" />
                </el-select>
            </div>
            <div class="col-span-2">
                <div>
                    <label for="notes" class="block">Notes</label>
                </div>
                <el-input
                    name="notes"
                    type="textarea"
                    :rows="2"
                    placeholder="Add notes"
                    v-model="item.notes">
                </el-input>
            </div>
            <div>
                <div class="flex flex-col">
                    <div>
                        <label for="custom_price" class="block">Custom price</label>
                    </div>
                    <el-input
                        v-model="item.unit_price"
                        :disabled="item.price_type !== 'custom'"
                        placeholder="Custom Price"
                        type="number"
                        min="0"
                        name="custom_price"
                    ></el-input>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-center">
            <cut-and-sew-table
                v-show="itemEmbellishmentType === 'cut_and_sew'"
                v-model="item.embellishments"
            ></cut-and-sew-table>
<!--            <sublimation-table-->
<!--                v-show="item.type === 'sublimation'"-->
<!--                :acount-payment="propAccountPayment"-->
<!--                v-model="item.embellishments"-->
<!--            ></sublimation-table>-->
        </div>

        <slot></slot>

        <div class="py-2 flex flex-row justify-between">
            <el-button type="danger" plain>Reset table</el-button>
            <el-button @click="addItem" type="primary">Add</el-button>
        </div>
    </div>
</template>

<script>
import CutAndSewTable from "@/Pages/Quotations/Components/CutAndSewTable";
import SublimationTable from "@/Pages/Quotations/Components/SublimationTable";
import embellishments from "../../Factory/Embellishments";

export default {
    name: "QuotationItems",
    components:{
        SublimationTable,
        CutAndSewTable
    },
    props: {
        value: {
            type: Array,
            required: true
        },
        propStyleCodes: {
            type: Array,
            required: true
        },
        propCategories: {
            type: Array,
            required: true
        },
        // propAccountPayment: {
        //     type: Boolean,
        //     required: true
        // },
        propEmbellishments: {
            type: Array,
            required: true
        }
    },
    data(){
        return {
            item: this.itemData(),
        }
    },
    mounted() {

    },
    watch: {
        itemEmbellishmentType: {
            deep: true,
            handler(embellishmentType) {
                if (embellishmentType === 'cut_and_sew') {
                    this.prepareEmbellishmentsForCutAndSaw();
                    return;
                }
            },
        },

        mutedItem: {
            deep: true,
            handler(item) {
                console.log('item updated', item)
                // update item unit total
                this.item.unit_price_total = this.item.unit_price * this.item.quantity;

                // update emblishment total
                let emTotal = 0;
                this.item.embellishments.forEach(em => {
                    emTotal = emTotal + em.total;
                })
                this.item.embellishment_total = emTotal

                // update gross total
                this.item.gross_price = this.item.embellishment_total + this.item.unit_price_total;
            }
        }
    },
    computed: {
        itemEmbellishmentType() {
            return this.item.type
        },

        mutedItem() {
            return this.item;
        }
    },
    methods:{
        onCategoryChanged() {
            this.$inertia.visit(
                route('quotations.create', {category_id: this.item.category_id}),
                {
                    preserveState: true,
                    preserveScroll: true,
                }
            )
        },

        onStyleCodeChange() {
            this.setDefaultPriceIfApplicable();
        },

        onItemPriceChange() {
            this.setDefaultPriceIfApplicable();
        },

        setDefaultPriceIfApplicable() {
            if (this.item.price_type === 'default' || this.item.price_type === null) {
                this.item.unit_price = this.item.style_code.default_price
            }
        },

        itemData() {
            return  {
                style_code: null,
                category_id: null,
                quantity: null,
                price_type: null,
                unit_price: null,
                unit_price_total : null,
                gross_price: 0,
                emblishment_type: null,
                notes: null,
                embellishments: [],
                embellishment_total: 0,
            };
        },
        addItem() {
            const items = this.value;
            items.push(this.item)

            this.$emit('input', items)
            this.item = this.itemData();
        },

        prepareEmbellishmentsForCutAndSaw() {
            this.item.embellishments = this.propEmbellishments.map(function (embellishment) {
                return Object.assign({
                    position: null,
                    quantity: 0,
                    total_cost: 0,
                    setup_quantity: 0,
                    total_setup_cost: 0,
                    total: 0,
                }, embellishment)
            });
        },
    }
}
</script>

<style scoped>

</style>
