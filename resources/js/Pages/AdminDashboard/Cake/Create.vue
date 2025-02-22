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
                            <inertia-link :href="route('cake.index')"
                                >Kue</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link :href="route('cake.create')"
                                >Tambah</inertia-link
                            >
                        </li>
                    </ul>
                </div>

                <h1 class="font-bold text-2xl">Add Product</h1>
            </div>
            <form @submit.prevent="submit">
                <CardBox>
                    <FormField label="Nama Kue">
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
                    <FormField label="Kategori Kue">
                        <FormControl
                            v-model="form.category_id"
                            :options="props.cakeCategory"
                            option-label="name"
                            option-value="id"
                            option-default="Pilih kategori kue"
                            :icon="mdiCakeVariant"
                            type="select"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.category_id"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.category_id }}
                    </NotificationBar>
                    <FormField label="Diskon Kue">
                        <FormControl
                            v-model="form.discount_id"
                            :options="props.discounts"
                            option-label="discount_percentage"
                            option-value="id"
                            option-default="Pilih diskon kue"
                            :icon="mdiCakeVariant"
                            type="select"
                        />
                    </FormField>
                    <NotificationBar
                        v-if="props.errors.discount_id"
                        color="danger"
                        :icon="mdiAlertCircle"
                    >
                        {{ props.errors.discount_id }}
                    </NotificationBar>
                    <FormField label="Harga Kue">
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
                    <FormField label="Deskripsi Kue">
                        <FormControl
                            v-model="form.description"
                            placeholder="Deskripsi kue"
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
                    <FormField label="Foto Kue">
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
                    <FormField label="Jenis Kue">
                        <FormControl
                            v-model="form.personalization_type"
                            :options="cakePersonalizationType"
                            option-label="name"
                            option-value="name"
                            option-default="Pilih jenis kue"
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
    cakeCategory: {
        type: Object,
    },
    discounts: {
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
    description: null,
    image_url: "",
    category_id: "",
    discount_id: "",
    personalization_type: "",
});

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        form.post(route("cake.store"));
    }, 3000);
};
</script>
