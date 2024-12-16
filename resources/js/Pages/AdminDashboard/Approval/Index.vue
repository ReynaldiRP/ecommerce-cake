<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <h1 class="font-bold text-2xl">Tabel Persetujuan Perubahan</h1>
            <CardBox>
                <section class="overflow-x-auto">
                    <table class="table table-lg">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </section>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
<script setup>
import LayoutAuthenticated from "@/Layouts/Admin.vue";
import SectionMain from "@/Components/DashboardAdmin/SectionMain.vue";
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
</script>
