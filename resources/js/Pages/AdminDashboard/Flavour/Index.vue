<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <div class="flex gap-2 items-center">
                <h1 class="font-bold text-2xl">Flavour Table</h1>
                <BaseButton
                    color="success"
                    :href="route('dashboard-flavour.create')"
                    :icon="mdiPlus"
                    :icon-size="16"
                />
            </div>

            <CardBox>
                <div class="overflow-x-auto">
                    <table class="table table-lg">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th></th>
                                <th>Flavour Name</th>
                                <th>Flavour Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- row 1 -->
                            <tr
                                v-for="flavour in prop.flavour"
                                :key="flavour.id"
                            >
                                <th>{{ flavour.id }}</th>
                                <td>{{ flavour.name }}</td>
                                <td>Rp{{ flavour.price }}</td>
                                <td
                                    class="flex lg:justify-start justify-end gap-2"
                                >
                                    <inertia-link
                                        :href="
                                            route(
                                                'dashboard-flavour.edit',
                                                flavour.id
                                            )
                                        "
                                        class="btn btn-info"
                                        >Edit</inertia-link
                                    >
                                    <inertia-link class="btn btn-error"
                                        >Delete</inertia-link
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <template #footer>
                    <div class="flex justify-between items-center">
                        <Pagination class="btn-outline" :numberPagination="3" />
                        <span>Page 1 of 3</span>
                    </div>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from "@/Layouts/Admin.vue";
import BaseButton from "@/Components/DashboardAdmin/BaseButton.vue";
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import SectionMain from "@/Components/DashboardAdmin/SectionMain.vue";
import Pagination from "@/Components/Pagination.vue";
import { mdiPlus } from "@mdi/js";

const prop = defineProps({
    flavour: {
        type: Object,
    },
});
</script>
