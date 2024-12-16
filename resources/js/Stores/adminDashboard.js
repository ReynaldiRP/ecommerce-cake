import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

export const useAdminDashboardStore = defineStore("adminDashboard", () => {
    // TODO: add user role permission
    const page = usePage();
    const userRole = page.props.value.user.role;
    const userRolePermission = ref("");

    const checkRolePermission = computed(() => {
        return userRole === userRolePermission.value;
    });

    /**
     * format price to indonesia currency
     *
     * @param {number} price
     * @returns {string}
     */
    const formatPrice = (price = 0) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
        }).format(price);
    };

    /**
     * format discount to percentage
     *
     * @param discount
     * @returns {string}
     */
    const formatDiscount = (discount = 0) => {
        return new Intl.NumberFormat("id-ID", {
            style: "percent",
        }).format(Math.round(discount) / 100);
    };

    /**
     * format date to indonesia locale
     *
     * @param date
     * @returns {string}
     */
    const formattedDate = (date) => {
        return new Date(date).toLocaleDateString("id-ID", {
            year: "numeric",
            month: "long",
            day: "numeric",
        });
    };

    return {
        formatPrice,
        formatDiscount,
        formattedDate,
        userRolePermission,
        checkRolePermission,
        userRole,
    };
});
