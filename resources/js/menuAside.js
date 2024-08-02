import { mdiMonitor, mdiCakeLayered, mdiViewList } from "@mdi/js";

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
                href: "dashboard-cake",
                label: "Cake",
            },
            {
                href: "dashboard-size",
                label: "Cake Size",
            },
            {
                href: "dashboard-flavour",
                label: "Cake Flavour",
            },
            {
                href: "dashboard-topping",
                label: "Cake Topping",
            },
        ],
    },
];
