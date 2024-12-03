<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <div class="grid grid-cols-12">
                <div class="col-span-4 flex items-center gap-2">
                    <h1 class="font-bold text-2xl">Tabel Pembayaran</h1>
                </div>
            </div>
            <CardBox>
                <div class="overflow-x-auto">
                    <table class="table table-lg">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th></th>
                                <th>Transaksi Id</th>
                                <th>Kode Order</th>
                                <th>Metode Pembayaran</th>
                                <th>Status Pembayaran</th>
                                <th>Transaksi Dibuat</th>
                                <th>Transaksi Dibayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(payment, index) in props.payments.data"
                                :key="payment.id"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>
                                    {{ payment.transaction_id }}
                                </td>
                                <td>{{ payment.order_code }}</td>
                                <td>{{ payment.payment_method }}</td>
                                <td>
                                    <div
                                        class="btn btn-outline"
                                        :class="
                                            changeTransactionStatusColor[
                                                payment.payment_status
                                            ]
                                        "
                                        @click="modalActive = true"
                                    >
                                        {{ payment.payment_status }}
                                    </div>
                                </td>
                                <td>
                                    {{ payment.payment_created_at }}
                                </td>
                                <td>
                                    {{ payment.payment_paid_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <template #footer>
                    <div class="flex justify-between items-center">
                        <Pagination
                            class="btn-outline"
                            :links="props.payments.links"
                            :next-page-url="props.payments.next_page_url"
                            :previous-page-url="props.payments.prev_page_url"
                        />
                        <p>
                            Page
                            <span>{{ props.payments.current_page }}</span> of
                            <span>{{ props.payments.last_page }}</span>
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
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import Pagination from "@/Components/Pagination.vue";
import { computed } from "vue";

const props = defineProps({
    payments: Object,
});

const changeTransactionStatusColor = computed(() => {
    return {
        "Menunggu pembayaran": "btn-info",
        "Pembayaran dibatalkan": "btn-error",
        "Pesanan terbayar": "btn-success",
    };
});
</script>
