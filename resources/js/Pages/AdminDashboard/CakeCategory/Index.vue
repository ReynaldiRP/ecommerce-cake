<template>
    <loading
        v-model:active="isLoading"
        :can-cancel="true"
        color="#EBA9AE"
        background-color="#B2BEB5"
    />

    <LayoutAuthenticated>
        <SectionMain class="flex flex-col gap-6">
            <div class="grid grid-cols-12">
                <div class="col-span-4 flex items-center gap-2">
                    <h1 class="font-bold text-2xl">Tabel Kategori Kue</h1>
                    <BaseButton
                        v-if="checkRolePermission"
                        color="success"
                        :icon="mdiPlus"
                        :icon-size="16"
                        @click="create"
                    />
                    <CardBoxModal
                        v-model="modalCreateActive"
                        class="backdrop-contrast-50"
                        title="Tambah Kategori Kue"
                        button="success"
                        button-label="Submit"
                        :click-handler="submit"
                        has-cancel
                    >
                        <CardBox>
                            <FormField label="Cake Category">
                                <FormControl
                                    v-model="form.name"
                                    placeholder="Birthday Cake"
                                    :icon="mdiCakeVariant"
                                />
                            </FormField>
                            <NotificationBar
                                v-if="props.error"
                                color="danger"
                                :icon="mdiAlertCircle"
                            >
                                {{ props.error }}
                            </NotificationBar>
                        </CardBox>
                    </CardBoxModal>
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
                                <th>Kategori Kue</th>
                                <th v-if="checkRolePermission">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(category, index) in categoryData"
                                :key="category.id"
                            >
                                <th>{{ index + 1 }}</th>
                                <td>{{ category.name }}</td>
                                <td
                                    v-if="checkRolePermission"
                                    class="flex lg:justify-start justify-end gap-2"
                                >
                                    <button
                                        class="btn btn-info"
                                        @click="() => edit(category)"
                                    >
                                        Edit
                                    </button>
                                    <CardBoxModal
                                        v-model="modalEditActive"
                                        class="backdrop-contrast-50"
                                        title="Edit Kateogri Kue"
                                        button="success"
                                        button-label="Submit"
                                        :click-handler="() => update(category)"
                                        has-cancel
                                    >
                                        <FormField
                                            class="text-start"
                                            label="Cake Category"
                                        >
                                            <FormControl
                                                v-model="form.name"
                                                placeholder="Birthday Cake"
                                                :icon="mdiCakeVariant"
                                            />
                                        </FormField>
                                        <NotificationBar
                                            v-if="props.error"
                                            color="danger"
                                            :icon="mdiAlertCircle"
                                        >
                                            {{ props.error }}
                                        </NotificationBar>
                                    </CardBoxModal>
                                    <button
                                        class="btn btn-error"
                                        @click="modalActive = true"
                                    >
                                        Delete
                                    </button>
                                    <CardBoxModal
                                        v-model="modalActive"
                                        class="backdrop-contrast-50"
                                        title="Kateogri Kue"
                                        button="info"
                                        button-label="Confirm"
                                        :click-handler="() => destroy(category)"
                                        has-cancel
                                    >
                                        <p>
                                            Apakah kamu yakin untuk menghapus
                                            Kategori Kue ?
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
                            :links="props.cakeCategory.links"
                            :next-page-url="props.cakeCategory.next_page_url"
                            :previous-page-url="
                                props.cakeCategory.prev_page_url
                            "
                        />
                        <p>
                            Page
                            <span>{{ props.cakeCategory.current_page }}</span>
                            of
                            <span>{{ props.cakeCategory.last_page }}</span>
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
import {
    mdiAlertCircle,
    mdiCakeVariant,
    mdiCheckCircle,
    mdiPlus,
} from "@mdi/js";
import NotificationBar from "@/Components/DashboardAdmin/NotificationBar.vue";
import BaseButton from "@/Components/DashboardAdmin/BaseButton.vue";
import CardBox from "@/Components/DashboardAdmin/CardBox.vue";
import CardBoxModal from "@/Components/DashboardAdmin/CardBoxModal.vue";
import { computed, onMounted, ref } from "vue";
import FormControl from "@/Components/DashboardAdmin/FormControl.vue";
import FormField from "@/Components/DashboardAdmin/FormField.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import axios from "axios";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
import { useAdminDashboardStore } from "@/Stores/adminDashboard.js";
import { storeToRefs } from "pinia";

const props = defineProps({
    cakeCategory: Object,
    error: String,
});

const store = useAdminDashboardStore();
const { userRolePermission, checkRolePermission } = storeToRefs(store);

onMounted(() => {
    userRolePermission.value = "admin";
});

const form = useForm({
    name: "",
});

const categoryData = ref(props.cakeCategory.data);

const modalActive = ref(false);
const modalCreateActive = ref(false);
const modalEditActive = ref(false);
const isLoading = ref(false);

/**
 * Open modal to create new cake category
 *
 * @return void
 */
const create = () => {
    form.reset("name");
    modalCreateActive.value = true;
};

/**
 * Submit form to store new cake category
 *
 * @return void
 */
const submit = () => {
    try {
        form.post(route("category.store"), {
            data: form.name,
            onSuccess: () => {
                isLoading.value = true;

                setTimeout(() => {
                    isLoading.value = false;
                    modalCreateActive.value = false;
                    form.reset("name");
                }, 2000);
            },
        });
    } catch (error) {
        console.error(error);
    }
};

/**
 * Edit cake category
 *
 * @param {Object} category
 * @return void
 */
const edit = async (category) => {
    try {
        const response = await axios.get(route("category.edit", category.id));
        form.name = response.data.name;
        modalEditActive.value = true;
    } catch (error) {
        console.error(error);
    }
};

/**
 * Update cake category
 *
 * @param {Object} category
 * @return void
 */
const update = async (category) => {
    try {
        const response = await axios.put(
            route("category.update", { dashboard_category: category.id }),
            {
                name: form.name,
            },
            {
                params: {
                    dashboard_category: category.id,
                },
            },
        );

        const itemIndex = categoryData.value.findIndex(
            (item) => item.id === response.data.category.id,
        );
        isLoading.value = true;

        setTimeout(() => {
            isLoading.value = false;
            modalEditActive.value = false;
            categoryData.value[itemIndex].name = response.data.category.name;
            form.reset("name");
        }, 2000);
    } catch (error) {
        console.error(error);
    }
};

/**
 * Delete cake category
 *
 * @param {Object} category
 * @return void
 */
const destroy = (category) => {
    console.log(category.id);
    try {
        form.delete(route("category.destroy", category.id), {
            onSuccess: () => {
                modalActive.value = false;
            },
        });
    } catch (error) {
        console.error(error);
    }
};
</script>
