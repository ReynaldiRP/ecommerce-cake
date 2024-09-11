import "../css/main.css";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Link } from "@inertiajs/inertia-vue3";
import { ZiggyVue } from "ziggy-js";
import { createPinia } from "pinia";
import VueEasyLightbox from "vue-easy-lightbox";

const pinia = createPinia();

createInertiaApp({
    resolve: async (name) => {
        try {
            return await resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob("./Pages/**/*.vue")
            );
        } catch (e) {
            return resolvePageComponent(
                `./Layouts/${name}.vue`,
                import.meta.glob("./Layouts/**/*.vue")
            );
        }
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .component("inertia-link", Link)
            .use(ZiggyVue)
            .use(pinia)
            .use(VueEasyLightbox)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
