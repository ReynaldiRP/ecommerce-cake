<template>
    <App>
        <section
            class="min-h-screen w-full py-36 xl:py-28 px-10 flex flex-col justify-center gap-4"
        >
            <h1 class="text-4xl font-bold text-center xl:text-start">
                Your Orders
            </h1>
            <section class="flex justify-center xl:justify-between gap-4">
                <section class="flex flex-col gap-4">
                    <section
                        class="h-fit w-[700px] flex flex-col gap-6 p-4 border rounded-lg bg-neutral"
                        v-for="(item, index) in 3"
                        :key="index"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex gap-3">
                                <div
                                    class="avatar rounded-lg outline outline-neutral shadow-lg"
                                >
                                    <div class="w-20 rounded">
                                        <img
                                            src="assets/image/default-img.jpg"
                                            alt="Tailwind-CSS-Avatar-component"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h1 class="text-xl text-white">
                                        Product {{ item }}
                                    </h1>
                                    <div class="flex gap-2 text-white">
                                        <p class="text-base text-opacity-75">
                                            Product {{ item }}
                                        </p>
                                        <p class="text-base text-opacity-75">
                                            Product {{ item }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 text-white">
                                <h1 class="text-xl font-bold">Rp25000</h1>
                                <div class="join">
                                    <button
                                        class="btn btn-outline border-white shadow-lg join-item"
                                    >
                                        -
                                    </button>
                                    <input
                                        class="input input-ghost input-bordered border-white text-center w-14 join-item focus:bg-transparent"
                                        :value="item"
                                    />
                                    <button
                                        class="btn btn-outline border-white shadow-lg join-item"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="px-2 text-xl font-bold text-white/70">
                            <div class="flex justify-between">
                                <h1>Subtotal</h1>
                                <h1>Rp15000</h1>
                            </div>
                            <div class="flex justify-between">
                                <h1>Flavour</h1>
                                <h1>Rp5000</h1>
                            </div>
                            <div class="flex justify-between">
                                <h1>Toppings</h1>
                                <h1>Rp10000</h1>
                            </div>
                            <div
                                class="px-2 flex justify-between mt-4 border-t-white border-t-2 text-white"
                            >
                                <h1>Totals</h1>
                                <h1>Rp30000</h1>
                            </div>
                        </div>
                    </section>
                </section>
                <form
                    @submit.prevent=""
                    class="h-fit w-[700px] rounded-lg px-8 py-6 flex flex-col gap-4 bg-neutral border border-white"
                >
                    <h1 class="text-4xl text-white font-bold">Checkout</h1>
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-2">
                            <BaseLabel
                                label="Contact Information"
                                :required="true"
                            />
                            <BaseInput
                                v-model="form.email"
                                style="width: 100%"
                                placeholder="user@gmail.com"
                                input-type="email"
                                id="email"
                                :error="error.email"
                                :error-message="errorMessage.email"
                                @change="onChangeEmail"
                            />
                        </div>
                        <div class="flex flex-col gap-2">
                            <BaseLabel
                                label="Shipping Address"
                                :required="true"
                            />
                            <BaseInput
                                v-model="form.address"
                                style="width: 100%"
                                placeholder="User Address"
                                input-type="address"
                                :error="error.address"
                                :error-message="errorMessage.address"
                                @change="onChangeAddress"
                            />
                        </div>
                        <div class="flex flex-col gap-2">
                            <BaseInput
                                v-model="form.username"
                                style="width: 100%"
                                placeholder="user1234"
                                input-type="username"
                                :error="error.username"
                                :error-message="errorMessage.username"
                                @change="onChangeUsername"
                            />
                        </div>
                        <button
                            class="btn bg-primary-color text-base-300 hover:text-white"
                        >
                            Place Order
                        </button>
                    </div>
                </form>
            </section>
        </section>
    </App>
</template>

<script setup>
import App from "@/Layouts/App.vue";
import BaseInput from "@/Components/BaseInput.vue";
import BaseLabel from "@/Components/BaseLabel.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";

// State for error in client side
const error = reactive({
    email: false,
    address: false,
    username: false,
});

// State for error message in client side
const errorMessage = reactive({
    email: "",
    address: "",
    username: "",
});

// Form helper for input fields
const form = useForm({
    email: "",
    address: "",
    username: "",
});

const errorMessageRegex = {
    username:
        "Username can only include letters, numbers, dots, underscores, and hyphens.",
    email: "Please enter a valid email address.",
    address:
        "Address can only include letters, numbers, spaces, commas, periods, and hyphens.",
};

// Valdation for email and password in client side
const validations = {
    email: {
        regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
        minLength: 1,
    },
    username: {
        regex: /^[a-zA-Z0-9._-]{1,}$/,
        minLength: 1,
    },
    email: {
        regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
        minLength: 1,
    },
};

// Function for validation user input in client side
const validate = (value, type) => {
    const validation = validations[type];
    if (!validation) return;

    error[type] = false;
    errorMessage[type] = "";

    if (value.length < validation.minLength) {
        error[type] = true;
        errorMessage[type] = `${type.charAt(0).toUpperCase()}${type.slice(
            1
        )} must be at least ${validation.minLength} characters`;

        return;
    }

    if (validation.regex && !validation.regex.test(value)) {
        error[type] = true;
        errorMessage[type] = errorMessageRegex[type];
    }
};

// Function event on change input user email
const onChangeEmail = () => {
    validate(form.email, "email");
};

const onChangeUsername = () => {
    validate(form.username, "username");
};

const onChangeAddress = () => {
    validate(form.address, "address");
};
</script>
