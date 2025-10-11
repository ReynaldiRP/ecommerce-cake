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
                        Tabel Rasa Kue
                    </h1>
                    <BaseButton
                        v-if="checkRolePermission"
                        color="success"
                        :href="route('flavour.create')"
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
                                <th>Rasa Kue</th>
                                <th>Harga Rasa Kue</th>
                                <th v-if="checkRolePermission">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(flavour, index) in props.flavour.data"
                                :key="flavour.id"
                                class="text-color-dashboard-light dark:text-color-dashboard-dark"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ flavour.name }}</td>
                                <td>{{ store.formatPrice(flavour.price) }}</td>
                                <!--                                <td>-->
                                <!--                                    <button-->
                                <!--                                        @click="-->
                                <!--                                            () => showImage(flavour.image_url)-->
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
                                            route('flavour.edit', flavour.id)
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
                                        title="Flavour Data"
                                        button="danger"
                                        button-label="Confirm"
                                        :click-handler="
                                            () => deleteHandler(flavour.id)
                                        "
                                        has-cancel
                                    >
                                        <p>
                                            Apakah kamu yakin untuk menghapus
                                            data rasa kue?
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
                            :links="props.flavour.links"
                            :next-page-url="props.flavour.next_page_url"
                            :previous-page-url="props.flavour.prev_page_url"
                            @paginate="handlePagination"
                        />
                        <p>
                            Page
                            <span>{{ props.flavour.current_page }}</span> of
                            <span>{{ props.flavour.last_page }}</span>
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
import { Inertia } from "@inertiajs/inertia";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
import { mdiCheckCircle, mdiPlus } from "@mdi/js";
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
    flavour: {
        type: Object,
    },
});

const deleteHandler = (flavourId) => {
    isLoading.value = true;

    const form = useForm({});

    setTimeout(() => {
        isLoading.value = false;

        form.delete(route("flavour.destroy", flavourId));
    }, 3000);
};

/**
 * Handle pagination navigation
 *
 * @param {string} url
 * @return void
 */
const handlePagination = (url) => {
    if (url) {
        Inertia.visit(url, {
            preserveState: true,
            preserveScroll: true,
        });
    }
};
</script>
