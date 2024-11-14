<template>
    <App>
        <section class="min-h-screen flex flex-col justify-center">
            <aside
                class="breadcrumbs text-sm me-auto relative top-32 lg:top-[88px] left-8"
            >
                <ul>
                    <li>
                        <inertia-link :href="route('home')"
                            >Beranda</inertia-link
                        >
                    </li>
                    <li>
                        <inertia-link :href="route('products')"
                            >Katalog</inertia-link
                        >
                    </li>
                </ul>
            </aside>
            <section
                class="w-full grid grid-cols-12 px-8 sm:px-4 place-items-center lg:place-items-start"
            >
                <section
                    class="h-fit w-full lg:w-fit col-span-full sm:col-span-5 md:col-span-4 lg:col-span-3 flex flex-col justify-start mb-auto gap-2 px-2 pb-10 pt-36 sm:py-36 lg:py-24"
                >
                    <section
                        class="w-full px-4 lg:px-0 flex items-center gap-2 relative sm:right-4 lg:right-0 lg:left-4"
                    >
                        <article
                            class="lg:hidden collapse collapse-arrow bg-base-300"
                        >
                            <input type="checkbox" />
                            <div class="collapse-title text-lg font-medium">
                                Filter
                            </div>
                            <div class="collapse-content">
                                <FilterItem filtering-name="Tipe Kue">
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
                                    />
                                </FilterItem>
                                <FilterItem
                                    class="my-4"
                                    filtering-name="Kategori Kue"
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
                                    />
                                </FilterItem>
                                <div class="flex items-center gap-2 mt-2">
                                    <button
                                        class="btn btn-outline"
                                        @click="clearFilters"
                                    >
                                        Clear
                                    </button>
                                    <button
                                        class="btn bg-primary-color text-base-200 hover:bg-base-content"
                                        @click="applyFilters"
                                    >
                                        Save
                                    </button>
                                </div>
                            </div>
                        </article>
                        <h1 class="hidden lg:block text-lg font-medium me-auto">
                            Filter
                        </h1>
                    </section>

                    <FilterLayout class="hidden lg:flex">
                        <FilterItem filtering-name="Tipe Kue">
                            <BaseRadio
                                v-for="(
                                    cakePersonalizationType, index
                                ) in cakePersonalizationType"
                                v-model="filteredData.selectedPersonalizationId"
                                :key="index"
                                :label="cakePersonalizationType.name"
                                :id="cakePersonalizationType.id"
                                :total-data="
                                    getTotalDataCakeType(
                                        cakePersonalizationType.name,
                                    )
                                "
                            />
                        </FilterItem>
                        <FilterItem filtering-name="Kategori Kue">
                            <BaseCheckbox
                                v-for="cakeCategory in props.cakeCategories"
                                v-model="filteredData.selectedCakeCategoryId"
                                :key="cakeCategory.id"
                                :label="cakeCategory?.name"
                                :id="cakeCategory.id"
                                :total-data="
                                    totalCakeCategory[cakeCategory.name]
                                "
                            />
                        </FilterItem>
                        <div class="hidden lg:flex items-center gap-2 mt-2">
                            <button
                                class="btn btn-outline"
                                @click="clearFilters"
                            >
                                Clear
                            </button>
                            <button
                                class="btn bg-primary-color text-base-200 hover:bg-base-content"
                                @click="applyFilters"
                            >
                                Save
                            </button>
                        </div>
                    </FilterLayout>
                </section>
                <section
                    class="col-span-full sm:col-span-7 md:col-span-8 lg:col-span-9 flex flex-col items-center gap-8 pb-8"
                    :class="{
                        'sm:py-36 lg:py-32': props.cakes.data.length > 0,
                    }"
                >
                    <section
                        class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-11 place-items-center gap-4"
                    >
                        <CardLayout
                            v-for="cakes in props.cakes.data"
                            :key="cakes.id"
                            class="col-span-2"
                        >
                            <CardItem
                                :cake-id="cakes.id"
                                :cake-name="cakes.name"
                                :cake-category="cakes.category.name"
                                :cake-price="formatPrice(cakes.base_price)"
                                :image-url="cakes.image_url"
                                :cake-personalization-type="
                                    cakes.personalization_type
                                "
                            />
                        </CardLayout>
                    </section>
                    <Pagination
                        v-if="props.cakes.data.length > 0"
                        :links="props.cakes.links"
                        :next-page-url="props.cakes.next_page_url"
                        :previous-page-url="props.cakes.prev_page_url"
                    />
                    <section
                        v-else
                        class="relative lg:left-24 lg:bottom-4 flex flex-col items-center justify-center"
                    >
                        <h1 class="relative top-16 font-bold text-xl">
                            Cake Not Founds
                        </h1>
                        <img
                            src="/assets/image/cake-not-found.gif"
                            class="rounded-xl"
                            alt="image not found"
                        />
                    </section>
                </section>
            </section>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import CardLayout from "@/Components/BaseCard/Layout.vue";
import CardItem from "@/Components/BaseCard/Item.vue";
import FilterLayout from "@/Components/FilterProduct/Layout.vue";
import FilterItem from "@/Components/FilterProduct/Item.vue";
import BaseCheckbox from "@/Components/BaseCheckbox.vue";
import BaseRadio from "@/Components/BaseRadio.vue";
import Pagination from "@/Components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import { computed, reactive } from "vue";

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
    selectedCakeCategoryId: [],
});

/**
 * Applies filters to the products based on the selected personalization and cake category.
 *
 * @return {void}
 */
const applyFilters = () => {
    const selectedPersonalization = cakePersonalizationType.find(
        (item) => item.id === filteredData.selectedPersonalizationId,
    );

    const params = {};

    if (selectedPersonalization) {
        params.personalization_type = selectedPersonalization.name;
    }

    if (filteredData.selectedCakeCategoryId.length > 0) {
        params.cake_category_id = filteredData.selectedCakeCategoryId.join(",");
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
