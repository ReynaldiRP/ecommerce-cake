<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-4">
            <section class="flex items-center justify-between">
                <div class="flex gap-2 items-center">
                    <h1 class="font-bold text-2xl">Tabel Order</h1>
                </div>
            </section>

            <CardBox title="Daftar Pesanan">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <!--          TODO: Add the current order status              -->
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
import "vue-loading-overlay/dist/css/index.css";
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";

const props = defineProps({
    orders: Object,
});

const { formatPrice, formattedDate } = useAdminDashboardStore();
const ordersData = ref(props.orders.data);
</script>
