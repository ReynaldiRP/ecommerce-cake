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
                            <inertia-link :href="route('topping.index')"
                                >Topping</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link :href="route('topping.create')"
                                >Tambah</inertia-link
                            >
                        </li>
                    </ul>
                </div>

                <h1
                    class="font-bold text-2xl text-color-dashboard-light dark:text-color-dashboard-dark"
                >
                    Tambah Topping
                </h1>
            </div>
            <form @submit.prevent="submit">
                <CardBox>
                    <FormField
                        label="Topping Kue"
                        class="text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
                        <FormControl
                            v-model="form.name"
                            name="name"
                            placeholder="Cookies"
                            :icon="mdiCookie"
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
                        label="Harga Topping"
                        class="text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
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
                    <!--                    <FormField label="Topping Image">-->
                    <!--                        <FormControl-->
                    <!--                            v-model="form.image_url"-->
                    <!--                            :icon="mdiImageArea"-->
                    <!--                            @input="form.image_url = $event.target.files[0]"-->
                    <!--                            type="file"-->
                    <!--                        />-->
                    <!--                    </FormField>-->
                    <!--                    <NotificationBar-->
                    <!--                        v-if="props.errors.image_url"-->
                    <!--                        color="danger"-->
                    <!--                        :icon="mdiAlertCircle"-->
                    <!--                    >-->
                    <!--                        {{ props.errors.image_url }}-->
                    <!--                    </NotificationBar>-->
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
import { mdiCash, mdiAlertCircle, mdiCookie } from "@mdi/js";
import { ref } from "vue";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

const props = defineProps({ errors: Object });

const isLoading = ref(false);

const form = useForm({
    name: "",
    price: 0,
    image_url: "",
});

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        form.post(route("topping.store"));
    }, 3000);
};
</script>
