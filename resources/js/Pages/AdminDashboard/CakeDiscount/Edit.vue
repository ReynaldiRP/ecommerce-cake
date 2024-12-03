<template>
    <loading
        v-model:active="isLoading"
        :can-cancel="true"
        color="#EBA9AE"
        background-color="#B2BEB5"
    />
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <div class="flex justify-between items-center">
                <div class="breadcrumbs text-sm">
                    <ul>
                        <li>
                            <inertia-link :href="route('discount.index')"
                                >Diskon Kue</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link>Ubah</inertia-link>
                        </li>
                    </ul>
                </div>

                <h1 class="font-bold text-2xl">Ubah Diskon Kue</h1>
            </div>
            <form @submit.prevent="submit">
                <CardBox>
                    <FormField label="Nama Diskon">
                        <FormControl
                            v-model="form.name"
                            placeholder="10"
                            :icon="mdiSale"
                            type="text"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.name"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.name }}
                    </NotificationBar>
                    <FormField label="Presentase Diskon">
                        <FormControl
                            v-model="form.discount_percentage"
                            placeholder="10%"
                            :icon="mdiSale"
                            type="number"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.discount_percentage"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.discount_percentage }}
                    </NotificationBar>
                    <FormField label="Tanggal Mulai Diskon">
                        <FormControl
                            v-model="form.start_date"
                            placeholder="Rp5000"
                            :icon="mdiCalendar"
                            type="date"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.start_date"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.start_date }}
                    </NotificationBar>
                    <FormField label="Tanggal Berakhir Diskon">
                        <FormControl
                            v-model="form.end_date"
                            :icon="mdiCalendar"
                            type="date"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.end_date"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.end_date }}
                    </NotificationBar>
                    <template #footer>
                        <BaseButton
                            type="submit"
                            label="Submit"
                            color="success"
                        />
                    </template>
                </CardBox>
            </form>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from "@/Layouts/Admin.vue";
import SectionMain from "@/Components/DashboardAdmin/SectionMain.vue";
import FormControl from "@/Components/DashboardAdmin/FormControl.vue";
import FormField from "@/Components/DashboardAdmin/FormField.vue";
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import BaseButton from "@/Components/DashboardAdmin/BaseButton.vue";
import NotificationBar from "@/Components/DashboardAdmin/NotificationBar.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import {
    mdiCakeVariant,
    mdiCash,
    mdiAlertCircle,
    mdiSale,
    mdiCalendar,
} from "@mdi/js";
import { ref } from "vue";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

const props = defineProps({
    discount: {
        type: Object,
    },
    errors: {
        type: Object,
    },
});

const isLoading = ref(false);
console.log(props.discount);
const form = useForm({
    id: props.discount.id,
    name: props.discount.name,
    discount_percentage: props.discount.discount_percentage,
    start_date: props.discount.start_date,
    end_date: props.discount.end_date,
});

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        form.put(route("discount.update", form.id), form, {
            _method: "put",
        });
    }, 3000);
};
</script>
