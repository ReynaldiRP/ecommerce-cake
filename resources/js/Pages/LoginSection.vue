<template>
    <Auth>
        <loading
            v-model:active="isLoading"
            :can-cancel="true"
            color="#D946EF"
            background-color="#F8FAFC"
        />

        <!-- Background Section -->
        <!-- Background Section -->
        <div
            class="min-h-screen hidden lg:flex lg:w-3/5 xl:w-2/3 first-section relative overflow-hidden items-center justify-center"
        >
            <div
                class="absolute inset-0 bg-gradient-to-br from-primary/40 to-accent/40"
            ></div>
            <div class="absolute inset-0 bg-black/30"></div>
            <div
                class="relative z-10 text-center text-white px-8 xl:px-16 max-w-3xl"
            >
                <div class="mb-12">
                    <div
                        class="w-28 h-28 xl:w-32 xl:h-32 mx-auto bg-white/20 backdrop-blur-md rounded-3xl flex items-center justify-center shadow-2xl mb-8"
                    >
                        <img
                            src="/assets/image/logo-dreamdessert.webp"
                            alt="Dream Dessert Logo"
                            class="w-20 h-20 xl:w-24 xl:h-24 object-contain"
                        />
                    </div>
                </div>
                <h2
                    class="text-4xl xl:text-6xl font-heading font-bold mb-8 leading-tight"
                >
                    Selamat Datang Kembali!
                </h2>
                <p
                    class="text-lg xl:text-xl text-white/95 leading-relaxed max-w-2xl mx-auto"
                >
                    Masuk ke akun Anda untuk melanjutkan pengalaman berbelanja
                    kue terbaik di Dream Dessert
                </p>
            </div>
        </div>

        <!-- Login Form Section -->
        <div
            class="min-h-screen w-full lg:w-2/5 xl:w-1/3 flex flex-col items-center justify-center p-6 lg:p-8 xl:p-12 bg-gradient-soft"
        >
            <div class="w-full max-w-lg">
                <!-- Header -->
                <div class="text-center mb-10">
                    <div class="mb-6 lg:hidden">
                        <div
                            class="w-20 h-20 mx-auto bg-gradient-to-r from-primary to-accent rounded-3xl flex items-center justify-center shadow-card mb-4"
                        >
                            <img
                                src="/assets/image/logo-dreamdessert.webp"
                                alt="Dream Dessert Logo"
                                class="w-12 h-12 object-contain"
                            />
                        </div>
                    </div>
                    <h1
                        class="text-3xl lg:text-4xl xl:text-5xl font-heading font-bold text-gray-900 mb-3"
                    >
                        Masuk
                    </h1>
                    <p class="text-gray-600 text-lg">
                        Silakan masuk ke akun Anda
                    </p>
                </div>

                <!-- Login Form -->
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-8"
                >
                    <form
                        @submit.prevent="submit"
                        class="space-y-6"
                        autocomplete="on"
                    >
                        <!-- Error Alerts -->
                        <BaseAlert v-if="errors.email" type="alert-error">
                            {{ errors.email }}
                        </BaseAlert>
                        <BaseAlert
                            v-else-if="errors.password"
                            type="alert-error"
                        >
                            {{ errors.password }}
                        </BaseAlert>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <BaseLabel
                                label="Email"
                                :required="true"
                                class="text-gray-700 font-semibold"
                            />
                            <BaseInput
                                v-model="form.email"
                                name="email"
                                autocomplete="email"
                                class="w-full"
                                placeholder="user@gmail.com"
                                input-type="email"
                                :error="error.email"
                                :error-message="errorMessage.email"
                                @change="onChangeEmail"
                            />
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <BaseLabel
                                label="Password"
                                :required="true"
                                class="text-gray-700 font-semibold"
                            />
                            <BaseInput
                                v-model="form.password"
                                name="password"
                                autocomplete="current-password"
                                class="w-full"
                                placeholder="Min. 8 Karakter"
                                :input-type="passwordInputType"
                                :error="error.password"
                                :error-message="errorMessage.password"
                                @change="onChangePassword"
                                :is-password-show="isPasswordShow"
                                :show-password-toggle="showPasswordToggle"
                            />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2"
                                />
                                <label
                                    for="remember"
                                    class="text-sm text-gray-600 cursor-pointer"
                                >
                                    Ingat saya
                                </label>
                            </div>
                            <inertia-link
                                class="text-sm text-primary hover:text-accent transition-colors duration-200 font-medium"
                            >
                                Lupa password?
                            </inertia-link>
                        </div>

                        <!-- Login Button -->
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-primary to-accent text-white font-bold text-lg py-4 rounded-2xl shadow-card hover:shadow-soft transition-all duration-300 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="isLoading"
                        >
                            <span v-if="!isLoading">Masuk</span>
                            <span
                                v-else
                                class="flex items-center justify-center space-x-2"
                            >
                                <svg
                                    class="animate-spin h-5 w-5"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                        fill="none"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                                <span>Memproses...</span>
                            </span>
                        </button>

                        <!-- Register Link -->
                        <div class="text-center pt-4">
                            <p class="text-gray-600">
                                Tidak punya akun?
                                <inertia-link
                                    :href="route('register.index')"
                                    class="text-primary hover:text-accent font-semibold transition-colors duration-200 ml-1"
                                >
                                    Daftar Sekarang
                                </inertia-link>
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="text-center mt-8">
                    <p class="text-sm text-gray-500">
                        © 2025 Dream Dessert. Semua hak dilindungi.
                    </p>
                </div>
            </div>
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
/* Background image with better proportions */
.first-section {
    background-image: url(/assets/image/login-background.webp);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
}

/* Custom input styles to match design system */
:deep(.input) {
    background-color: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 1rem;
    padding: 0.875rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    color: #1f2937;
    min-height: 3.5rem;
}

:deep(.input:focus-within) {
    border-color: #d946ef;
    box-shadow: 0 0 0 3px rgba(217, 70, 239, 0.1);
    background-color: #ffffff;
    outline: none;
}

:deep(.input input) {
    background: transparent;
    border: none;
    outline: none;
    color: #1f2937;
}

:deep(.input input::placeholder) {
    color: #9ca3af;
}

:deep(.input:hover) {
    border-color: #cbd5e1;
}

/* Error state */
:deep(.input.border-error) {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Focus state for icons */
:deep(.input:focus-within svg) {
    color: #d946ef;
}

/* Loading animation styles */
@keyframes pulse {
    0%,
    100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Mobile responsive adjustments */
@media (max-width: 1024px) {
    .first-section {
        display: none;
    }
}

@media (max-width: 640px) {
    .rounded-3xl {
        border-radius: 1.5rem;
    }
}

/* Background image adjustments for better proportions */
@media (min-width: 1024px) {
    .first-section {
        background-attachment: scroll;
    }
}
</style>
