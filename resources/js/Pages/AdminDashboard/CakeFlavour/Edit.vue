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
                            <inertia-link :href="route('dashboard-flavour')"
                                >Flavour</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link>Edit</inertia-link>
                        </li>
                    </ul>
                </div>

                <h1 class="font-bold text-2xl">Edit Flavour</h1>
            </div>
            <form @submit.prevent="submit">
                <CardBox>
                    <FormField label="Flavour Cake">
                        <FormControl
                            v-model="form.name"
                            name="name"
                            placeholder="Chocolate"
                            :icon="mdiCakeVariant"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.name"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.name }}
                    </NotificationBar>
                    <FormField label="Flavour Price">
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
                    <FormField label="Cake Image">
                        <FormControl
                            @change="handleFileUpload"
                            :icon="mdiImageArea"
                            type="file"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.image_url"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.image_url }}
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
import { Inertia } from "@inertiajs/inertia";
import { mdiCakeVariant, mdiCash, mdiAlertCircle, mdiImageArea } from "@mdi/js";
import { ref } from "vue";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

const props = defineProps({
    flavour: {
        type: Object,
    },
    errors: {
        type: Object,
    },
});

const isLoading = ref(false);

const form = useForm({
    id: props.flavour.id,
    name: props.flavour.name,
    price: props.flavour.price,
    image_url: null,
});

const handleFileUpload = (event) => {
    form.image_url = event.target.files[0];
};

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        Inertia.post(`/dashboard-flavour/${form.id}`, {
            _method: "put",
            id: form.id,
            name: form.name,
            price: form.price,
            image_url: form.image_url,
        });
    }, 3000);
};
</script>
