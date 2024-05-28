<template>
    <div class="h-screen max-w-screen-2xl flex justify-center items-center">
        <div
            class="h-full hidden lg:w-[60%] lg:block first-section rounded-e-2xl"
        ></div>
        <div
            class="h-full w-full lg:w-[40%] flex flex-col items-center justify-center bg-base-100"
        >
            <div class="flex flex-col items-center justify-center gap-12">
                <div class="avatar block lg:hidden">
                    <div class="w-24 lg:w-16 rounded-full">
                        <img
                            src="/assets/image/logo-dreamdessert.webp"
                            alt="ini gambar"
                        />
                    </div>
                </div>
                <h1
                    class="relative bottom-10 text-primary-color font-bold text-4xl"
                >
                    Sign In
                </h1>
            </div>
            <div class="flex flex-col mt-[2.5%] gap-6">
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
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z"
                        />
                    </svg>
                    <input type="text" placeholder="Email or Phone Number" />
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
                    <input type="password" placeholder="Password" />
                </label>
                <div class="flex items-center">
                    <div class="form-control">
                        <label class="flex gap-3 label cursor-pointer">
                            <span class="label-text">Remember me</span>
                            <input
                                type="checkbox"
                                checked="checked"
                                class="checkbox checkbox-md"
                            />
                        </label>
                    </div>
                </div>
                <button class="btn w-full bg-base-300 font-bold text-lg">
                    Log In
                </button>
                <p class="text-sm mx-auto">
                    Already have an accont?
                    <inertia-link href="/Login" class="text-sm underline">
                        Login Now</inertia-link
                    >
                </p>
            </div>
        </div>
    </div>
</template>

<script setup></script>

<style scoped>
.first-section {
    background-image: url(/public/assets/image/register-background.webp);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
