<template>
    <loading
        v-model:active="isLoading"
        :can-cancel="true"
        color="#EBA9AE"
        background-color="#B2BEB5"
    />
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <div class="grid grid-cols-12">
                <div class="col-span-4 flex items-center gap-2">
                    <h1 class="font-bold text-2xl">Flavour Table</h1>
                    <BaseButton
                        color="success"
                        :href="route('dashboard-flavour.create')"
                        :icon="mdiPlus"
                        :icon-size="16"
                    />
                </div>
                <NotificationBar
                    class="lg:col-span-8"
                    v-if="$page.props.flash.success"
                    color="success"
                    :icon="mdiCheckCircle"
                >
                    {{ $page.props.flash.success }}
                </NotificationBar>
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
                                v-for="flavour in props.flavour"
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
                                    <button
                                        class="btn btn-error"
                                        @click="() => deleteHandler(flavour.id)"
                                    >
                                        Delete
                                    </button>
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
import NotificationBar from "@/Components/DashboardAdmin/NotificationBar.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

import { mdiPlus, mdiCheckCircle } from "@mdi/js";

const isLoading = ref(false);

const props = defineProps({
    flavour: {
        type: Object,
    },
});

const deleteHandler = (flavourId) => {
    isLoading.value = true;

    const form = useForm({});

    setTimeout(() => {
        isLoading.value = false;

        form.delete(route("dashboard-flavour.destroy", flavourId));
    }, 3000);
};
</script>
