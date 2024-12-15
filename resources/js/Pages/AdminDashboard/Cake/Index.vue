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
                    <h1 class="font-bold text-2xl">Cakes Table</h1>
                    <BaseButton
                        v-if="checkRolePermission"
                        color="success"
                        :href="route('cake.create')"
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
                                <th>Cake Category</th>
                                <th>Cake Price</th>
                                <th>Cake Discount</th>
                                <th>Cake Description</th>
                                <th>Cake Image</th>
                                <th>Cake Personalization Type</th>
                                <th v-if="checkRolePermission">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(cakes, index) in props.cakes.data"
                                :key="cakes.id"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ cakes.name }}</td>
                                <td>
                                    {{
                                        cakes.category_id
                                            ? cakes.category.name
                                            : ""
                                    }}
                                </td>
                                <td>
                                    {{ store.formatPrice(cakes.base_price) }}
                                </td>
                                <td>
                                    {{
                                        store.formatDiscount(
                                            cakes.discount?.discount_percentage,
                                        )
                                    }}
                                </td>
                                <td>
                                    {{ descriptionLength(cakes.description) }}
                                </td>
                                <td>
                                    <button
                                        @click="
                                            () =>
                                                showImage(
                                                    cakes.image_url
                                                        ? cakes.image_url
                                                        : 'assets/image/default-img.jpg',
                                                )
                                        "
                                        class="my-image-links btn btn-info"
                                    >
                                        <i
                                            class="fa-solid fa-image text-lg text-neutral"
                                        ></i>
                                    </button>
                                </td>
                                <td>{{ cakes.personalization_type }}</td>
                                <td v-if="checkRolePermission">
                                    <div class="flex justify-end gap-2">
                                        <inertia-link
                                            :href="
                                                route('cake.edit', {
                                                    dashboard_cake: cakes.id,
                                                })
                                            "
                                            class="btn btn-info"
                                            >Edit</inertia-link
                                        >
                                        <button
                                            class="btn btn-error"
                                            @click="modalActive = true"
                                        >
                                            Delete
                                        </button>
                                        <CardBoxModal
                                            v-model="modalActive"
                                            class="backdrop-contrast-50"
                                            title="Cakes"
                                            button="danger"
                                            button-label="Confirm"
                                            :click-handler="
                                                () => deleteHandler(cakes.id)
                                            "
                                            has-cancel
                                        >
                                            <p>
                                                Are you sure want to delete Cake
                                                ?
                                            </p>
                                        </CardBoxModal>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <template #footer>
                    <div class="flex justify-between items-center">
                        <Pagination
                            class="btn-outline"
                            :links="props.cakes.links"
                            :next-page-url="props.cakes.next_page_url"
                            :previous-page-url="props.cakes.prev_page_url"
                        />
                        <p>
                            Page <span>{{ props.cakes.current_page }}</span> of
                            <span>{{ props.cakes.last_page }}</span>
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
import CardBoxModal from "@/Components/DashboardAdmin/CardBoxModal.vue";
import Pagination from "@/Components/Pagination.vue";
import NotificationBar from "@/Components/DashboardAdmin/NotificationBar.vue";
import VueEasyLightbox from "vue-easy-lightbox";
import { mdiCheckCircle, mdiPlus } from "@mdi/js";
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
import { storeToRefs } from "pinia";

const props = defineProps({
    cakes: {
        type: Object,
    },
});

const store = useAdminDashboardStore();
const isLoading = ref(false);
const modalActive = ref(false);
const visibleRef = ref(false);
const imgsRef = ref([]);

const { userRolePermission, checkRolePermission } = storeToRefs(store);

onMounted(() => {
    userRolePermission.value = "admin";
});

const showImage = (imageUrl) => {
    imgsRef.value = [imageUrl];
    visibleRef.value = true;
};

const onHide = () => (visibleRef.value = false);

const deleteHandler = (cakeId) => {
    isLoading.value = true;
    const form = useForm({});

    setTimeout(() => {
        isLoading.value = false;

        form.delete(route("cake.destroy", cakeId));
    }, 3000);
};

/**
 * Truncates a given description to a maximum length of 30 characters.
 *
 * @param {string} description - The input description to be truncated.
 * @return {string} The truncated description.
 */
const descriptionLength = (description) => {
    if (!description) return "";
    if (description.length > 30) return description.slice(0, 30) + "...";

    return description;
};
</script>
