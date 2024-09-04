<template>
    <div class="flex flex-col">
        <label
            class="input input-bordered flex items-center gap-2"
            :class="{
                'justify-between': inputType === `password`,
                'border border-error mb-3': error,
            }"
        >
            <div class="w-full flex items-center gap-2">
                <component :is="icon"></component>
                <input
                    v-model="model"
                    class="w-full"
                    :type="inputType"
                    :placeholder="placeholder"
                    autocomplete="username"
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
</script>
