<template>
    <div class="flex flex-col">
        <label
            class="input input-bordered input-lg lg:input-md xl:input-md flex items-center justify-between gap-2"
            :class="{
                'border border-error mb-3': error,
            }"
        >
            <div class="flex items-center gap-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 16 16"
                    fill="currentColor"
                    class="w-4 h-4 opacity-70"
                    v-if="inputType === `email`"
                >
                    <path
                        d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z"
                    />
                    <path
                        d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z"
                    />
                </svg>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 16 16"
                    fill="currentColor"
                    class="w-4 h-4 opacity-70"
                    v-else-if="inputType === `password`"
                >
                    <path
                        fill-rule="evenodd"
                        d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                        clip-rule="evenodd"
                    />
                </svg>
                <input
                    v-model="model"
                    :type="inputType"
                    :placeholder="placeholder"
                    autocomplete="username"
                />
            </div>
            <div @click="showPasswordToggle" v-show="isPasswordShow">
                <i
                    class="transition-all ease-in-out fas fa-eye-slash cursor-pointer"
                    v-if="inputType === `password`"
                ></i>
            </div>
            <div @click="showPasswordToggle" v-show="!isPasswordShow">
                <i
                    class="transition-all ease-in-out fas fa-eye cursor-pointer"
                    v-if="inputType === `password`"
                ></i>
            </div>
        </label>
        <span class="text-error label-text-alt" v-show="error">{{
            errorMessage
        }}</span>
    </div>
</template>

<script setup>
import { ref, defineProps, defineModel } from "vue";

const isPasswordShow = ref(false);

const showPasswordToggle = () => {
    isPasswordShow.value = !isPasswordShow.value;
    console.log(isPasswordShow.value);
};

const model = defineModel();

const props = defineProps({
    placeholder: {
        type: String,
        required: true,
    },
    error: {
        type: Boolean,
        default: false,
    },
    errorMessage: {
        type: String,
        default: "",
    },
    inputType: {
        type: String,
        required: true,
    },
});
</script>
