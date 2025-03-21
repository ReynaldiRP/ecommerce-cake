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
                    <h1
                        class="font-bold text-2xl text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
                        Cake Size Table
                    </h1>
                    <BaseButton
                        v-if="checkRolePermission"
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
                            <tr
                                class="text-color-dashboard-light dark:text-color-dashboard-dark"
                            >
                                <th></th>
                                <th>Ukuran Kue</th>
                                <th>Harga</th>
                                <th v-if="checkRolePermission">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(cakeSize, index) in props.cakeSize.data"
                                :key="cakeSize.id"
                                class="text-color-dashboard-light dark:text-color-dashboard-dark"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ cakeSize.size }}(Cm)</td>
                                <td>{{ store.formatPrice(cakeSize.price) }}</td>
                                <td
                                    v-if="checkRolePermission"
                                    class="flex lg:justify-start justify-end gap-2"
                                >
                                    <inertia-link
                                        :href="route('size.edit', cakeSize.id)"
                                        class="btn btn-info"
                                        >Ubah</inertia-link
                                    >
                                    <button
                                        class="btn btn-error"
                                        @click="modalActive = true"
                                    >
                                        Hapus
                                    </button>
                                    <CardBoxModal
                                        v-model="modalActive"
                                        class="backdrop-contrast-50"
                                        title="Ukuran Kue"
                                        button="danger"
                                        button-label="Yakin"
                                        :click-handler="
                                            () => deleteHandler(cakeSize.id)
                                        "
                                        has-cancel
                                    >
                                        <p>
                                            Apakah kamu yakin untuk menghapus
                                            ukuran kue ?
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
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

import { mdiPlus, mdiCheckCircle } from "@mdi/js";
import { storeToRefs } from "pinia";

const isLoading = ref(false);
const modalActive = ref(false);

const props = defineProps({
    cakeSize: {
        type: Object,
    },
});

const store = useAdminDashboardStore();
const { userRolePermission, checkRolePermission } = storeToRefs(store);

onMounted(() => {
    userRolePermission.value = "admin";
});

const deleteHandler = (cakeSizeId) => {
    isLoading.value = true;

    const form = useForm({});

    setTimeout(() => {
        isLoading.value = false;

        form.delete(route("size.destroy", cakeSizeId));
    }, 3000);
};
</script>
