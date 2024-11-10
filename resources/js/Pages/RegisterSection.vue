<template>
    <Auth>
        <loading
            v-model:active="isLoading"
            :can-cancel="true"
            color="#EBA9AE"
            background-color="#B2BEB5"
        />
        <div
            class="first-section min-h-screen hidden lg:w-[60%] lg:block rounded-e-2xl"
        ></div>
        <div
            class="h-full w-full lg:w-[40%] mt-3 flex flex-col items-center justify-center gap-4 bg-base-100"
        >
            <div class="flex flex-col items-center justify-center">
                <div class="avatar">
                    <div class="w-32 lg:w-24 rounded-full">
                        <img
                            src="/assets/image/logo-dreamdessert.webp"
                            alt="ini gambar"
                        />
                    </div>
                </div>
                <h1 class="text-primary-color font-bold text-3xl">
                    Daftar Akun
                </h1>
            </div>
            <form @submit.prevent="submit" class="flex flex-col gap-3">
                <BaseAlert v-if="errors.email" type="alert-error">{{
                    errors.email
                }}</BaseAlert>
                <BaseAlert v-else-if="errors.password" type="alert-error">{{
                    errors.password
                }}</BaseAlert>
                <BaseAlert v-else-if="errors.username" type="alert-error">{{
                    errors.username
                }}</BaseAlert>
                <BaseAlert v-else-if="errors.address" type="alert-error">{{
                    errors.address
                }}</BaseAlert>
                <div class="flex flex-col gap-2">
                    <BaseLabel label="Nama Pengguna" :required="true" />
                    <BaseInput
                        v-model="form.username"
                        style="width: 450px"
                        placeholder="user1234"
                        input-type="username"
                        :error="error.username"
                        :error-message="errorMessage.username"
                        @change="onChangeUsername"
                    />
                </div>
                <div class="flex flex-col gap-2">
                    <BaseLabel label="Email" :required="true" />
                    <BaseInput
                        v-model="form.email"
                        style="width: 450px"
                        placeholder="user@gmail.com"
                        input-type="email"
                        :error="error.email"
                        :error-message="errorMessage.email"
                        @change="onChangeEmail"
                    />
                </div>
                <!-- <div class="flex flex-col gap-2">
                    <BaseLabel label="Alamat" :required="true" />
                    <BaseInput
                        v-model="form.address"
                        style="width: 450px"
                        placeholder="Alamat Pengguna"
                        input-type="address"
                        :error="error.address"
                        :error-message="errorMessage.address"
                        @change="onChangeAddress"
                    />
                </div> -->
                <div class="flex flex-col gap-2">
                    <BaseLabel label="Password" :required="true" />
                    <BaseInput
                        v-model="form.password"
                        style="width: 450px"
                        placeholder="Min. 8 Karakter"
                        :input-type="passwordInputType.password"
                        :error="error.password"
                        :error-message="errorMessage.password"
                        @change="onChangePassword"
                        :is-password-show="isPasswordShow.password"
                        :show-password-toggle="
                            () => showPasswordToggle('password')
                        "
                    />
                </div>
                <div class="flex flex-col gap-2">
                    <BaseLabel label="Ulangi Password" :required="true" />
                    <BaseInput
                        v-model="form.password_confirmation"
                        style="width: 450px"
                        placeholder="Sama dengan password di atas"
                        :input-type="passwordInputType.confirmPassword"
                        :error="error.confirmPassword"
                        :error-message="errorMessage.confirmPassword"
                        @change="onChangeConfirmPassword"
                        :is-password-show="isPasswordShow.confirmPassword"
                        :show-password-toggle="
                            () => showPasswordToggle('confirmPassword')
                        "
                    />
                </div>
                <button class="btn w-full bg-base-300 font-bold text-lg">
                    Daftar
                </button>
                <p class="text-sm mx-auto">
                    Sudah punya akun?
                    <inertia-link
                        :href="route('login.index')"
                        class="text-sm underline"
                    >
                        Masuk</inertia-link
                    >
                </p>
            </form>
        </div>
    </Auth>
</template>

<script setup>
import { ref, reactive, defineProps } from "vue";
import Auth from "@/Layouts/Auth.vue";
import BaseInput from "@/Components/BaseInput.vue";
import BaseLabel from "@/Components/BaseLabel.vue";
import BaseAlert from "@/Components/BaseAlert.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

defineProps({ errors: Object });

const error = reactive({
    username: false,
    email: false,
    address: false,
    password: false,
    confirmPassword: false,
});
const errorMessage = reactive({
    username: "",
    email: "",
    address: "",
    password: "",
    confirmPassword: "",
});

const errorMessageRegex = {
    username:
        "Username can only include letters, numbers, dots, underscores, and hyphens.",
    email: "Please enter a valid email address.",
    address:
        "Address can only include letters, numbers, spaces, commas, periods, and hyphens.",
};

const form = useForm({
    username: "",
    email: "",
    address: "",
    password: "",
    password_confirmation: "",
});

const validations = {
    username: {
        regex: /^[a-zA-Z0-9._-]{1,}$/,
        minLength: 1,
    },
    email: {
        regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
        minLength: 1,
    },
    address: {
        regex: /^[a-zA-Z0-9\s,.-]{5,}$/,
        minLength: 5,
    },
    password: {
        minLength: 8,
    },
    confirmPassword: {
        minLength: 8,
    },
};

const isPasswordShow = reactive({
    password: false,
    confirmPassword: false,
});
const passwordInputType = reactive({
    password: "password",
    confirmPassword: "password",
});

const showPasswordToggle = (field) => {
    isPasswordShow[field] = !isPasswordShow[field];
    passwordInputType[field] = isPasswordShow[field] ? "text" : "password";
};

const isLoading = ref(false);

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
        errorMessage[type] = errorMessageRegex[type];
    }
};

const onChangeUsername = () => {
    validate(form.username, "username");
};

const onChangeEmail = () => {
    validate(form.email, "email");
};

const onChangeAddress = () => {
    validate(form.address, "address");
};

const onChangePassword = () => {
    validate(form.password, "password");
};

const onChangeConfirmPassword = () => {
    validate(form.password_confirmation, "confirmPassword");
};

const submit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        form.post("/register");
    }, 3000);
};
</script>

<style scoped>
.first-section {
    background-image: url(/assets/image/register-background.webp);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
