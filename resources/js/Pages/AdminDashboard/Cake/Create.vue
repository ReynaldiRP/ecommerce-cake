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
                            <inertia-link :href="route('dashboard-cake.create')"
                                >Create</inertia-link
                            >
                        </li>
                    </ul>
                </div>

                <h1 class="font-bold text-2xl">Add Product</h1>
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
                            :options="props.sizeCake"
                            option-label="size"
                            option-value="id"
                            option-default="Choose the cake size"
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
                    <FormField label="Cake Base Price">
                        <FormControl
                            v-model="form.description"
                            placeholder="Cakes description"
                            type="textarea"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.description"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.description }}
                    </NotificationBar>
                    <FormField label="Cake Image">
                        <FormControl
                            v-model="form.image_url"
                            @input="form.image_url = $event.target.files[0]"
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
import FormControl from "@/Components/DashboardAdmin/FormControl.vue";
import FormField from "@/Components/DashboardAdmin/FormField.vue";
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import BaseButton from "@/Components/DashboardAdmin/BaseButton.vue";
import NotificationBar from "@/Components/DashboardAdmin/NotificationBar.vue";

import { ref } from "vue";
import { mdiCakeVariant, mdiImageArea, mdiCash, mdiAlertCircle } from "@mdi/js";
import { useForm } from "@inertiajs/inertia-vue3";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

const isLoading = ref(false);

const props = defineProps({
    sizeCake: {
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

const form = useForm({
    name: "",
    base_price: 0,
    description: "",
    image_url: "",
    cake_size_id: "",
    personalization_type: "",
});

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        form.post("/dashboard-cake");
    }, 3000);
};
</script>
