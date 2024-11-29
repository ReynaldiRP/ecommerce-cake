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
                                v-for="(order, index) in ordersData"
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
                                        class="btn btn-outline"
                                        :class="orderStatusColor[order.status]"
                                        @click="editOrderStatus(order)"
                                    >
                                        {{ order.status }}
                                    </div>
                                    <CardBoxModal
                                        v-model="modalActive"
                                        title="Ubah Status Pemesanan"
                                        class="backdrop-contrast-50"
                                        button-label="Simpan"
                                        button="success"
                                        :click-handler="
                                            () => updateOrderStatus(orderId)
                                        "
                                    >
                                        <div>
                                            <label
                                                class="form-control w-full max-w-xs"
                                            >
                                                <div class="label">
                                                    <span
                                                        class="label-text font-medium"
                                                        >Status Pesanan</span
                                                    >
                                                </div>
                                                <select
                                                    class="select select-ghost"
                                                    v-model="currentOrderStatus"
                                                >
                                                    <option disabled>
                                                        {{ currentOrderStatus }}
                                                    </option>
                                                    <option
                                                        v-for="status in orderStatusFiltered(
                                                            order,
                                                        )"
                                                        :key="status.id"
                                                    >
                                                        {{ status.name }}
                                                    </option>
                                                </select>
                                            </label>
                                        </div>
                                    </CardBoxModal>
                                </td>
                                <td>
                                    <button
                                        @click=""
                                        class="btn btn-outline btn-info"
                                    >
                                        Detail order
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
import CardBoxModal from "@/Components/DashboardAdmin/CardBoxModal.vue";
import { computed, ref } from "vue";
import axios from "axios";

const props = defineProps({
    orders: Object,
});

const modalActive = ref(false);
const ordersData = ref(props.orders.data);
const orderId = ref("");
const currentOrderStatus = ref("");

const orderStatus = [
    {
        id: 1,
        name: "Pesanan diproses",
    },
    {
        id: 2,
        name: "Pesanan dikemas",
    },
    {
        id: 3,
        name: "Pesanan dikirim",
    },
    {
        id: 4,
        name: "Pesanan diterima",
    },
];

/**
 * Computed property that returns a mapping of order statuses to their corresponding button classes.
 * @returns {Object} An object where the keys are order statuses and the values are button classes.
 */
const orderStatusColor = computed(() => {
    return {
        "Pesanan diproses": "btn-info",
        "Pesanan dikonfirmasi": "btn-info",
        "Pesanan dikemas": "btn-info",
        "Pesanan dikirim": "btn-info",
        "Pesanan diterima": "btn-success",
        "Pesanan dibatalkan": "btn-error",
        "Pesanan kadaluwarsa": "btn-error",
    };
});

/**
 * Filters the order statuses to exclude the current status of the given order.
 * @param {Object} order - The order object containing the current status.
 * @returns {Array} An array of order statuses excluding the current status.
 */
const orderStatusFiltered = (order) => {
    return orderStatus.filter(
        (statusOrder, index) => statusOrder.name !== order.status[index],
    );
};

/**
 * Edits the status of the given order.
 * @param {Object} order - The order object containing the order ID.
 */
const editOrderStatus = async (order) => {
    try {
        const response = await axios.get(
            route("order.edit-status", { order: order.id }),
            {
                params: {
                    order: order.id,
                },
            },
        );

        currentOrderStatus.value = response.data.order.status;
        orderId.value = response.data.order.id;
        modalActive.value = true;
    } catch (e) {
        console.error(e);
    }
};

const updateOrderStatus = async (order) => {
    try {
        const response = await axios.patch(
            route("order.update-status", { orderId: order }),
            {
                status: currentOrderStatus.value,
            },
            {
                params: {
                    orderId: order,
                },
            },
        );

        const index = ordersData.value.findIndex(
            (order) => order.id === response.data.order.id,
        );

        ordersData.value[index].status = response.data.order.status;
        modalActive.value = false;
    } catch (e) {
        console.error(e);
    }
};
</script>
