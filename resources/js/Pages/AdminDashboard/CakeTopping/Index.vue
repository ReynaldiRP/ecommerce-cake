<template>
    <loading
        v-model:active="isLoading"
        :can-cancel="true"
        color="#EBA9AE"
        background-color="#B2BEB5"
    />

    <vue-easy-lightbox
        :visible="visibleRef"
        :imgs="imgsRef"
        @hide="onHide"
    ></vue-easy-lightbox>

    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <div class="grid grid-cols-12">
                <div class="col-span-4 flex items-center gap-2">
                    <h1
                        class="font-bold text-2xl text-color-dashboard-light dark:text-color-dashboard-dark"
                    >
                        Tabel Topping
                    </h1>
                    <BaseButton
                        v-if="checkRolePermission"
                        color="success"
                        :href="route('topping.create')"
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
                            <tr
                                class="text-color-dashboard-light dark:text-color-dashboard-dark"
                            >
                                <th></th>
                                <th>Nama Topping</th>
                                <th>Harga Topping</th>
                                <!--                                <th>Toppping Image</th>-->
                                <th v-if="checkRolePermission">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(topping, index) in props.topping.data"
                                :key="topping.id"
                                class="text-color-dashboard-light dark:text-color-dashboard-dark"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ topping.name }}</td>
                                <td>{{ store.formatPrice(topping.price) }}</td>
                                <!--                                <td>-->
                                <!--                                    <button-->
                                <!--                                        @click="-->
                                <!--                                            () => showImage(topping.image_url)-->
                                <!--                                        "-->
                                <!--                                        class="my-image-links btn btn-info"-->
                                <!--                                    >-->
                                <!--                                        <i-->
                                <!--                                            class="fa-solid fa-image text-lg text-neutral"-->
                                <!--                                        ></i>-->
                                <!--                                    </button>-->
                                <!--                                </td>-->
                                <td
                                    v-if="checkRolePermission"
                                    class="flex lg:justify-start justify-end gap-2"
                                >
                                    <inertia-link
                                        :href="
                                            route('topping.edit', topping.id)
                                        "
                                        class="btn btn-info"
                                        >Ubah</inertia-link
                                    >
                                    <button
                                        class="btn btn-error"
                                        @click="modalActive = true"
                                    >
                                        Hapus
                                    </button>
                                    <CardBoxModal
                                        v-model="modalActive"
                                        class="backdrop-contrast-50"
                                        title="Topping Data"
                                        button="danger"
                                        button-label="Confirm"
                                        :click-handler="
                                            () => deleteHandler(topping.id)
                                        "
                                        has-cancel
                                    >
                                        <p>
                                            Apakah Anda yakin ingin menghapus
                                            data topping ini?
                                        </p>
                                    </CardBoxModal>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <template #footer>
                    <div class="flex justify-between items-center">
                        <Pagination
                            class="btn-outline"
                            :links="props.topping.links"
                            :next-page-url="props.topping.next_page_url"
                            :previous-page-url="props.topping.prev_page_url"
                        />
                        <p>
                            Page
                            <span>{{ props.topping.current_page }}</span> of
                            <span>{{ props.topping.last_page }}</span>
                        </p>
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
import CardBoxModal from "@/Components/DashboardAdmin/CardBoxModal.vue";
import VueEasyLightbox from "vue-easy-lightbox";
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
import { mdiPlus, mdiCheckCircle } from "@mdi/js";
import { storeToRefs } from "pinia";

const store = useAdminDashboardStore();
const { userRolePermission, checkRolePermission } = storeToRefs(store);

onMounted(() => {
    userRolePermission.value = "admin";
});

const isLoading = ref(false);
const modalActive = ref(false);
const visibleRef = ref(false);
const imgsRef = ref([]);

const showImage = (imageUrl) => {
    imgsRef.value = [imageUrl];
    visibleRef.value = true;
};

const onHide = () => (visibleRef.value = false);

const props = defineProps({
    topping: {
        type: Object,
    },
});

const deleteHandler = (toppingId) => {
    isLoading.value = true;

    const form = useForm({});

    setTimeout(() => {
        isLoading.value = false;

        form.delete(route("topping.destroy", toppingId));
    }, 3000);
};
</script>
