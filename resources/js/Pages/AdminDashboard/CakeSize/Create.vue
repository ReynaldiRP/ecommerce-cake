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
                    <ul
                        class="text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
                        <li>
                            <inertia-link :href="route('size.index')"
                                >Ukuran Kue</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link :href="route('size.create')"
                                >Tambah</inertia-link
                            >
                        </li>
                    </ul>
                </div>

                <h1
                    class="font-bold text-2xl text-color-dashboard-light dark:text-color-dashboard-dark"
                >
                    Tambah Ukuran Kue
                </h1>
            </div>
            <form @submit.prevent="submit">
                <CardBox>
                    <FormField
                        label="Ukuran Kue (Cm)"
                        class="text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
                        <FormControl
                            v-model="form.size"
                            placeholder="10"
                            :icon="mdiCakeVariant"
                            type="number"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.size"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.size }}
                    </NotificationBar>
                    <FormField
                        label="Harga Ukuran Kue"
                        class="text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
                        <FormControl
                            v-model="form.price"
                            placeholder="Rp5000"
                            :icon="mdiCash"
                            type="number"
                            step="any"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.price"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.price }}
                    </NotificationBar>
                    <template #footer>
                        <BaseButton
                            type="submit"
                            label="Simpan"
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
import { mdiCakeVariant, mdiCash, mdiAlertCircle } from "@mdi/js";
import { ref } from "vue";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

const props = defineProps({ errors: Object });

const isLoading = ref(false);

const form = useForm({
    size: 0,
    price: 0,
});

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        form.post(route("size.store"));
    }, 3000);
};
</script>
