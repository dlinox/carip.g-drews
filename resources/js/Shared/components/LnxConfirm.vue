<template>
    <v-menu
        v-model="dialogConfirm"
        :close-on-content-click="false"
        location="top right"
        activator="parent"
    >
        <v-card max-width="300">
            <v-card-item>
                <div>
                    <div class="text-subtitle-1 mb-1">{{ title }}</div>
                    <div class="text-subtitle-2">
                        {{ text }}
                    </div>
                </div>
            </v-card-item>

            <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn
                    variant="tonal"
                    color="secondary"
                    @click="dialogConfirm = false"
                >
                    No
                </v-btn>

                <v-btn
                    :loading="loading"
                    variant="tonal"
                    class="ml-1"
                    color="red"
                    @click="$emit('onConfirm'), (dialogConfirm = false)"
                >
                    Si
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-menu>
</template>

<script setup>
import { ref } from "vue";
const emit = defineEmits(["onConfirm"]);
const props = defineProps({
    title: {
        type: String,
        default: "CONFIRMAR",
    },
    text: {
        type: String,
        default: "¿Está segura de que desea eliminar este elemento?",
    },
});

const dialogConfirm = ref(false);

const loading = ref(false);
</script>
