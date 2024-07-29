import { mdiMonitor, mdiCakeLayered, mdiViewList } from "@mdi/js";

export default [
    {
        route: "dashboard-home",
        icon: mdiMonitor,
        label: "Dashboard",
    },
    {
        href: "dashboard-cake",
        icon: mdiCakeLayered,
        label: "Cake",
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
                label: "Cake Category",
            },
            {
                href: "dashboard-flavour",
                label: "Cake Flavour",
            },
            {
                label: "Cake Topping",
            },
        ],
    },
];
