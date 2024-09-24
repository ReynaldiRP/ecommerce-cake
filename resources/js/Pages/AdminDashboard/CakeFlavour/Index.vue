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
                    <h1 class="font-bold text-2xl">Flavour Table</h1>
                    <BaseButton
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
                            <tr>
                                <th></th>
                                <th>Flavour Name</th>
                                <th>Flavour Price</th>
                                <th>Flavour Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(flavour, index) in props.flavour.data"
                                :key="flavour.id"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ flavour.name }}</td>
                                <td>Rp{{ flavour.price }}</td>
                                <td>
                                    <button
                                        @click="
                                            () => showImage(flavour.image_url)
                                        "
                                        class="my-image-links btn btn-info"
                                    >
                                        <i
                                            class="fa-solid fa-image text-lg text-neutral"
                                        ></i>
                                    </button>
                                </td>
                                <td
                                    class="flex lg:justify-start justify-end gap-2"
                                >
                                    <inertia-link
                                        :href="
                                            route('flavour.edit', flavour.id)
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
                                        title="Flavour Data"
                                        button="info"
                                        button-label="Confirm"
                                        :click-handler="
                                            () => deleteHandler(flavour.id)
                                        "
                                        has-cancel
                                    >
                                        <p>
                                            Are you sure want to delete Flavour
                                            ?
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

import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

import { mdiPlus, mdiCheckCircle } from "@mdi/js";

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
</script>
