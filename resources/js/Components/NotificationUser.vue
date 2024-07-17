<template>
    <div class="dropdown dropdown-hover dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
            <div class="indicator">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                    fill="currentColor"
                    class="h-5 w-5"
                    stroke="currentColor"
                >
                    <path
                        d="M64 0C28.7 0 0 28.7 0 64V352c0 35.3 28.7 64 64 64h96v80c0 6.1 3.4 11.6 8.8 14.3s11.9 2.1 16.8-1.5L309.3 416H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H64z"
                    />
                </svg>
                <span class="badge badge-sm indicator-item">8</span>
            </div>
        </div>
        <div
            tabindex="0"
            class="z-[1] card card-compact dropdown-content w-96 bg-base-100 shadow-xl"
        >
            <div
                class="card-body m-0 p-0"
                v-for="(notif, index) in notification"
                :key="index"
            >
                <p class="font-bold text-lg">
                    {{ notif.name }}
                </p>
                <p class="text-info text-justify">
                    {{ notif.message }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    notification: {
        type: Array,
    },
});
</script>
