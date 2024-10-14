<template>
    <div
        class="w-full h-fit py-2 px-4 rounded-b-lg border border-[#383F47] bg-base-100 outline outline-[#383F47] outline-offset-2"
        :ref="addressResultsContainer"
    >
        <div class="flex flex-col gap-2">
            <div
                class="flex items-center gap-2 w-full hover:bg-neutral cursor-pointer p-2"
                v-if="results.length > 0"
                v-for="item in results"
                :key="item.villages.id"
                @click="
                    selectAddress({
                        village: item.villages.village_name,
                        district: item.districts.district_name,
                        city: item.city,
                        province: item.province,
                    })
                "
            >
                <IconAddress />
                <p class="font-bold">
                    {{ item.villages.village_name }},
                    {{ item.districts.district_name }}, {{ item.city }},
                    {{ item.province }}
                </p>
            </div>
            <p v-else class="font-bold">Address not found!</p>
        </div>
    </div>
</template>

<script setup>
import IconAddress from "@/Components/Icons/IconAddress.vue";
import { ref } from "vue";

defineProps({
    results: {
        type: Array,
        default: [],
    },
    selectAddress: {
        type: Function,
        default: () => {},
    },
    addressResultsContainer: {
        type: String,
        default: null,
    },
});
</script>
