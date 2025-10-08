<template>
    <div class="w-full">
        <!-- Note Preview (when note exists) -->
        <div
            v-if="noteSave.length > 0 && showPreviewNotes"
            class="flex items-center space-x-3 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 cursor-pointer hover:bg-blue-100 transition-all duration-200"
            @click="toggleHiddenNotes"
        >
            <div
                class="w-2.5 h-2.5 bg-blue-500 rounded-full animate-pulse flex-shrink-0"
            ></div>
            <span class="text-sm font-medium text-blue-700 truncate max-w-24">{{
                noteSave
            }}</span>
            <BaseIcon
                :path="mdiNoteEditOutline"
                size="18"
                class="text-blue-600 flex-shrink-0"
            />
        </div>

        <!-- Note Button (when no note) -->
        <button
            v-if="!noteSave.length && !isEditing"
            class="flex items-center space-x-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-600 hover:text-primary rounded-xl px-4 py-3 w-full transition-all duration-200 min-h-[44px]"
            @click="startEditing"
        >
            <BaseIcon
                :path="mdiNoteEditOutline"
                size="18"
                class="flex-shrink-0"
            />
            <span class="text-sm font-medium">Tambah catatan</span>
        </button>

        <!-- Expanded Note Input (when editing) -->
        <div
            v-if="isEditing"
            class="bg-white border-2 border-gray-200 rounded-xl p-4 shadow-lg animate-fade-in w-full"
        >
            <!-- Input Header -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-6 h-6 bg-gradient-to-r from-primary/20 to-accent/20 rounded-lg flex items-center justify-center border border-primary/30"
                    >
                        <BaseIcon
                            :path="mdiNoteEditOutline"
                            size="16"
                            class="text-primary"
                        />
                    </div>
                    <h3 class="text-base font-heading font-bold text-gray-900">
                        Catatan Pesanan
                    </h3>
                </div>
            </div>

            <!-- Note Input -->
            <div class="space-y-4">
                <textarea
                    v-model="model"
                    class="w-full h-24 px-4 py-3 text-sm text-gray-900 bg-white border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-200 resize-none placeholder-gray-500 leading-relaxed"
                    placeholder="Contoh: Tolong tuliskan 'Selamat Ulang Tahun' di atas kue"
                    maxlength="144"
                    ref="textareaRef"
                ></textarea>

                <!-- Character Counter & Actions -->
                <div class="flex items-center justify-between pt-2">
                    <!-- Character Counter -->
                    <span
                        class="text-xs font-medium"
                        :class="
                            noteLength > 120 ? 'text-red-600' : 'text-gray-600'
                        "
                    >
                        {{ noteLength }}/144 karakter
                    </span>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-3">
                        <button
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 border-0 rounded-lg transition-all duration-200 text-sm font-semibold min-w-[80px]"
                            @click="cancel"
                        >
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </button>
                        <button
                            class="px-4 py-2 bg-gradient-to-r from-primary to-accent text-white hover:from-primary-hover hover:to-accent-hover border-0 rounded-lg transition-all duration-200 shadow-soft text-sm font-semibold min-w-[80px]"
                            @click="save"
                        >
                            <i class="fas fa-check mr-2"></i>
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes fade-in {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

.animate-fade-in {
    animation: fade-in 0.25s ease-out;
}
</style>

<script setup>
import BaseIcon from "@/Components/DashboardAdmin/BaseIcon.vue";
import { mdiNoteEditOutline } from "@mdi/js";
import { computed, ref, watch, nextTick, onMounted } from "vue";

const model = defineModel("notes", {
    type: [String],
    default: "",
});

// No longer need hiddenNotes prop from parent
const props = defineProps({});

const isEditing = ref(false);
const showPreviewNotes = ref(true);
const noteSave = ref("");
const textareaRef = ref(null);

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

    // Update noteSave when model changes and there was already a saved note
    if (noteSave.value) {
        noteSave.value = value;
    }
});

// Set initial noteSave value if model already has content
onMounted(() => {
    if (model.value) {
        noteSave.value = model.value;
    }
});

/**
 * Starts editing mode and focuses the textarea
 */
const startEditing = async () => {
    isEditing.value = true;
    await nextTick();
    if (textareaRef.value) {
        textareaRef.value.focus();
    }
};

/**
 * Cancels editing and reverts to the previous state
 */
const cancel = () => {
    isEditing.value = false;
    // If there was no saved note before, revert model to empty
    if (!noteSave.value) {
        model.value = "";
    } else {
        // Otherwise revert to the saved note
        model.value = noteSave.value;
    }
};

/**
 * Saves the notes and hides the input field
 */
const save = () => {
    isEditing.value = false;
    noteSave.value = model.value;
};
</script>
