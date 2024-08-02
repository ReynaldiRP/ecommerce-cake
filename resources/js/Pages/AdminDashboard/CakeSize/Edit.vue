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
                            <inertia-link>Edit</inertia-link>
                        </li>
                    </ul>
                </div>

                <h1 class="font-bold text-2xl">Edit Cake Size</h1>
            </div>
            <form @submit.prevent="submit">
                <CardBox>
                    <FormField label="Cake Size">
                        <FormControl
                            v-model="form.size"
                            name="size"
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
                    <FormField label="Cake Size Price">
                        <FormControl
                            v-model="form.price"
                            name="price"
                            placeholder="Rp5000"
                            :icon="mdiCash"
                            type="number"
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

const props = defineProps({
    cakeSize: {
        type: Object,
    },
    errors: {
        type: Object,
    },
});

const isLoading = ref(false);

const form = useForm({
    id: props.cakeSize.id,
    size: props.cakeSize.size,
    price: props.cakeSize.price,
});

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        form.put(route("dashboard-size.update", { dashboard_size: form.id }));
    }, 3000);
};
</script>
