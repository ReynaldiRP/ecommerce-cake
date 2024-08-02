<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <div class="flex gap-2 items-center">
                <h1 class="font-bold text-2xl">Product Table</h1>
                <BaseButton
                    color="success"
                    :href="route('dashboard-cake.create')"
                    :icon="mdiPlus"
                    :icon-size="[16, 16]"
                    class="w-14"
                />
            </div>

            <CardBox>
                <div class="overflow-x-auto">
                    <table class="table table-lg">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th></th>
                                <th>Cake Name</th>
                                <th>Cake Size</th>
                                <th>Cake Price</th>
                                <th>Cake Image</th>
                                <th>Cake Personalization Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- row 1 -->
                            <tr>
                                <th>1</th>
                                <td>Cy Ganderton</td>
                                <td>Quality Control Specialist</td>
                                <td>Blue</td>
                                <td>Blue</td>
                                <td>Blue</td>
                                <td>Blue</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <template #footer>
                    <div class="flex justify-between items-center">
                        <Pagination class="btn-outline" :numberPagination="3" />
                        <span>Page 1 of 3</span>
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
import { mdiPlus } from "@mdi/js";
</script>
