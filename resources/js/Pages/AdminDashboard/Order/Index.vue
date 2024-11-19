<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-4">
            <h1 class="font-bold text-2xl">Tabel Order</h1>

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
                                <th>Status Pemesanan</th>
                                <th>Detail Pemesanan</th>
                                <th>Pesanan Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(order, index) in props.orders.data"
                                :key="order.id"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ order.order_code }}</td>
                                <td>{{ order.estimated_delivery_date }}</td>
                                <td>{{ order.user_address }}</td>
                                <td>{{ order.cake_recipient }}</td>
                                <td>{{ order.total_price }}</td>
                                <td>
                                    <div
                                        :class="{
                                            'btn btn-info btn-outline':
                                                order.status ===
                                                'pesanan dikonfirmasi',
                                            'btn btn-success btn-outline':
                                                order.status === 'terbayar',
                                            'btn btn-error btn-outline':
                                                order.status === 'dibatalkan' ||
                                                order.status === 'kadaluwarsa',
                                        }"
                                    >
                                        {{ order.status }}
                                    </div>
                                </td>
                                <td>
                                    <button
                                        @click=""
                                        class="btn btn-outline btn-info"
                                    >
                                        Detail Order
                                    </button>
                                </td>
                                <td>{{ order.created_at }}</td>
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

const props = defineProps({
    orders: Object,
});
</script>
