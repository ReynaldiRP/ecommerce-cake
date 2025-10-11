<template>
    <Auth>
        <loading
            v-model:active="isLoading"
            :can-cancel="true"
            color="#D946EF"
            background-color="#F8FAFC"
        />

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
                    Bergabunglah dengan Dream Dessert
                </h2>
                <p
                    class="text-lg xl:text-xl text-white/95 leading-relaxed max-w-2xl mx-auto"
                >
                    Daftar sekarang untuk menikmati kue-kue istimewa dan promo
                    eksklusif. Raih pengalaman berbelanja yang tak terlupakan
                    bersama kami.
                </p>
            </div>
        </div>

        <!-- Register Form Section -->
        <div
            class="min-h-screen w-full lg:w-2/5 xl:w-1/3 flex flex-col items-center justify-center p-6 lg:p-8 xl:p-12 bg-gradient-soft overflow-y-auto"
        >
            <div class="w-full max-w-lg my-8">
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
                        Daftar Akun
                    </h1>
                    <p class="text-gray-600 text-lg">
                        Buat akun baru untuk mulai berbelanja kue favorit Anda
                    </p>
                </div>

                <!-- Register Form -->
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-card border border-white/20 p-8"
                >
                    <form @submit.prevent="submit" class="space-y-6">
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
                        <BaseAlert
                            v-else-if="errors.username"
                            type="alert-error"
                        >
                            {{ errors.username }}
                        </BaseAlert>
                        <BaseAlert
                            v-else-if="errors.address"
                            type="alert-error"
                        >
                            {{ errors.address }}
                        </BaseAlert>

                        <!-- Username Field -->
                        <div class="space-y-2">
                            <BaseLabel
                                label="Nama Pengguna"
                                :required="true"
                                class="text-gray-700 font-semibold"
                            />
                            <BaseInput
                                v-model="form.username"
                                class="w-full"
                                placeholder="user1234"
                                input-type="username"
                                :error="error.username"
                                :error-message="errorMessage.username"
                                @change="onChangeUsername"
                            />
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <BaseLabel
                                label="Email"
                                :required="true"
                                class="text-gray-700 font-semibold"
                            />
                            <BaseInput
                                v-model="form.email"
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
                                class="w-full"
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

                        <!-- Confirm Password Field -->
                        <div class="space-y-2">
                            <BaseLabel
                                label="Ulangi Password"
                                :required="true"
                                class="text-gray-700 font-semibold"
                            />
                            <BaseInput
                                v-model="form.password_confirmation"
                                class="w-full"
                                placeholder="Sama dengan password di atas"
                                :input-type="passwordInputType.confirmPassword"
                                :error="error.confirmPassword"
                                :error-message="errorMessage.confirmPassword"
                                @change="onChangeConfirmPassword"
                                :is-password-show="
                                    isPasswordShow.confirmPassword
                                "
                                :show-password-toggle="
                                    () => showPasswordToggle('confirmPassword')
                                "
                            />
                        </div>

                        <!-- Register Button -->
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-primary to-accent text-white font-bold text-lg py-4 rounded-2xl shadow-card hover:shadow-soft transition-all duration-300 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="isLoading"
                        >
                            <span v-if="!isLoading">Daftar</span>
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

                        <!-- Login Link -->
                        <div class="text-center pt-4">
                            <p class="text-gray-600">
                                Sudah punya akun?
                                <inertia-link
                                    :href="route('login.index')"
                                    class="text-primary hover:text-accent font-semibold transition-colors duration-200 ml-1"
                                >
                                    Masuk
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
/* Background image with better proportions */
.first-section {
    background-image: url(/assets/image/register-background.webp);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
}

/* Ensure proper proportions across screen sizes */
@media (min-width: 1024px) {
    .first-section {
        background-attachment: scroll;
    }
}

/* Better responsive proportions */
@media (min-width: 1280px) {
    .first-section {
        background-position: center center;
        background-size: cover;
    }
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

/* Form spacing for better mobile experience */
@media (max-width: 1024px) {
    .first-section {
        display: none !important;
    }
}

@media (max-width: 640px) {
    .rounded-3xl {
        border-radius: 1.5rem;
    }

    .p-8 {
        padding: 1.5rem;
    }

    .space-y-6 > * + * {
        margin-top: 1rem;
    }
}

/* Better spacing for mobile forms */
@media (max-height: 800px) and (max-width: 1024px) {
    .min-h-screen {
        min-height: auto;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }
}

/* Enhanced form container sizing */
@media (min-width: 1280px) {
    .max-w-lg {
        max-width: 32rem;
    }
}

/* Smooth scroll for long forms on mobile */
@media (max-width: 640px) {
    .overflow-y-auto {
        scroll-behavior: smooth;
    }
}
</style>
