<script setup>
import { mdiCog } from "@mdi/js";
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import NumberDynamic from "@/Components/DashboardAdmin/NumberDynamic.vue";
import BaseIcon from "@/Components/DashboardAdmin/BaseIcon.vue";
import BaseLevel from "@/Components/DashboardAdmin/BaseLevel.vue";
import PillTagTrend from "@/Components/DashboardAdmin/PillTagTrend.vue";
import BaseButton from "@/Components/DashboardAdmin/BaseButton.vue";

defineProps({
    number: {
        type: Number,
        default: 0,
    },
    value: {
        type: String,
        default: null,
    },
    icon: {
        type: String,
        default: null,
    },
    prefix: {
        type: String,
        default: null,
    },
    suffix: {
        type: String,
        default: null,
    },
    label: {
        type: String,
        default: null,
    },
    color: {
        type: String,
        default: null,
    },
    trend: {
        type: String,
        default: null,
    },
    trendType: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <CardBox>
        <BaseLevel v-if="trend" class="mb-3" mobile>
            <PillTagTrend :trend="trend" :trend-type="trendType" small />
            <BaseButton
                :icon="mdiCog"
                icon-w="w-4"
                icon-h="h-4"
                color="lightDark"
                small
            />
        </BaseLevel>
        <BaseLevel mobile>
            <div>
                <h3
                    class="text-lg leading-tight text-gray-500 dark:text-slate-400"
                >
                    {{ label }}
                </h3>
                <h1
                    class="text-3xl leading-tight font-semibold text-color-dashboard-light dark:text-color-dashboard-dark"
                >
                    <NumberDynamic
                        v-if="number"
                        :value="number"
                        :prefix="prefix"
                        :suffix="suffix"
                    />
                    <span class="text-2xl" v-else>{{ value }}</span>
                </h1>
            </div>
            <BaseIcon
                v-if="icon"
                :path="icon"
                size="48"
                w=""
                h="h-16"
                :class="color"
            />
        </BaseLevel>
    </CardBox>
</template>
