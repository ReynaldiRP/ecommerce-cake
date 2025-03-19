import {
    mdiAccountCash,
    mdiMonitor,
    mdiNoteCheckOutline,
    mdiShopping,
    mdiViewList,
} from "@mdi/js";

export default [
    {
        route: "dashboard-home",
        icon: mdiMonitor,
        role: "owner",
        label: "Dashboard",
    },
    {
        label: "Produk",
        icon: mdiViewList,
        role: "staff administrasi",
        menu: [
            {
                route: "category.index",
                label: "Kategori Kue",
            },
            {
                route: "discount.index",
                label: "Diskon Kue",
            },
            {
                route: "cake.index",
                label: "Kue",
            },
            {
                route: "size.index",
                label: "Ukuran Kue",
            },
            {
                route: "flavour.index",
                label: "Rasa Kue",
            },
            {
                route: "topping.index",
                label: "Topping Kue",
            },
        ],
    },
    {
        label: "Pesanan",
        icon: mdiShopping,
        route: "orders.index",
        role: "staff administrasi",
    },
    {
        label: "Pembayaran",
        icon: mdiAccountCash,
        route: "payments.index",
        role: "staff administrasi",
    },
    // {
    //     label: "Approval",
    //     icon: mdiNoteCheckOutline,
    //     route: "approvals.index",
    //     role: "owner",
    // },
];
