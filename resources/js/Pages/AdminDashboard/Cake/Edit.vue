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
                            <inertia-link :href="route('cake.index')"
                                >Kue</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link>Ubah</inertia-link>
                        </li>
                    </ul>
                </div>
                <h1
                    class="font-bold text-2xl text-color-dashboard-light dark:text-color-dashboard-dark"
                >
                    Ubah Kue
                </h1>
            </div>
            <form @submit.prevent="submit">
                <CardBox>
                    <FormField
                        label="Nama Kue"
                        class="text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
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
                    <FormField
                        label="Kategori Kue"
                        class="text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
                        <FormControl
                            v-model="form.category_id"
                            option-label="name"
                            option-value="id"
                            option-default="Choose the cake category"
                            :options="props.cakeCategory"
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
                    <FormField
                        label="Diskon Kue"
                        class="text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
                        <FormControl
                            v-model="form.discount_id"
                            option-label="discount_percentage"
                            option-value="id"
                            option-default="Pilih diskon kue"
                            :options="props.discounts"
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
                    <FormField
                        label="Harga Kue"
                        class="text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
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
                    <FormField
                        label="Gambar Kue"
                        class="text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
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
                    <FormField
                        label="Jenis Kue"
                        class="text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
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
                            label="Simpan"
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

const handleFileUpload = (event) => {
    form.image_url = event.target.files[0];
};

const form = useForm({
    id: props.cakes.id,
    name: props.cakes.name,
    base_price: props.cakes.base_price,
    image_url: "",
    category_id: props.cakes.category_id,
    discount_id: props.cakes.discount_id,
    personalization_type: props.cakes.personalization_type,
});

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        Inertia.post(route("cake.update", form.id), {
            _method: "put",
            id: form.id,
            name: form.name,
            base_price: form.base_price,
            image_url: form.image_url,
            category_id: form.category_id,
            discount_id: form.discount_id,
            personalization_type: form.personalization_type,
        });
    }, 3000);
};
</script>

<style lang="scss" scoped></style>
