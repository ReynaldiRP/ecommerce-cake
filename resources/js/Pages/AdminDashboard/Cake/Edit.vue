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
                            <inertia-link :href="route('dashboard-cake')"
                                >Cake</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link>Edit</inertia-link>
                        </li>
                    </ul>
                </div>
                <h1 class="font-bold text-2xl">Edit Cake</h1>
            </div>
            <form @submit.prevent="submit">
                <CardBox>
                    <FormField label="Cake Name">
                        <FormControl
                            v-model="form.name"
                            placeholder="Base Cake"
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
                    <FormField label="Cake Size">
                        <FormControl
                            v-model="form.cake_size_id"
                            option-label="size"
                            option-value="id"
                            option-default="Choose the cake size"
                            :options="props.cakeSize"
                            :icon="mdiCakeVariant"
                            type="select"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.size"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.size }}
                    </NotificationBar>
                    <FormField label="Cake Base Price">
                        <FormControl
                            v-model="form.base_price"
                            placeholder="Rp5000"
                            :icon="mdiCash"
                            type="number"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.base_price"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.base_price }}
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
                    <FormField label="Cake Personalization Type">
                        <FormControl
                            v-model="form.personalization_type"
                            :options="cakePersonalizationType"
                            option-label="name"
                            option-value="name"
                            option-default="Choose the cake personalization type"
                            :icon="mdiCakeVariant"
                            type="select"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.personalization_type"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.personalization_type }}
                    </NotificationBar>
                    <template #footer>
                        <BaseButton
                            label="Submit"
                            color="success"
                            type="submit"
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
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import FormControl from "@/Components/DashboardAdmin/FormControl.vue";
import FormField from "@/Components/DashboardAdmin/FormField.vue";
import BaseButton from "@/Components/DashboardAdmin/BaseButton.vue";
import NotificationBar from "@/Components/DashboardAdmin/NotificationBar.vue";
import { mdiCakeVariant, mdiImageArea, mdiCash, mdiAlertCircle } from "@mdi/js";

import { ref, computed } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

const isLoading = ref(false);

const props = defineProps({
    cakes: {
        type: Object,
    },
    cakeSize: {
        type: Object,
    },
    errors: {
        type: Object,
    },
});

const cakePersonalizationType = [
    {
        id: 1,
        name: "customized",
    },
    {
        id: 2,
        name: "non-customized",
    },
];

const handleFileUpload = (event) => {
    form.image_url = event.target.files[0];
};

const form = useForm({
    id: props.cakes.id,
    name: props.cakes.name,
    base_price: props.cakes.base_price,
    image_url: "",
    cake_size_id: props.cakes.cake_size_id,
    personalization_type: props.cakes.personalization_type,
});

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        Inertia.post(`/dashboard-cake/${form.id}`, {
            _method: "put",
            id: form.id,
            name: form.name,
            base_price: form.base_price,
            image_url: form.image_url,
            cake_size_id: form.cake_size_id,
            personalization_type: form.personalization_type,
        });
    }, 3000);
};
</script>

<style lang="scss" scoped></style>
