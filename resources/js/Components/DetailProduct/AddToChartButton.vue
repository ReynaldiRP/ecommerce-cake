<template>
    <div>
        <button
            class="btn btn-block text-base-300 hover:text-white bg-primary-color"
            :type="type"
        >
            <span v-show="!isSubmitting">Add to Chart</span>
            <span
                v-show="isSubmitting"
                class="loading loading-spinner loading-md"
            ></span>
        </button>
    </div>
</template>

<script setup>
defineProps({
    type: {
        type: String,
    },
    isSubmitting: {
        type: Boolean,
        default: false,
    },
});
</script>
