<template>
    <div class="form-control" v-for="(items, index) in flavour" :key="index">
        <label class="flex items-center gap-2 cursor-pointer">
            <input
                type="radio"
                name="radio-1"
                class="radio btn-outline checked:bg-pink-400 checked:outline-white"
            />
            <span class="text-base text-base-200 font-medium"
                >{{ items.name }}
            </span>
        </label>
    </div>
</template>

<script setup>
defineProps({
    flavour: {
        type: Array,
    },
});
</script>
