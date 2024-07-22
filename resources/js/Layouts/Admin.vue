<script setup>
import { mdiForwardburger, mdiBackburger, mdiMenu } from "@mdi/js";
import { ref } from "vue";
import menuAside from "@/menuAside.js";
import menuNavBar from "@/menuNavBar.js";
import { Inertia } from "@inertiajs/inertia";
import { useDarkModeStore } from "@/Stores/darkMode.js";
import BaseIcon from "@/Components/DashboardAdmin/BaseIcon.vue";
import FormControl from "@/Components/DashboardAdmin/FormControl.vue";
import NavBar from "@/Components/DashboardAdmin/NavBar.vue";
import NavBarItemPlain from "@/Components/DashboardAdmin/NavBarItemPlain.vue";
import AsideMenu from "@/Components/DashboardAdmin/AsideMenu.vue";
import FooterBar from "@/Components/DashboardAdmin/FooterBar.vue";

const layoutAsidePadding = "xl:pl-60";

const darkModeStore = useDarkModeStore();

const isAsideMobileExpanded = ref(false);
const isAsideLgActive = ref(false);

Inertia.on("navigate", () => {
    isAsideMobileExpanded.value = false;
    isAsideLgActive.value = false;
});

const menuClick = (event, item) => {
    if (item.isToggleLightDark) {
        darkModeStore.set();
    }

    if (item.isLogout) {
        Inertia.post(route("logout"));
    }
};
</script>

<template>
    <div
        :class="{
            'overflow-hidden lg:overflow-visible': isAsideMobileExpanded,
        }"
    >
        <div
            :class="[
                layoutAsidePadding,
                { 'ml-60 lg:ml-0': isAsideMobileExpanded },
            ]"
            class="pt-14 min-h-screen w-screen transition-position lg:w-auto bg-gray-50 dark:bg-slate-800 dark:text-slate-100"
        >
            <NavBar
                :menu="menuNavBar"
                :class="[
                    layoutAsidePadding,
                    { 'ml-60 lg:ml-0': isAsideMobileExpanded },
                ]"
                @menu-click="menuClick"
            >
                <NavBarItemPlain
                    display="flex lg:hidden"
                    @click.prevent="
                        isAsideMobileExpanded = !isAsideMobileExpanded
                    "
                >
                    <BaseIcon
                        :path="
                            isAsideMobileExpanded
                                ? mdiBackburger
                                : mdiForwardburger
                        "
                        size="24"
                    />
                </NavBarItemPlain>
                <NavBarItemPlain
                    display="hidden lg:flex xl:hidden"
                    @click.prevent="isAsideLgActive = true"
                >
                    <BaseIcon :path="mdiMenu" size="24" />
                </NavBarItemPlain>
                <NavBarItemPlain use-margin>
                    <FormControl
                        placeholder="Search (ctrl+k)"
                        ctrl-k-focus
                        transparent
                        borderless
                    />
                </NavBarItemPlain>
            </NavBar>
            <AsideMenu
                :is-aside-mobile-expanded="isAsideMobileExpanded"
                :is-aside-lg-active="isAsideLgActive"
                :menu="menuAside"
                @menu-click="menuClick"
                @aside-lg-close-click="isAsideLgActive = false"
            />
            <slot />
            <FooterBar>
                Get more with
                <a
                    href="https://tailwind-vue.justboil.me/"
                    target="_blank"
                    class="text-blue-600"
                    >Premium version</a
                >
            </FooterBar>
        </div>
    </div>
</template>
