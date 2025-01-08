<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-4">
            <section class="flex items-center justify-between">
                <div class="flex gap-2 items-center">
                    <h1 class="font-bold text-2xl">Tabel Order</h1>
                    <NotificationBar
                        class="w-[50%]"
                        v-if="message"
                        color="success"
                        :icon="mdiCheckCircle"
                    >
                        {{ message }}
                    </NotificationBar>
                </div>

                <button class="btn btn-info" @click="modalActive = true">
                    Export Laporan
                </button>
                <CardBoxModal
                    v-model="modalActive"
                    title="Export Laporan"
                    class="backdrop-contrast-50"
                    button-label="Download Laporan"
                    button="success"
                    :click-handler="exportProductPerformanceReport"
                >
                    <label class="form-control w-full max-w-xs">
                        <span class="text-sm m-0 p-0">
                            Pilih periode laporan.
                        </span>
                        <select
                            class="select select-ghost select-bordered w-full max-w-xs"
                            @change="
                                onChangeTransactionDate(
                                    $event.target.selectedIndex,
                                )
                            "
                        >
                            <option disabled selected>
                                Pilih Periode Laporan
                            </option>
                            <option
                                v-for="(month, index) in months"
                                :value="month.value"
                                :key="index"
                            >
                                {{ month.name }}
                            </option>
                        </select>
                    </label>
                </CardBoxModal>
            </section>

            <CardBox title="Daftar Pesanan">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Order Kode</th>
                                <th>Estimasi Tanggal Pengiriman</th>
                                <th>Alamat Penerima</th>
                                <th>Penerima Kue</th>
                                <th>Total Pembayaran</th>
                                <th>Detail Pemesanan</th>
                                <th>Pesanan Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(order, index) in ordersData"
                                :key="order.id"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ order.order_code }}</td>
                                <td>{{ order.estimated_delivery_date }}</td>
                                <td>{{ order.user_address }}</td>
                                <td>{{ order.cake_recipient }}</td>
                                <td>{{ formatPrice(order.total_price) }}</td>
                                <td>
                                    <inertia-link
                                        :href="route('order.show', order.id)"
                                        class="btn btn-outline btn-info"
                                    >
                                        Detail order
                                    </inertia-link>
                                </td>
                                <td>{{ formattedDate(order.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <template #footer>
                    <div class="flex justify-between items-center">
                        <Pagination
                            class="btn-outline"
                            :links="props.orders.links"
                            :next-page-url="props.orders.next_page_url"
                            :previous-page-url="props.orders.prev_page_url"
                        />
                        <p>
                            Page
                            <span>{{ props.orders.current_page }}</span> of
                            <span>{{ props.orders.last_page }}</span>
                        </p>
                    </div>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>

<script setup>
import LayoutAuthenticated from "@/Layouts/Admin.vue";
import SectionMain from "@/Components/DashboardAdmin/SectionMain.vue";
import Pagination from "@/Components/Pagination.vue";
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import { ref } from "vue";
import { mdiCheckCircle } from "@mdi/js";
import NotificationBar from "@/Components/DashboardAdmin/NotificationBar.vue";
import "vue-loading-overlay/dist/css/index.css";
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";
import CardBoxModal from "@/Components/DashboardAdmin/CardBoxModal.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    orders: Object,
});

const { formatPrice, formattedDate } = useAdminDashboardStore();
const modalActive = ref(false);
const ordersData = ref(props.orders.data);
const message = ref("");
const selectedTransactionDate = ref("");

const months = [
    { name: "Januari", value: "01" },
    { name: "Februari", value: "02" },
    { name: "Maret", value: "03" },
    { name: "April", value: "04" },
    { name: "Mei", value: "05" },
    { name: "Juni", value: "06" },
    { name: "Juli", value: "07" },
    { name: "Agustus", value: "08" },
    { name: "September", value: "09" },
    { name: "Oktober", value: "10" },
    { name: "November", value: "11" },
    { name: "Desember", value: "12" },
];

/**
 * Handles the change of the transaction date based on the selected index.
 *
 * @param {number} index - The index of the selected date in the months array.
 */
const onChangeTransactionDate = (index) => {
    // Get the transaction date based on the selected date
    selectedTransactionDate.value = months[index - 1].value;
};

/**
 * Export the performance product based on the selected transaction date.
 *
 * @returns {void}
 */
const exportProductPerformanceReport = () => {
    Inertia.get(route("export.product-performance-report"), {
        month: selectedTransactionDate.value,
    });
};
</script>
