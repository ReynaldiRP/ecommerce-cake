<template>
    <div class="flex flex-col">
        <label
            class="input input-bordered input-lg lg:input-md xl:input-md flex items-center justify-between gap-2"
            :class="{
                'border border-error mb-3': error,
            }"
        >
            <div class="flex items-center gap-2">
                <component :is="icon"></component>
                <input
                    v-model="model"
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
    }[props.inputType];
});
</script>
