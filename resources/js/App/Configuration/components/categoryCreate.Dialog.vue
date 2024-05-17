<template>
    <v-dialog v-model="dialog" max-width="600px">
        <v-card>
            <v-card-title>
                <span class="headline">Crear Categoría</span>
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-row>
                        <v-col cols="12">
                            <v-select
                                v-model="form.modelType"
                                :items="modelTypes"
                                label="Tipo"
                                outlined
                                dense
                                required
                            ></v-select>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                v-model="form.name"
                                label="Nombre"
                                outlined
                                dense
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <v-text-field
                                v-model="form.description"
                                label="Descripción"
                                outlined
                                dense
                                required
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialog = false">
                    Cancelar
                </v-btn>
                <v-btn color="blue darken-1" text @click="submit">
                    Guardar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script setup>
import { ref, computed } from "vue";
import { _createCategory } from "@/App/Configuration/services/category.services";

const emit = defineEmits(["update:modelValue"]);
const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false,
    },
    modelTypes: {
        type: Array,
    },
});

const dialog = computed({
    get: () => props.modelValue,
    set: (value) => {
        emit("update:modelValue", value);
    },
});

const form = ref({
    modelType: null,
    name: "",
    description: "",
});

const submit = async () => {
    await _createCategory(form.value);
    dialog.value = false;
};
</script>
