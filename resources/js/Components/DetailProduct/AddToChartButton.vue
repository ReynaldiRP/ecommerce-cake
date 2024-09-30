<template>
    <div>
        <button
            class="btn btn-block text-base-300 hover:text-white bg-primary-color"
            :type="type"
        >
            <p v-show="!isSubmitting" class="font-bold">+ Add to Chart</p>
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
