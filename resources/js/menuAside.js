import { mdiAccountCash, mdiMonitor, mdiShopping, mdiViewList } from "@mdi/js";

export default [
    {
        route: "dashboard-home",
        icon: mdiMonitor,
        label: "Dashboard",
    },
    {
        label: "Products",
        icon: mdiViewList,
        menu: [
            {
                route: "cake.index",
                label: "Cake",
            },
            {
                route: "size.index",
                label: "Cake Size",
            },
            {
                route: "flavour.index",
                label: "Cake Flavour",
            },
            {
                route: "topping.index",
                label: "Cake Topping",
            },
        ],
    },
    {
        label: "Orders",
        icon: mdiShopping,
        route: "orders.index",
    },
    {
        label: "Payments",
        icon: mdiAccountCash,
        route: "payments.index",
    },
];
