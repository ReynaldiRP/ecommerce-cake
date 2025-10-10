<template>
    <App>
        <section class="min-h-screen bg-gradient-soft">
            <!-- Breadcrumb -->
            <div class="container mx-auto px-6 lg:px-12 pt-28 pb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 md:space-x-3">
                        <li class="inline-flex items-center">
                            <inertia-link
                                :href="route('home')"
                                class="inline-flex items-center text-gray-700 hover:text-primary transition-colors font-medium"
                            >
                                <svg
                                    class="w-4 h-4 mr-2"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                                    ></path>
                                </svg>
                                Beranda
                            </inertia-link>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg
                                    class="w-6 h-6 text-gray-400"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <span
                                    class="ml-2 text-gray-600 font-medium md:ml-2"
                                    >Katalog</span
                                >
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="container mx-auto px-6 lg:px-12 pb-12">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
                    <!-- Filters Sidebar -->
                    <div class="lg:col-span-1">
                        <!-- Mobile Filter Toggle -->
                        <div class="lg:hidden mb-6">
                            <button
                                class="w-full flex items-center justify-between p-4 bg-white rounded-xl shadow-soft border"
                                @click="mobileFiltersOpen = !mobileFiltersOpen"
                            >
                                <span class="font-medium text-gray-900"
                                    >Filter & Sortir</span
                                >
                                <svg
                                    class="w-5 h-5 text-gray-400"
                                    :class="{ 'rotate-180': mobileFiltersOpen }"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>
                        </div>

                        <!-- Filter Panel -->
                        <div
                            class="bg-white rounded-2xl shadow-card p-6 sticky top-28"
                            :class="{ 'hidden lg:block': !mobileFiltersOpen }"
                        >
                            <h3
                                class="text-lg font-heading font-semibold text-gray-900 mb-8"
                            >
                                Filter Produk
                            </h3>

                            <!-- Promo Filter -->
                            <FilterItem
                                filtering-name="Penawaran"
                                class="mb-8"
                                custom-class="text-gray-900"
                            >
                                <BaseRadio
                                    v-for="(promo, index) in cakePromoType"
                                    v-model="filteredData.selectedPromoId"
                                    :key="index"
                                    :label="promo.name"
                                    :id="promo.id"
                                    :total-data="
                                        geTotalCakeWithDiscount[promo.name]
                                    "
                                    text-color="black"
                                />
                            </FilterItem>

                            <!-- Cake Type Filter -->
                            <FilterItem
                                filtering-name="Tipe Kue"
                                class="mb-8"
                                custom-class="text-gray-900"
                            >
                                <BaseRadio
                                    v-for="(
                                        cakePersonalizationType, index
                                    ) in cakePersonalizationType"
                                    v-model="
                                        filteredData.selectedPersonalizationId
                                    "
                                    :key="index"
                                    :label="cakePersonalizationType.name"
                                    :id="cakePersonalizationType.id"
                                    :total-data="
                                        getTotalDataCakeType(
                                            cakePersonalizationType.name,
                                        )
                                    "
                                    text-color="black"
                                />
                            </FilterItem>

                            <!-- Category Filter -->
                            <FilterItem
                                filtering-name="Kategori Kue"
                                custom-class="text-gray-900"
                                class="mb-8"
                            >
                                <BaseCheckbox
                                    v-for="cakeCategory in props.cakeCategories"
                                    v-model="
                                        filteredData.selectedCakeCategoryId
                                    "
                                    :key="cakeCategory.id"
                                    :label="cakeCategory?.name"
                                    :id="cakeCategory.id"
                                    :total-data="
                                        totalCakeCategory[cakeCategory.name]
                                    "
                                    text-color="black"
                                />
                            </FilterItem>

                            <!-- Filter Actions -->
                            <div
                                class="flex gap-3 pt-6 border-t border-gray-200"
                            >
                                <button
                                    class="flex-1 px-4 py-3 text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors font-medium"
                                    @click="clearFilters"
                                >
                                    Clear
                                </button>
                                <button
                                    class="flex-1 px-4 py-3 bg-gradient-to-r from-primary to-accent text-white rounded-xl hover:shadow-lg transition-all transform hover:scale-105 font-medium"
                                    @click="applyFilters"
                                >
                                    Terapkan
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="lg:col-span-3">
                        <!-- Products Header -->
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10"
                        >
                            <div>
                                <h1
                                    class="text-3xl font-heading font-bold text-gray-900 mb-3"
                                >
                                    Katalog Kue
                                </h1>
                                <p class="text-gray-600 text-lg">
                                    Menampilkan
                                    <span class="font-semibold text-gray-900">{{
                                        props.cakes.data.length
                                    }}</span>
                                    dari
                                    <span class="font-semibold text-gray-900">{{
                                        props.cakes.total ||
                                        props.cakes.data.length
                                    }}</span>
                                    produk
                                </p>
                            </div>

                            <!-- Sort Options -->
                            <div class="mt-6 sm:mt-0">
                                <select
                                    v-model="filteredData.sortBy"
                                    @change="applyFilters"
                                    class="w-full sm:w-auto px-4 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                                >
                                    <option value="latest">Terbaru</option>
                                    <option value="price_asc">
                                        Harga: Rendah ke Tinggi
                                    </option>
                                    <option value="price_desc">
                                        Harga: Tinggi ke Rendah
                                    </option>
                                    <option value="name_asc">Nama A-Z</option>
                                </select>
                            </div>
                        </div>

                        <!-- Products Grid or Empty State -->
                        <div v-if="props.cakes.data.length > 0">
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-16"
                            >
                                <div
                                    v-for="cake in props.cakes.data"
                                    :key="cake.id"
                                    class="fade-in-up"
                                >
                                    <CardLayout>
                                        <CardItem
                                            :cakes="cake"
                                            :format-price="formatPrice"
                                        />
                                    </CardLayout>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <Pagination
                                :links="props.cakes.links"
                                :next-page-url="props.cakes.next_page_url"
                                :previous-page-url="props.cakes.prev_page_url"
                            />
                        </div>

                        <!-- Empty State -->
                        <div v-else class="text-center py-16">
                            <div class="max-w-md mx-auto">
                                <img
                                    src="/assets/image/cake-not-found.gif"
                                    class="w-64 h-64 mx-auto mb-8 rounded-2xl"
                                    alt="Kue tidak ditemukan"
                                />
                                <h3
                                    class="text-2xl font-heading font-bold text-gray-900 mb-4"
                                >
                                    Ops! Kue Tidak Ditemukan
                                </h3>
                                <p class="text-gray-600 mb-8">
                                    Maaf, tidak ada kue yang sesuai dengan
                                    filter yang Anda pilih. Coba ubah filter
                                    atau jelajahi semua produk kami.
                                </p>
                                <button
                                    @click="clearFilters"
                                    class="btn-primary-modern"
                                >
                                    Lihat Semua Produk
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import CardLayout from "@/Components/BaseCard/Layout.vue";
import CardItem from "@/Components/BaseCard/Item.vue";
import FilterItem from "@/Components/FilterProduct/Item.vue";
import BaseCheckbox from "@/Components/BaseCheckbox.vue";
import BaseRadio from "@/Components/BaseRadio.vue";
import Pagination from "@/Components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import { ref, computed, reactive } from "vue";

const props = defineProps({
    cakes: {
        type: Object,
    },
    cakeCategories: {
        type: Object,
    },
});

/**
 * Computed property that counts the number of cakes by personalization type.
 *
 * @returns {Object} An object with personalization types as keys and their respective counts as values.
 */
const totalCakePersonalizationType = computed(() => {
    const counts = {
        customized: 0,
        "non-customized": 0,
    };

    props.cakes.data.filter((cake) => {
        const cakePersonalizationType = cake.personalization_type;

        if (
            cakePersonalizationType &&
            counts.hasOwnProperty(cakePersonalizationType)
        ) {
            counts[cakePersonalizationType]++;
        }

        return cakePersonalizationType;
    });

    return counts;
});

/**
 * Computes the total number of cakes for each category.
 *
 * @returns {Object} An object with cake categories as keys and their respective counts as values.
 */
const totalCakeCategory = computed(() => {
    const counts = {
        Cupcake: 0,
        Tart: 0,
        Brownies: 0,
        Pie: 0,
        Pudding: 0,
        Wedding: 0,
    };

    props.cakes.data.filter((cake) => {
        const cakeCategory = cake.category.name;

        if (cakeCategory && !counts.hasOwnProperty(cakeCategory)) {
            counts[cakeCategory] = 1;
        } else {
            counts[cakeCategory]++;
        }

        return cakeCategory;
    });

    return counts;
});

const geTotalCakeWithDiscount = computed(() => {
    const counts = {
        discount: 0,
        "non-discount": 0,
    };

    props.cakes.data.filter((cake) => {
        const cakePromoType = cake.discount ? "discount" : "non-discount";

        if (cakePromoType && counts.hasOwnProperty(cakePromoType)) {
            counts[cakePromoType]++;
        }

        return cakePromoType;
    });

    return counts;
});

/**
 * Formats a given price into a currency string using the Indonesian Rupiah currency format.
 *
 * @param {number} price - The price to be formatted.
 * @return {string} The formatted currency string.
 */
const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(price);
};

const cakePersonalizationType = reactive([
    {
        id: 1,
        name: "customized",
    },
    {
        id: 2,
        name: "non-customized",
    },
]);

const cakePromoType = reactive([
    {
        id: 1,
        name: "discount",
    },
    {
        id: 2,
        name: "non-discount",
    },
]);

/**
 * Retrieves the total data for a specific cake type.
 *
 * @param {string} name - The name of the cake type.
 * @return {object} The total data for the specified cake type.
 */
const getTotalDataCakeType = (name) => {
    return totalCakePersonalizationType.value[
        name.toLowerCase().replace(" ", "")
    ];
};

let filteredData = reactive({
    selectedPersonalizationId: null,
    selectedPromoId: null,
    selectedCakeCategoryId: [],
    sortBy: "latest",
});

const mobileFiltersOpen = ref(false);

/**
 * Applies filters to the products based on the selected personalization and cake category.
 *
 * @return {void}
 */
const applyFilters = () => {
    const selectedPersonalization = cakePersonalizationType.find(
        (item) => item.id === filteredData.selectedPersonalizationId,
    );

    const selectedPromo = cakePromoType.find(
        (item) => item.id === filteredData.selectedPromoId,
    );

    const params = {};

    if (selectedPersonalization) {
        params.personalization_type = selectedPersonalization.name;
    }

    if (selectedPromo) {
        params.discount = selectedPromo.name;
    }

    if (filteredData.selectedCakeCategoryId.length > 0) {
        params.cake_category_id = filteredData.selectedCakeCategoryId.join(",");
    }

    if (filteredData.sortBy) {
        params.sort_by = filteredData.sortBy;
    }

    Inertia.get("products", params, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            const currentUrl = window.location.href;
            const updateUrl = currentUrl.replace(/%2C/g, ",");
            window.history.replaceState(null, "", updateUrl);
        },
    });
};

/**
 * Clears the selected personalization and cake size filters and refreshes the products list.
 *
 * @return {void}
 */
const clearFilters = () => {
    filteredData.selectedPersonalizationId = null;
    filteredData.selectedPromoId = null;
    filteredData.selectedCakeCategoryId = [];

    Inertia.get(
        "products",
        {},
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};
</script>
