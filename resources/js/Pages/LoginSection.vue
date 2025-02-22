<template>
    <Auth>
        <loading
            v-model:active="isLoading"
            :can-cancel="true"
            color="#EBA9AE"
            background-color="#B2BEB5"
        />
        <div
            class="min-h-screen hidden lg:w-[60%] lg:block first-section rounded-e-2xl"
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
                    Selamat Datang Kembali
                </h1>
            </div>
            <form
                @submit.prevent="submit"
                class="flex flex-col gap-3"
                autocomplete="on"
            >
                <BaseAlert v-if="errors.email" type="alert-error">{{
                    errors.email
                }}</BaseAlert>
                <BaseAlert v-else-if="errors.password" type="alert-error">{{
                    errors.password
                }}</BaseAlert>
                <div class="flex flex-col gap-2">
                    <BaseLabel label="Email" :required="true" />
                    <BaseInput
                        v-model="form.email"
                        name="email"
                        autocomplete="email"
                        style="width: 450px"
                        placeholder="user@gmail.com"
                        input-type="email"
                        :error="error.email"
                        :error-message="errorMessage.email"
                        @change="onChangeEmail"
                    />
                </div>
                <div class="flex flex-col gap-2">
                    <BaseLabel label="Password" :required="true" />
                    <BaseInput
                        v-model="form.password"
                        name="password"
                        autocomplete="current-password"
                        style="width: 450px"
                        placeholder="Min. 8 Karakter"
                        :input-type="passwordInputType"
                        :error="error.password"
                        :error-message="errorMessage.password"
                        @change="onChangePassword"
                        :is-password-show="isPasswordShow"
                        :show-password-toggle="showPasswordToggle"
                    />
                </div>
                <div class="flex items-center justify-between">
                    <div class="form-control">
                        <label class="flex gap-3 label cursor-pointer">
                            <span class="label-text">Ingat saya</span>
                            <input
                                type="checkbox"
                                checked="checked"
                                class="checkbox checkbox-md"
                            />
                        </label>
                    </div>
                    <inertia-link class="text-sm underline"
                        >Lupa password?</inertia-link
                    >
                </div>
                <button class="btn w-full bg-base-300 font-bold text-lg">
                    Masuk
                </button>
                <p class="text-sm mx-auto">
                    Tidak punya akun ?
                    <inertia-link
                        :href="route('register.index')"
                        class="text-sm underline"
                    >
                        Daftar Sekarang</inertia-link
                    >
                </p>
            </form>
        </div>
    </Auth>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import Auth from "@/Layouts/Auth.vue";
import BaseInput from "@/Components/BaseInput.vue";
import BaseLabel from "@/Components/BaseLabel.vue";
import BaseAlert from "@/Components/BaseAlert.vue";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

const page = usePage();

// Properties for error messages in server-side
defineProps({ errors: Object });

// State for error in client side
const error = reactive({
    email: false,
    password: false,
});

// State for error message in client side
const errorMessage = reactive({
    email: "",
    password: "",
});

// Form helper for input fields
const form = useForm({
    email: "",
    password: "",
});

// Valdation for email and password in client side
const validations = {
    email: {
        regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
        minLength: 1,
    },
    password: {
        minLength: 8,
    },
};

// State for current show password toggle
const isPasswordShow = ref(false);

// State for input type password
const passwordInputType = ref("password");

const isLoading = ref(false);

/**
 * Toggles the password input type between 'password' and 'text'.
 *
 * @return {void}
 */
const showPasswordToggle = () => {
    isPasswordShow.value = !isPasswordShow.value;
    if (passwordInputType.value === "password") {
        passwordInputType.value = "text";
    } else {
        passwordInputType.value = "password";
    }
};

/**
 * Validates user input on the client-side based on predefined validation rules.
 *
 * @param {string} value - The input value to be validated.
 * @param {string} type - The type of input (e.g., email, password).
 * @return {void}
 */
const validate = (value, type) => {
    const validation = validations[type];
    if (!validation) return;

    error[type] = false;
    errorMessage[type] = "";

    if (value.length < validation.minLength) {
        error[type] = true;
        errorMessage[type] = `${type.charAt(0).toUpperCase()}${type.slice(
            1,
        )} must be at least ${validation.minLength} characters`;

        return;
    }

    if (validation.regex && !validation.regex.test(value)) {
        error[type] = true;
        errorMessage[type] = `Please enter a valid ${type}`;
    }
};

// Function event on change input user email
const onChangeEmail = () => {
    validate(form.email, "email");
};

// Function event on change input user password
const onChangePassword = () => {
    validate(form.password, "password");
};

/**
 * Submits the login form after a 3-second delay.
 *
 * @return {void}
 */
const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        form.post("/login");
        isLoading.value = false;
    }, 3000);
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
