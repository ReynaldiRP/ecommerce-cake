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
                // Modern color palette for bakery/dessert theme
                primary: "#D946EF", // Modern purple
                "primary-light": "#F3E8FF", // Very light purple
                secondary: "#F59E0B", // Warm amber
                accent: "#EC4899", // Pink accent
                "neutral-warm": "#78716C", // Warm gray
                success: "#10B981", // Emerald green
                warning: "#F59E0B", // Amber
                error: "#EF4444", // Red
                surface: "#FAFAFA", // Very light gray
                "surface-dark": "#1F2937", // Dark gray

                // Legacy colors for backward compatibility
                "primary-color": "#D946EF",
                "primary-color-light": "#F3E8FF",
                "color-dashboard-light": "#4F4A4A",
                "color-dashboard-dark": "#F9F9F9",
            },
            boxShadow: {
                custom: "rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;",
                card: "0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)",
                "card-hover":
                    "0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)",
                "card-lg":
                    "0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)",
                soft: "0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)",
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
                "slide-up": {
                    from: {
                        opacity: 0,
                        transform: "translateY(20px)",
                    },
                    to: {
                        opacity: 1,
                        transform: "translateY(0)",
                    },
                },
                "scale-in": {
                    from: {
                        opacity: 0,
                        transform: "scale(0.95)",
                    },
                    to: {
                        opacity: 1,
                        transform: "scale(1)",
                    },
                },
                "bounce-gentle": {
                    "0%, 20%, 50%, 80%, 100%": {
                        transform: "translateY(0)",
                    },
                    "40%": {
                        transform: "translateY(-5px)",
                    },
                    "60%": {
                        transform: "translateY(-3px)",
                    },
                },
            },
            animation: {
                "fade-out": "fade-out 250ms ease-in-out",
                "fade-in": "fade-in 250ms ease-in-out",
                "slide-up": "slide-up 0.3s ease-out",
                "scale-in": "scale-in 0.2s ease-out",
                "bounce-gentle": "bounce-gentle 2s infinite",
            },
            fontFamily: {
                sans: ["Inter", "ui-sans-serif", "system-ui"],
                heading: ["Poppins", "ui-sans-serif", "system-ui"],
            },
            spacing: {
                18: "4.5rem",
                88: "22rem",
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
