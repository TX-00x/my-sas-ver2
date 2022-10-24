<template>
    <button
        :type="type"
        @click="$emit('handle-on-click',$event)"
        :disabled="disabled"
        :class="{'bg-gray-800 text-white': isFilledButton, 'bg-transparent text-gray-800 hover:text-white': isTextOnlyButton, 'opacity-25':disabled}"
        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
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
        buttonType: {
            type: String,
            default: 'filled'
        },
        disabled: {
            type: Boolean,
            default: false
        }

    },
    computed: {
        isFilledButton() {
            return this.buttonType === 'filled'
        },
        isTextOnlyButton() {
            return this.buttonType === 'textOnly'
        }
    }
}
</script>

<style scoped>

</style>
