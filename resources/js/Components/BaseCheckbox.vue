<template>
    <div class="form-control">
        <label class="flex items-center gap-2 cursor-pointer">
            <input
                type="checkbox"
                class="checkbox btn-outline hover:bg-base-200"
            />
            <span class="text-base text-base-200 font-medium">{{ label }}</span>
        </label>
    </div>
</template>

<script setup>
defineProps({
    label: {
        type: String,
    },
});
</script>
