/** @type {import('tailwindcss').Config} */

const plugin = require("tailwindcss/plugin");

export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./resources/js/**/*.js",
    ],
    darkMode: "class", // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                "primary-color": "#EBA9AE",
                "primary-color-light": "#F9E3E4",
                "color-dashboard-light": "#4F4A4A",
                "color-dashboard-dark": "#F9F9F9",
            },
            boxShadow: {
                custom: "rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;",
            },
            zIndex: {
                "-1": "-1",
            },
            flexGrow: {
                5: "5",
            },
            maxHeight: {
                "screen-menu": "calc(100vh - 3.5rem)",
                modal: "calc(100vh - 160px)",
            },
            transitionProperty: {
                position: "right, left, top, bottom, margin, padding",
                textColor: "color",
            },
            keyframes: {
                "fade-out": {
                    from: { opacity: 1 },
                    to: { opacity: 0 },
                },
                "fade-in": {
                    from: { opacity: 0 },
                    to: { opacity: 1 },
                },
            },
            animation: {
                "fade-out": "fade-out 250ms ease-in-out",
                "fade-in": "fade-in 250ms ease-in-out",
            },
        },
    },
    plugins: [
        require("daisyui"),
        plugin(function ({ matchUtilities, theme }) {
            matchUtilities(
                {
                    "aside-scrollbars": (value) => {
                        const track = value === "light" ? "100" : "900";
                        const thumb = value === "light" ? "300" : "600";
                        const color = value === "light" ? "gray" : value;

                        return {
                            scrollbarWidth: "thin",
                            scrollbarColor: `${theme(
                                `colors.${color}.${thumb}`,
                            )} ${theme(`colors.${color}.${track}`)}`,
                            "&::-webkit-scrollbar": {
                                width: "8px",
                                height: "8px",
                            },
                            "&::-webkit-scrollbar-track": {
                                backgroundColor: theme(
                                    `colors.${color}.${track}`,
                                ),
                            },
                            "&::-webkit-scrollbar-thumb": {
                                borderRadius: "0.25rem",
                                backgroundColor: theme(
                                    `colors.${color}.${thumb}`,
                                ),
                            },
                        };
                    },
                },
                { values: theme("asideScrollbars") },
            );
        }),
    ],
};
