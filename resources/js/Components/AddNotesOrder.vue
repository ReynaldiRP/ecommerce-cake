<template>
    <div class="flex flex-col gap-1 dropdown dropdown-end">
        <label
            class="input input-sm flex items-center input-disabled"
            v-if="noteSave.length > 0 && showPreviewNotes"
            @click="toggleHiddenNotes"
        >
            <input type="text" :value="noteSave" class="cursor-pointer" />
            <BaseIcon :path="mdiNoteEditOutline" size="22" />
        </label>
        <div
            v-else
            tabindex="0"
            class="font-bold cursor-pointer flex items-center"
            @click="toggleHiddenNotes"
        >
            <BaseIcon :path="mdiNoteEditOutline" size="22" />
        </div>

        <div
            class="bg-base-200 p-4 card compact dropdown-content menu gap-4 mt-8 items-center z-50"
            v-show="hiddenNotes"
        >
            <label class="form-control w-72">
                <div class="label">
                    <span class="label-text">Catatan Order</span>
                </div>
                <textarea
                    v-model="model"
                    class="textarea textarea-bordered h-24"
                    placeholder="Jangan memasukan data pribadi"
                ></textarea>
                <div class="label ms-auto">
                    <span class="label-text">{{ noteLength }}/144</span>
                </div>
            </label>

            <div class="flex items-center gap-2">
                <button class="btn w-36 btn-neutral" @click="cancel">
                    Batal
                </button>
                <button class="btn w-36 btn-success" @click="save">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import BaseIcon from "@/Components/DashboardAdmin/BaseIcon.vue";
import { mdiNoteEditOutline } from "@mdi/js";
import { computed, ref, watch } from "vue";

const model = defineModel("notes", {
    type: [String],
    default: "",
});

const props = defineProps({
    hiddenNotes: {
        type: Boolean,
        default: false,
    },
});

const showPreviewNotes = ref(false);
const noteSave = ref("");
const noteLength = computed(() => {
    return model.value.length;
});

const noteMaxLength = 144;

/**
 * Watches the `model` for changes. If the length of the new value exceeds `noteMaxLength`,
 * it truncates the value to `noteMaxLength` characters.
 */
watch(model, (value) => {
    if (value.length > noteMaxLength) {
        model.value = value.slice(0, noteMaxLength);
    }
});

const emit = defineEmits(["update:hiddenNotes"]);

/**
 * Toggles the visibility of the notes section by emitting an event to update the hiddenNotes property.
 */
const toggleHiddenNotes = () => emit("update:hiddenNotes", !props.hiddenNotes);

const cancel = () => emit("update:hiddenNotes", false);

/**
 * Saves the notes and updates the hiddenNotes property to hide the notes section.
 */
const save = () => {
    emit("update:hiddenNotes", false);
    showPreviewNotes.value = true;
    noteSave.value = model.value;
};
</script>
