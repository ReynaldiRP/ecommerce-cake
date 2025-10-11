import { defineConfig } from "vite";
import { resolve } from "path";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
    plugins: [
        laravel("resources/js/app.js"),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            "@": resolve("./resources/js/"),
            "ziggy-js": path.resolve("vendor/tightenco/ziggy/dist/vue.es.js"),
        },
    },
    build: {
        outDir: "public/build",
        manifest: true,
        emptyOutDir: true,
        rollupOptions: {
            input: "resources/js/app.js",
        },
        assetsDir: "assets",
    },
});
