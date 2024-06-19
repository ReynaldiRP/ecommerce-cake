import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Link } from "@inertiajs/inertia-vue3";
import { ZiggyVue } from "ziggy-js";
import { LoadingPlugin } from "vue-loading-overlay";

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .component("inertia-link", Link)
            .use(ZiggyVue)
            .mount(el);
    },
});
