<template>
    <div class="form-control">
        <label class="flex items-center gap-2 cursor-pointer">
            <input
                type="checkbox"
                class="checkbox btn-outline [--chkbg:theme(colors.pink.400)] [--chkfg:white] checked:border-pink-400"
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
