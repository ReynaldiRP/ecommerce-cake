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
                    <h1 class="font-bold text-2xl">Cake Size Table</h1>
                    <BaseButton
                        color="success"
                        :href="route('size.create')"
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
                                <th>Cake Size</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(cakeSize, index) in props.cakeSize.data"
                                :key="cakeSize.id"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ cakeSize.size }}(Cm)</td>
                                <td>{{ formatPrice(cakeSize.price) }}</td>
                                <td
                                    class="flex lg:justify-start justify-end gap-2"
                                >
                                    <inertia-link
                                        :href="route('size.edit', cakeSize.id)"
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
                                        title="Cake Size"
                                        button="info"
                                        button-label="Confirm"
                                        :click-handler="
                                            () => deleteHandler(cakeSize.id)
                                        "
                                        has-cancel
                                    >
                                        <p>
                                            Are you sure want to delete Category
                                            Cake ?
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
                            :links="props.cakeSize.links"
                            :next-page-url="props.cakeSize.next_page_url"
                            :previous-page-url="props.cakeSize.prev_page_url"
                        />
                        <p>
                            Page
                            <span>{{ props.cakeSize.current_page }}</span> of
                            <span>{{ props.cakeSize.last_page }}</span>
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
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

import { mdiPlus, mdiCheckCircle } from "@mdi/js";

const isLoading = ref(false);
const modalActive = ref(false);

const props = defineProps({
    cakeSize: {
        type: Object,
    },
});

const { formatPrice } = useAdminDashboardStore();

const deleteHandler = (cakeSizeId) => {
    isLoading.value = true;

    const form = useForm({});

    setTimeout(() => {
        isLoading.value = false;

        form.delete(route("size.destroy", cakeSizeId));
    }, 3000);
};
</script>
