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
                        Tabel Diskon
                    </h1>
                    <BaseButton
                        v-if="checkRolePermission"
                        color="success"
                        :href="route('discount.create')"
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
                                <th>Nama Diskon</th>
                                <th>Total Diskon</th>
                                <th>Tanggal Mulai Diskon</th>
                                <th>Tanggal Berakhir Diskon</th>
                                <th v-if="checkRolePermission">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(discount, index) in props.discounts
                                    .data"
                                :key="discount.id"
                                class="text-color-dashboard-light dark:text-color-dashboard-dark"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>
                                    {{ discount.name }}
                                </td>
                                <td>
                                    {{
                                        store.formatDiscount(
                                            discount.discount_percentage,
                                        )
                                    }}
                                </td>
                                <td>{{ discount.start_date }}</td>
                                <td>{{ discount.end_date }}</td>
                                <td
                                    v-if="checkRolePermission"
                                    class="flex lg:justify-start justify-end gap-2"
                                >
                                    <inertia-link
                                        :href="
                                            route('discount.edit', discount.id)
                                        "
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
                                        class="backdrop-contrast-50 text-start"
                                        title="Diskon Kue"
                                        button="danger"
                                        button-label="Yakin"
                                        :click-handler="
                                            () => deleteHandler(discount.id)
                                        "
                                        has-cancel
                                    >
                                        <p>
                                            Apakah kamu yakin untuk menghapus
                                            data diskon ini?
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
                            :links="props.discounts.links"
                            :next-page-url="props.discounts.next_page_url"
                            :previous-page-url="props.discounts.prev_page_url"
                            @paginate="handlePagination"
                        />
                        <p>
                            Page
                            <span>{{ props.discounts.current_page }}</span> of
                            <span>{{ props.discounts.last_page }}</span>
                        </p>
                    </div>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import SectionMain from "@/Components/DashboardAdmin/SectionMain.vue";
import Pagination from "@/Components/Pagination.vue";
import LayoutAuthenticated from "@/Layouts/Admin.vue";
import CardBoxModal from "@/Components/DashboardAdmin/CardBoxModal.vue";
import { onMounted, ref } from "vue";
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";
import { mdiCheckCircle, mdiPlus } from "@mdi/js";
import BaseButton from "@/Components/DashboardAdmin/BaseButton.vue";
import NotificationBar from "@/Components/DashboardAdmin/NotificationBar.vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
import { storeToRefs } from "pinia";

const props = defineProps({
    discounts: Object,
});

const store = useAdminDashboardStore();
const { userRolePermission, checkRolePermission } = storeToRefs(store);

onMounted(() => {
    userRolePermission.value = "admin";
});

const modalActive = ref(false);
const isLoading = ref(false);

/**
 * Delete handler for deleting discount data
 *
 * @param {number} id
 * @returns {void}
 */
const deleteHandler = (id) => {
    try {
        isLoading.value = true;

        setTimeout(() => {
            Inertia.delete(route("discount.destroy", id));
            modalActive.value = false;
            isLoading.value = false;
        }, 2000);
    } catch (e) {
        console.error(e);
    }
};

/**
 * Handle pagination navigation
 *
 * @param {string} url
 * @return void
 */
const handlePagination = (url) => {
    if (url) {
        Inertia.visit(url, {
            preserveState: true,
            preserveScroll: true,
        });
    }
};
</script>
