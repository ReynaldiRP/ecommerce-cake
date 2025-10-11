<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-4">
            <section class="flex items-center justify-between">
                <div class="flex gap-2 items-center">
                    <h1
                        class="font-bold text-2xl text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
                        Tabel Pesanan
                    </h1>
                </div>
            </section>

            <CardBox title="Daftar Pesanan">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <!--          TODO: Add the current order status              -->
                            <tr
                                class="text-color-dashboard-light dark:text-color-dashboard-dark"
                            >
                                <th></th>
                                <th>Pesanan Dibuat</th>
                                <th>Estimasi Tanggal Pengiriman</th>
                                <th>Penerima Kue</th>
                                <th>Total Pembayaran</th>
                                <th>Status Pesanan</th>
                                <th>Detail Pemesanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(order, index) in ordersData"
                                :key="order.id"
                                class="text-color-dashboard-light dark:text-color-dashboard-dark"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ formattedDate(order.created_at) }}</td>
                                <td>{{ order.estimated_delivery_date }}</td>
                                <td>{{ order.cake_recipient }}</td>
                                <td>{{ formatPrice(order.total_price) }}</td>
                                <td>
                                    <button
                                        class="btn btn-outline"
                                        :class="orderStatusStyle[order.status]"
                                    >
                                        {{ order.status }}
                                    </button>
                                </td>
                                <td>
                                    <inertia-link
                                        :href="route('order.show', order.id)"
                                        class="btn btn-outline btn-info"
                                    >
                                        Detail order
                                    </inertia-link>
                                </td>
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
                            @paginate="handlePagination"
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
import { computed, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import "vue-loading-overlay/dist/css/index.css";
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";

const props = defineProps({
    orders: Object,
});

const { formatPrice, formattedDate } = useAdminDashboardStore();
const ordersData = ref(props.orders.data);
const orderStatusStyle = computed(() => {
    return {
        "Menunggu pembayaran": "btn-info",
        "Pesanan diterima": "btn-success",
        "Pesanan dikonfirmasi": "btn-info",
        "Pesanan diproses": "btn-info",
        "Pesanan dikemas": "btn-info",
        "Pesanan dikirim": "btn-info",
        "Pesanan dibatalkan": "btn-error",
        "Pesanan kadaluarsa": "btn-error",
    };
});

/**
 * Handle pagination navigation
 *
 * @param {string} url
 * @return void
 */
const handlePagination = (url) => {
    console.log(url);

    if (url) {
        Inertia.visit(url, {
            preserveState: true,
            preserveScroll: true,
        });
    }
};
</script>
