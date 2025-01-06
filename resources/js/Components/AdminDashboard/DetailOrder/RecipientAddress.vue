<template>
    <section class="flex flex-col gap-2 py-4 px-2 border-y border-neutral">
        <h1 class="font-medium text-xl text-black">Alamat Penerima Kue</h1>
        <section class="flex flex-col gap-4 text-sm text-slate-500">
            <p>
                Nama Penerima :
                <span class="font-medium text-base-200">{{
                    order.cake_recipient
                }}</span>
            </p>
            <section class="col-span-6 flex flex-col gap-2">
                <p>
                    Nama Jalan :
                    <span class="font-medium text-base-200">{{
                        address.street_name
                    }}</span>
                </p>
                <p>
                    Nama Kota :
                    <span class="font-medium text-base-200">{{
                        address.city
                    }}</span>
                </p>
                <p>
                    Nama Provinsi :
                    <span class="font-medium text-base-200">{{
                        address.province
                    }}</span>
                </p>
                <p>
                    Tanggal Pesanan Dibuat :
                    <span class="font-medium text-base-200">{{
                        order.formatted_created_at
                    }}</span>
                </p>
                <p>
                    Tanggal Pengiriman atau Pengambilan :
                    <span class="font-medium text-base-200">{{
                        order.formatted_estimated_delivery_date
                    }}</span>
                </p>
                <p>
                    Metode Pengiriman atau Pengambilan :
                    <span class="font-medium text-base-200">{{
                        order.method_delivery
                    }}</span>
                </p>
            </section>
        </section>
    </section>
</template>

<script setup>
defineProps({
    order: Object,
    address: Object,
});
</script>
