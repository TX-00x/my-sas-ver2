<template>
    <button :type="type" @click="$emit('handle-on-click',$event)"
            :class="getStyle"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:shadow-outline-gray transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "FormButton",
    props: {
        type: {
            type: String,
            default: 'submit',
        },
        btnStyle: {
            type: String,
            default: 'primary',
            required: false
        }
    },
    computed: {
        getStyle() {
            switch (this.btnStyle) {
                case 'primary':
                    return 'bg-gray-800 text-white hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray';
                case 'danger':
                    return 'bg-red-800 text-white hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:shadow-outline-red';
                case 'outlined':
                    return 'text-gray-800 hover:text-white border border-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray';
                default:
                    return 'bg-gray-800 text-white hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray';
            }
        }
    }
}
</script>

<style scoped>

</style>
