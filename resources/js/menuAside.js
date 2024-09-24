import { mdiMonitor, mdiViewList } from "@mdi/js";

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
];
