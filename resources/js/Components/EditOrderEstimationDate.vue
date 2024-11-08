<template>
    <div class="flex flex-col gap-2">
        <label
            class="input input-sm flex items-center gap-2 input-disabled font-bold"
            @click="toggleHiddenEditOrderEstimationDate"
        >
            <BaseIcon :path="mdiCalendarEdit" size="" />
            <input type="text" :value="model" class="cursor-pointer" />
        </label>
        <div v-if="hiddenEditOrderEstimationDate" class="flex gap-2">
            <input
                type="date"
                class="input input-sm"
                v-model="updateEstimationDate"
                @change="handleOnChange"
            />
            <div class="flex items-center gap-2" v-if="showButtonEdit">
                <button class="btn btn-sm btn-success" @click="save">
                    Save
                </button>
                <button class="btn btn-sm btn-neutral" @click="cancel">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import BaseIcon from "@/Components/DashboardAdmin/BaseIcon.vue";
import { mdiCalendarEdit } from "@mdi/js";
import { ref } from "vue";

const props = defineProps({
    hiddenEditOrderEstimationDate: {
        type: Boolean,
        default: false,
    },
});

const showButtonEdit = ref(false);
const model = defineModel();
const updateEstimationDate = ref("");

const emit = defineEmits(["update:hiddenEditOrderEstimationDate"]);

const handleOnChange = () => {
    showButtonEdit.value = true;
};

const cancel = () => {
    updateEstimationDate.value = "";
    emit("update:hiddenEditOrderEstimationDate", false);
};

const save = () => {
    const dated = formatedDate(updateEstimationDate.value);
    model.value = dated;
    emit("update:hiddenEditOrderEstimationDate", false);
};

const toggleHiddenEditOrderEstimationDate = () => {
    emit(
        "update:hiddenEditOrderEstimationDate",
        !props.hiddenEditOrderEstimationDate
    );
};

const getDayOfWeekInIndonesian = (date) => {
    const daysOfWeek = [
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu",
    ];

    return daysOfWeek[date.getDay()];
};

const formatedDate = (date) => {
    const options = { year: "numeric", month: "long", day: "numeric" };
    const formattedDate = new Date(date).toLocaleDateString("id-ID", options);
    const day = getDayOfWeekInIndonesian(new Date(date));

    return `${day}, ${formattedDate}`;
};
</script>
