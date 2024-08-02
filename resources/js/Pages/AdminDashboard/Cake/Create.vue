<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <div class="flex justify-between items-center">
                <div class="breadcrumbs text-sm">
                    <ul>
                        <li>
                            <inertia-link
                                :href="route('dashboard-cake.index')"
                                >Cake</inertia-link
                            >
                        </li>
                        <li>
                            <inertia-link
                                :href="route('dashboard-cake.create')"
                                >Create</inertia-link
                            >
                        </li>
                    </ul>
                </div>

                <h1 class="font-bold text-2xl">Add Product</h1>
            </div>
            <CardBox>
                <FormField label="Cake Name">
                    <FormControl
                        name="name"
                        placeholder="Base Cake"
                        :icon="mdiCakeVariant"
                    />
                </FormField>
                <FormField label="Cake Price">
                    <FormControl
                        name="price"
                        placeholder="Rp5000"
                        :icon="mdiCash"
                        type="number"
                    />
                </FormField>
                <FormField label="Cake Image">
                    <FormControl name="name" :icon="mdiImageArea" type="file" />
                </FormField>
                <FormField label="Cake Flavour">
                    <FormControl
                        :options="flavour"
                        v-model="flavour[0]"
                        name="name"
                        :icon="mdiFruitCherries"
                    />
                </FormField>
                <FormField label="Cake Topping">
                    <FormControl
                        :options="topping"
                        v-model="topping[0]"
                        name="name"
                        :icon="mdiCookie"
                    />
                </FormField>
                <template #footer>
                    <BaseButton label="Submit" color="success" type="submit" />
                </template>
            </CardBox>
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
import {
    mdiCakeVariant,
    mdiImageArea,
    mdiCash,
    mdiFruitCherries,
    mdiCookie,
} from "@mdi/js";

const flavour = [
    { id: 1, label: "Chocolate" },
    { id: 2, label: "Red Velvet" },
    { id: 3, label: "Cheese" },
];

const topping = [
    { id: 1, label: "Stroberry" },
    { id: 2, label: "Orange" },
    { id: 3, label: "Berry" },
];
</script>
