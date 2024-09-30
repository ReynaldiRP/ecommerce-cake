<template>
    <div
        class="w-full h-fit py-2 px-4 rounded-b-lg border border-[#383F47] bg-base-100 outline outline-[#383F47] outline-offset-2"
    >
        <div class="flex flex-col gap-2">
            <div
                class="flex items-center gap-2 w-full hover:bg-neutral cursor-pointer p-2"
                v-for="item in results"
                :key="item.properties.place_id"
                @click="selectAddress(item.properties.formatted)"
            >
                <IconAddress />
                <p>{{ item.properties.formatted ?? "properties wrong" }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import IconAddress from "@/Components/Icons/IconAddress.vue";

defineProps({
    results: {
        type: Array,
        default: [],
    },
    selectAddress: {
        type: Function,
        default: () => {},
    },
});
</script>
