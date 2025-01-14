import { defineStore } from "pinia";
import { ref } from "vue";

export const useOrderStatusStore = defineStore("orderStatus", () => {
    const orderInformationStatus = ref([]);

    return {
        orderInformationStatus,
    };
});
