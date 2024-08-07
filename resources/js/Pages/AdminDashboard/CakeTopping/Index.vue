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
                    <h1 class="font-bold text-2xl">Topping Table</h1>
                    <BaseButton
                        color="success"
                        :href="route('dashboard-topping.create')"
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
                                <th>Topping Name</th>
                                <th>Topping Price</th>
                                <th>Toppping Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(topping, index) in props.topping.data"
                                :key="topping.id"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ topping.name }}</td>
                                <td>Rp{{ topping.price }}</td>
                                <td>
                                    <button class="my-image-links btn btn-info">
                                        <i
                                            class="fa-solid fa-image text-lg text-neutral"
                                        ></i>
                                    </button>
                                </td>
                                <td
                                    class="flex lg:justify-start justify-end gap-2"
                                >
                                    <inertia-link
                                        :href="
                                            route(
                                                'dashboard-topping.edit',
                                                topping.id
                                            )
                                        "
                                        class="btn btn-info"
                                        >Edit</inertia-link
                                    >
                                    <button
                                        class="btn btn-error"
                                        @click="modalActive = true"
                                    >
                                        Delete
                                    </button>
                                    <CardBoxModal
                                        v-model="modalActive"
                                        class="backdrop-contrast-50"
                                        title="Topping Data"
                                        button="info"
                                        button-label="Confirm"
                                        :click-handler="
                                            () => deleteHandler(topping.id)
                                        "
                                        has-cancel
                                    >
                                        <p>
                                            Are you sure want to delete Topping
                                            ?
                                        </p>
                                    </CardBoxModal>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <template #footer>
                    <div class="flex justify-between items-center">
                        <Pagination
                            class="btn-outline"
                            :links="props.topping.links"
                            :next-page-url="props.topping.next_page_url"
                            :previous-page-url="props.topping.prev_page_url"
                        />
                        <p>
                            Page
                            <span>{{ props.topping.current_page }}</span> of
                            <span>{{ props.topping.last_page }}</span>
                        </p>
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
import CardBoxModal from "@/Components/DashboardAdmin/CardBoxModal.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

import { mdiPlus, mdiCheckCircle } from "@mdi/js";

const isLoading = ref(false);
const modalActive = ref(false);

const props = defineProps({
    topping: {
        type: Object,
    },
});

const deleteHandler = (toppingId) => {
    isLoading.value = true;

    const form = useForm({});

    setTimeout(() => {
        isLoading.value = false;

        form.delete(route("dashboard-topping.destroy", toppingId));
    }, 3000);
};
</script>
