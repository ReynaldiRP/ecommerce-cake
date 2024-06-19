<template>
    <App>
        <div class="h-full flex justify-center items-center">
            <h1 v-if="user">Loggin as {{ user.username }}</h1>
            <h1 v-else>Home page</h1>
        </div>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import { computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

const page = usePage();
const user = computed(() => page.props.value.auth.user);
</script>
