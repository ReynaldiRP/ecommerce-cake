<template>
    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <div class="grid grid-cols-12">
                <div class="col-span-4 flex items-center gap-2">
                    <h1 class="font-bold text-2xl">Cakes Table</h1>
                    <BaseButton
                        color="success"
                        :href="route('dashboard-cake.create')"
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
                            <tr
                                v-for="(cakes, index) in props.cakes"
                                :key="cakes.id"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ cakes.name }}</td>
                                <td>
                                    {{
                                        cakes.cake_size_id
                                            ? cakes.cake_size.size
                                            : ""
                                    }}
                                </td>
                                <td>{{ cakes.base_price }}</td>
                                <td>
                                    <button class="my-image-links btn btn-info">
                                        <i
                                            class="fa-solid fa-image text-lg text-neutral"
                                        ></i>
                                    </button>
                                </td>
                                <td>{{ cakes.personalization_type }}</td>
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
import NotificationBar from "@/Components/DashboardAdmin/NotificationBar.vue";
import { mdiPlus, mdiCheckCircle } from "@mdi/js";

const props = defineProps({
    cakes: {
        type: Array,
    },
});
</script>
