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
                            <inertia-link
                                :href="route('dashboard-flavour.index')"
                                >Flavour</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link
                                :href="route('dashboard-flavour.create')"
                                >Create</inertia-link
                            >
                        </li>
                    </ul>
                </div>

                <h1 class="font-bold text-2xl">Add Flavour</h1>
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
                    <FormField label="Flavour Price">
                        <FormControl
                            v-model="form.price"
                            name="price"
                            placeholder="Rp5000"
                            :icon="mdiCash"
                            type="number"
                        />
                    </FormField>
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
import { useForm } from "@inertiajs/inertia-vue3";
import { mdiCakeVariant, mdiCash } from "@mdi/js";
import { ref } from "vue";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

const isLoading = ref(false);

const form = useForm({
    name: "",
    price: 0,
});

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        form.post("/dashboard-flavour");
    }, 3000);
};
</script>
