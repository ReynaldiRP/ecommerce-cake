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
                    Sign In
                </h1>
            </div>
            <form
                @submit.prevent="submit"
                class="flex flex-col mt-[2.5%] gap-6"
            >
                <div role="alert" class="alert alert-error hidden">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="stroke-current shrink-0 h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    <span>{{
                        error.email
                            ? errorMessage.email
                            : error.password
                            ? errorMessage.password
                            : ""
                    }}</span>
                </div>
                <BaseInput
                    v-model="form.email"
                    style="width: 450px"
                    placeholder="Email or Phone Number"
                    inputType="email"
                    :error="error.email"
                    :error-message="errorMessage.email"
                    @change="onChangeEmail"
                />
                <BaseInput
                    v-model="form.password"
                    style="width: 450px"
                    placeholder="Password"
                    inputType="password"
                    :error="error.password"
                    :error-message="errorMessage.password"
                    @change="onChangePassword"
                />
                <!-- <div class="flex flex-col gap-0">
                    <label
                        class="input input-bordered w-[450px] input-lg lg:input-md xl:input-md flex items-center gap-2"
                        :class="{
                            'border border-error mb-3': errorChange.email,
                        }"
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
                            autocomplete="username"
                            @change="onChangeEmail"
                            v-model="form.email"
                        />
                    </label>
                    <span
                        class="text-error label-text-alt"
                        v-show="errorChange.email"
                        >{{ errorMessage.email }}</span
                    >
                </div>
                <div class="flex flex-col gap-0">
                    <label
                        class="input input-bordered w-full input-lg lg:input-md xl:input-md lg:w-[450px] flex items-center gap-2"
                        :class="{
                            'border border-error mb-3': errorChange.password,
                        }"
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
                            @change="onChangePassword"
                            autocomplete="current-password"
                            v-model="form.password"
                        />
                    </label>
                    <span
                        class="text-error label-text-alt"
                        v-show="errorChange.password"
                        >{{ errorMessage.password }}</span
                    >
                </div> -->
                <div class="flex items-center justify-between">
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
                    <inertia-link class="text-sm underline"
                        >Forgot password?</inertia-link
                    >
                </div>
                <button class="btn w-full bg-base-300 font-bold text-lg">
                    Log In
                </button>

                <p class="text-sm mx-auto">
                    Doesn't have an accont?
                    <inertia-link
                        :href="route('register.index')"
                        class="text-sm underline"
                    >
                        Register Now</inertia-link
                    >
                </p>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import BaseInput from "@/Components/BaseInput.vue";

const error = reactive({
    email: false,
    password: false,
});
const errorMessage = reactive({
    email: "",
    password: "",
});
const form = useForm({
    email: "",
    password: "",
});


const validate = (value, type) => {
    if (type === "email") {
        return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value);
    } else if (type === "password") {
        return value.length > 1;
    }
    return false;
};

const onChangeEmail = () => {
    if (!validate(form.email, "email")) {
        error.email = true;
        if (form.email.length >= 1) {
            errorMessage.email = "Please enter a valid email";
        } else {
            errorMessage.email = "Email must be at least 1 character";
        }
    } else {
        error.email = false;
    }
};

const onChangePassword = () => {
    console.log(form.password.length);
    if (!validate(form.password, "password")) {
        error.password = true;
        errorMessage.password = "Passwords must be at least 1 character";
    } else {
        error.password = false;
    }
};

const onSubmit = () => {
    if (!validate(form.email, "email")) {
        error.email = true;
        errorMessage.email = "Please enter a valid email";
    } else {
        error.email = false;
    }

    if (!validate(form.password, "password")) {
        error.password = true;
        errorMessage.password = "Passwords must be at least 1 character";
    } else {
        error.password = false;
    }
};
</script>

<style scoped>
.first-section {
    background-image: url(/public/assets/image/login-background.webp);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
