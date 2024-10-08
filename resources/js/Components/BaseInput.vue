<template>
    <div class="flex flex-col">
        <label
            class="input input-bordered flex items-center gap-2"
            :class="[
                { 'justify-between': inputType === 'password' },
                { 'border border-error mb-3': error },
                inputClass,
            ]"
        >
            <div class="w-full flex items-center gap-2">
                <component :is="icon"></component>
                <input
                    v-model="model"
                    @input="model = $event.target.value"
                    class="w-full"
                    :type="inputType"
                    :placeholder="placeholder"
                    :name="inputName"
                    :autocomplete="getAutocompleteValue"
                />
            </div>
            <div
                @click="showPasswordToggle"
                v-if="inputType === `password` && !isPasswordShow"
            >
                <IconEye />
            </div>
            <div @click="showPasswordToggle" v-else-if="isPasswordShow">
                <IconEyeSlash />
            </div>
        </label>
        <span class="text-error label-text-alt" v-show="error">{{
            props.errorMessage
        }}</span>
    </div>
</template>

<script setup>
import { defineProps, defineModel, computed } from "vue";
import IconEmail from "@/Components/Icons/IconEmail.vue";
import IconPassword from "@/Components/Icons/IconPassword.vue";
import IconUser from "@/Components/Icons/IconUser.vue";
import IconAddress from "@/Components/Icons/IconAddress.vue";
import IconEye from "@/Components/Icons/IconEye.vue";
import IconEyeSlash from "@/Components/Icons/IconEyeSlash.vue";
import IconDate from "@/Components/Icons/IconDate.vue";

const model = defineModel();

const props = defineProps({
    placeholder: {
        type: String,
        default: null,
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
        type: String || Number || Date,
        required: true,
    },
    isPasswordShow: {
        type: Boolean,
        default: false,
    },
    showPasswordToggle: {
        type: Function,
    },
    inputClass: {
        type: String,
        default: null,
    },
    inputName: {
        type: String,
        default: null,
    },
});

const icon = computed(() => {
    return {
        email: IconEmail,
        password: IconPassword,
        address: IconAddress,
        username: IconUser,
        date: IconDate,
    }[props.inputType];
});

const getAutocompleteValue = computed(() => {
    // Set autocomplete based on input type or name
    if (props.inputType === "password") {
        return "current-password";
    } else if (props.inputType === "email") {
        return "email";
    }

    return props.inputName; // Fallback to the inputName
});
</script>
