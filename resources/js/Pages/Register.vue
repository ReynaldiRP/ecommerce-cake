<template>
    <div class="h-screen max-w-screen-2xl flex justify-center items-center">
        <div
            class="h-full hidden lg:w-[60%] lg:block first-section rounded-e-2xl"
        ></div>
        <div
            class="h-full w-full lg:w-[40%] flex flex-col items-center justify-center bg-base-100"
        >
            <div class="flex flex-col items-center justify-center gap-12">
                <div class="avatar">
                    <div class="w-32 lg:w-24 rounded-full">
                        <img
                            src="/assets/image/logo-dreamdessert.webp"
                            alt="ini gambar"
                        />
                    </div>
                </div>
                <h1
                    class="relative bottom-10 text-primary-color font-bold text-3xl"
                >
                    Register
                </h1>
            </div>
            <form action="" method="post" class="flex flex-col mt-[2.5%] gap-6">
                <label
                    class="input input-bordered w-[450px] input-lg lg:input-md xl:input-md flex items-center gap-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        class="w-4 h-4 opacity-70"
                    >
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z"
                        />
                    </svg>
                    <input type="text" placeholder="Fullname" />
                </label>
                <label
                    class="input input-bordered w-full input-lg lg:input-md xl:input-md lg:w-[450px] flex items-center gap-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        class="w-4 h-4 opacity-70"
                    >
                        <path
                            d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z"
                        />
                        <path
                            d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z"
                        />
                    </svg>
                    <input
                        type="text"
                        placeholder="Email or Phone Number"
                        autocomplete="email"
                    />
                </label>
                <label
                    class="input input-bordered w-full input-lg lg:input-md xl:input-md lg:w-[450px] flex items-center gap-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 384 512"
                        fill="currentColor"
                        class="w-4 h-4 opacity-70"
                    >
                        <path
                            d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"
                        />
                    </svg>
                    <input
                        type="text"
                        placeholder="Address"
                        autocomplete="address-level4"
                    />
                </label>
                <label
                    class="input input-bordered w-full input-lg lg:input-md xl:input-md lg:w-[450px] flex items-center gap-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        class="w-4 h-4 opacity-70"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <input
                        type="password"
                        placeholder="Password"
                        autocomplete="new-password"
                    />
                </label>
                <label
                    class="input input-bordered w-full input-lg lg:input-md xl:input-md lg:w-[450px] flex items-center gap-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        class="w-4 h-4 opacity-70"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                            clip-rule="evenodd"
                        />
                    </svg>
                    <input
                        type="password"
                        placeholder="Confirm Password"
                        autocomplete="new-password"
                    />
                </label>
                <button class="btn w-full bg-base-300 font-bold text-lg">
                    Register
                </button>
                <p class="text-sm mx-auto">
                    Already have an accont?
                    <inertia-link
                        :href="route('login.index')"
                        class="text-sm underline"
                    >
                        Login Now</inertia-link
                    >
                </p>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import BaseInput from "@/Components/BaseInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";


</script>

<style scoped>
.first-section {
    background-image: url(/public/assets/image/register-background.webp);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
