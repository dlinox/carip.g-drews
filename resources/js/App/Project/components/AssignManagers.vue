<template>
    <v-card class="rounded-0" elevation="0">
        <v-toolbar density="compact">
            <v-toolbar-title>
                <small> Responsable(s) </small>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn prepend-icon="mdi-plus" color="primary" link>
                Asignar
            </v-btn>
        </v-toolbar>
        <v-list-item
            title="Juan peres"
            subtitle="Gerente"
            class="border-b py-2"
        >
            <template v-slot:prepend>
                <v-icon icon="mdi-account-tie"></v-icon>
            </template>
            <template v-slot:append>
                <v-btn
                    color="error"
                    variant="tonal"
                    size="small"
                    prepend-icon="mdi-minus-circle"
                >
                    Desasignar
                </v-btn>
            </template>
        </v-list-item>
        <v-list-item
            title="Juan peres"
            subtitle="Gerente"
            class="border-b py-2"
        >
            <template v-slot:prepend>
                <v-icon icon="mdi-account-tie"></v-icon>
            </template>
            <template v-slot:append>
                <v-btn
                    color="error"
                    variant="tonal"
                    size="small"
                    prepend-icon="mdi-minus-circle"
                >
                    Desasignar
                </v-btn>
            </template>
        </v-list-item>
    </v-card>
</template>

<script setup>
import { ref } from "vue";
const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});
</script>
