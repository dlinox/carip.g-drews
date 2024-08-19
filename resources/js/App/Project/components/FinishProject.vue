<template>
    <v-btn
        color="white"
        
        variant="outlined"
        prepend-icon="mdi-table-lock"
        :disabled="isFinish"
        @click="isFinish ? null : (dialog = true)"
    >
        {{ isFinish ? "Finalizado" : "Finalizar" }}
    </v-btn>
    <v-dialog v-model="dialog" max-width="400" persistent>
        <v-card title="¿Seguro(a) de finalizar el proyecto?">
            <v-card-text>
                Al finalizar el proyecto, no se podrá realizar cambios en el
                mismo. Los responsables, supervisores, operadores y vehículos
                podrán ser reasignados.
            </v-card-text>
            <template v-slot:actions>
                <v-spacer></v-spacer>

                <v-btn @click="dialog = false" color="secondary">
                    Cancelar
                </v-btn>

                <v-btn @click="dialog = false" variant="flat">
                    Finalizar
                </v-btn>
            </template>
        </v-card>
    </v-dialog>
</template>
<script setup>
import { ref } from "vue";

const dialog = ref(false);

const props = defineProps({
    isFinish: {
        type: Boolean,
        default: false,
    },
    project: Object,
});
</script>
