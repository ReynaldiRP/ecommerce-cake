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
                route: "dashboard-cake",
                label: "Cake",
            },
            {
                route: "dashboard-size",
                label: "Cake Size",
            },
            {
                route: "dashboard-flavour",
                label: "Cake Flavour",
            },
            {
                route: "dashboard-topping",
                label: "Cake Topping",
            },
        ],
    },
];
