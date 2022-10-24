<template>
    <button
        :type="type"
        :disabled="disabled"
        :class="{'bg-red-600 text-white': isFilledButton, 'bg-transparent text-red-600 hover:text-white': isTextOnlyButton, 'opacity-25':disabled}"
        class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-600 transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
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
