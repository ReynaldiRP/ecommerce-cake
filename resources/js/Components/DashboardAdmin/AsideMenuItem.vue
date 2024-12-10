<script setup>
import { computed, ref } from "vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { mdiMinus, mdiPlus } from "@mdi/js";
import { getButtonColor } from "@/colors.js";
import BaseIcon from "@/Components/DashboardAdmin/BaseIcon.vue";
import AsideMenuList from "@/Components/DashboardAdmin/AsideMenuList.vue";

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
    isDropdownList: Boolean,
});

const page = usePage();
const currentUserRole = page.props.value.user.role;

const itemHref = computed(() =>
    props.item.route ? route(props.item.route) : props.item.href,
);

const activeInactiveStyle = computed(() =>
    props.item.route && route().current(props.item.route)
        ? "font-bold text-white"
        : "false",
);

const emit = defineEmits(["menu-click"]);

const hasColor = computed(() => props.item && props.item.color);

const asideMenuItemActiveStyle = computed(() =>
    hasColor.value ? "" : "aside-menu-item-active font-bold",
);

const isDropdownActive = ref(false);

/**
 * Check if the user has permission to access the menu item
 *
 * @type {ComputedRef<*|boolean>}
 */
const checkRolePermission = computed(() => {
    if (props.item.role) {
        return props.item.role.includes(currentUserRole);
    }

    return true;
});

console.log(
    `User with role ${currentUserRole} has permission to access the menu item ${props.item.label}: ${checkRolePermission.value}`,
);

const componentClass = computed(() => [
    props.isDropdownList ? "py-3 px-6 text-sm" : "py-3",
    hasColor.value
        ? getButtonColor(props.item.color, false, true)
        : `aside-menu-item text-slate-300 hover:text-white`,
]);

const hasDropdown = computed(() => !!props.item.menu);

const menuClick = (event) => {
    emit("menu-click", event, props.item);

    if (hasDropdown.value) {
        isDropdownActive.value = !isDropdownActive.value;
    }
};
</script>

<template>
    <li>
        <component
            :is="item.route ? Link : 'a'"
            v-if="checkRolePermission"
            :href="itemHref"
            :target="item.target ?? null"
            class="flex cursor-pointer"
            :class="componentClass"
            @click="menuClick"
        >
            <BaseIcon
                v-if="item.icon"
                :path="item.icon"
                class="flex-none"
                :class="activeInactiveStyle"
                w="w-16"
                :size="18"
            />
            <span
                class="grow text-ellipsis line-clamp-1"
                :class="[{ 'pr-12': !hasDropdown }, activeInactiveStyle]"
                >{{ item.label }}</span
            >
            <BaseIcon
                v-if="hasDropdown"
                :path="isDropdownActive ? mdiMinus : mdiPlus"
                class="flex-none"
                :class="activeInactiveStyle"
                w="w-12"
            />
        </component>
        <AsideMenuList
            v-if="hasDropdown"
            :menu="item.menu"
            :class="[
                'aside-menu-dropdown',
                isDropdownActive ? 'block bg-slate-800/50' : 'hidden',
            ]"
            is-dropdown-list
        />
    </li>
</template>
