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
                            <inertia-link :href="route('dashboard-size.index')"
                                >Cake Size</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link :href="route('dashboard-size.create')"
                                >Create</inertia-link
                            >
                        </li>
                    </ul>
                </div>

                <h1 class="font-bold text-2xl">Add Cake Size</h1>
            </div>
            <form @submit.prevent="submit">
                <CardBox>
                    <FormField label="Cake Size (Cm)">
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
                    <FormField label="Cake Sized Price">
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
        form.post("/dashboard-size");
    }, 3000);
};
</script>
