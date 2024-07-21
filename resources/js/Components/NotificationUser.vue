<template>
    <div class="dropdown dropdown-hover dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
            <div class="indicator">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"
                    fill="currentColor"
                    class="h-5 w-5"
                    stroke="currentColor"
                >
                    <path
                        d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416l384 0c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8l0-18.8c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"
                    />
                </svg>
                <span class="badge badge-sm indicator-item">8</span>
            </div>
        </div>
        <div
            tabindex="0"
            class="z-[1] card card-compact dropdown-content w-96 bg-base-100 shadow-xl p-3"
        >
            <div
                class="flex justify-between items-center text-base font-medium border-b-2 pb-1"
            >
                <p class="text-lg">Notification</p>
                <inertia-link href="#" class="text-neutral-content/75 hover:text-neutral-content">Mark All Notification</inertia-link>
            </div>
            <div
                class="card-body flex-row gap-4 my-2 rounded-lg bg-neutral"
                v-for="(notif, index) in notification"
                :key="index"
            >
                <div class="avatar">
                    <div class="w-16 rounded-lg bg-primary-color">
                        <img :src="notif.cakeImageUrl" alt="" />
                    </div>
                </div>
                <div class="flex flex-col justify-center gap-1 m-0 p-0">
                    <span class="text-base text-justify">
                        {{ notif.message }}
                    </span>
                    <span class="text-sm font-light">
                        {{ notif.timestamp }}
                    </span>
                </div>
            </div>
            <div class="card-actions my-2">
                <inertia-link
                    class="btn btn-sm bg-primary-color text-slate-700 hover:text-white btn-block"
                >
                    View Notification
                </inertia-link>
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
