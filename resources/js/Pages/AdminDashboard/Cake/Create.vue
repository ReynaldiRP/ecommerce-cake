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
                            <inertia-link :href="route('dashboard-cake.index')"
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
                    <FormField label="Cake Size">
                        <FormControl
                            v-model="form.cake_size"
                            :options="cakeSizes"
                            option-label="size"
                            option-value="id"
                            :icon="mdiCakeVariant"
                            type="select"
                        />
                    </FormField>
                    <FormField label="Cake Base Price">
                        <FormControl
                            v-model="form.base_price"
                            placeholder="Rp5000"
                            :icon="mdiCash"
                            type="number"
                        />
                    </FormField>
                    <FormField label="Cake Image">
                        <FormControl
                            v-model="form.image_url"
                            @input="form.image_url = $event.target.files[0]"
                            :icon="mdiImageArea"
                            type="file"
                        />
                    </FormField>
                    <FormField label="Cake Personalization Type">
                        <FormControl
                            v-model="form.personalization_type"
                            :options="cakePersonalizationType"
                            option-label="name"
                            option-value="name"
                            @change="
                                () => console.log(form.personalization_type)
                            "
                            :icon="mdiCakeVariant"
                            type="select"
                        />
                    </FormField>
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
import { computed, ref } from "vue";
import { mdiCakeVariant, mdiImageArea, mdiCash } from "@mdi/js";
import { useForm } from "@inertiajs/inertia-vue3";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

const isLoading = ref(false);

const props = defineProps({
    cakes: {
        type: Array,
    },
});

// get cake size data from props cake
const cakeSizes = computed(() => {
    return props.cakes
        .map((cake) =>
            cake.cake_size
                ? { id: cake.cake_size.id, size: cake.cake_size.size }
                : null
        )
        .filter((cakeSize) => cakeSize !== null);
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
    image_url: "",
    cake_size: cakeSizes.value.length > 0 ? cakeSizes.value[0].id : null,
    personalization_type: cakePersonalizationType[0].name,
});

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        form.post("/dashboard-cake");
    }, 3000);
};
</script>
