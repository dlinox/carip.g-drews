<template>
    <v-text-field v-model="value" :label="label" :rules="rulesDNI">
        <template #append-inner v-if="isInputValid">
            <v-btn
                @click="search"
                size="small"
                prepend-icon="mdi-magnify"
                color="secondary"
                :loading="loading"
            >
                RENIEC
            </v-btn>
        </template>
    </v-text-field>
    <v-snackbar v-model="snackbar" multi-line>
        DNI [{{ value }}]: No encontrado
        <template v-slot:actions>
            <v-btn
                color="red"
                variant="text"
                @click="snackbar = false"
                icon="mdi-close"
            >
            </v-btn>
        </template>
    </v-snackbar>
</template>
<script setup>
import { computed, ref } from "vue";
import { _searchReniec } from "@/Shared/services";
const emit = defineEmits(["update:modelValue", "onSearch"]);
const props = defineProps({
    modelValue: {
        type: String,
    },

    label: {
        type: String,
        default: "",
    },

    required: {
        type: Boolean,
        default: false,
    },

    formState: {
        type: Object,
        default: null,
    },

    keyName: {
        type: String,
        default: "name",
    },
    keyPaternalSurname: {
        type: String,
        default: "paternal_surname",
    },
    keyMaternalSurname: {
        type: String,
        default: "maternal_surname",
    },
});

const value = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

const rulesDNI = [
    (v) => (!!v && props.required) || "Campo requerido",
    (v) => /^[0-9]{8}$/.test(v) || "No es un DNI válido",
];

const isInputValid = computed(() => {
    const rules = rulesDNI;
    return rules.every((rule) => rule(value.value) === true);
});

const loading = ref(false);
const snackbar = ref(false);

const search = async () => {
    loading.value = true;

    const response = await _searchReniec(value.value);

    if (response === null) {
        snackbar.value = true;
        loading.value = false;
        return;
    }

    props.formState[`${props.keyName}`] = response.nombres;
    props.formState[`${props.keyMaternalSurname}`] = response.apellido_materno;
    props.formState[`${props.keyPaternalSurname}`] = response.apellido_paterno;

    emit("onSearch", response);
    loading.value = false;
};
</script>
