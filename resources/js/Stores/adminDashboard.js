import { defineStore } from "pinia";

export const useAdminDashboardStore = defineStore("adminDashboard", () => {
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

    const formatDiscount = (discount = 0) => {
        return new Intl.NumberFormat("id-ID", {
            style: "percent",
        }).format(Math.round(discount) / 100);
    };

    return {
        formatPrice,
        formatDiscount,
    };
});
