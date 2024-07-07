<template>
    <div>
        <button
            class="btn btn-block text-base-300 hover:text-white bg-primary-color"
            :type="type"
        >
            Add to Chart
        </button>
    </div>
</template>

<script setup>
defineProps({
    type: {
        type: String,
    },
});
</script>
