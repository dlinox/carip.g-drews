<template>
    <v-text-field v-model="value" :label="label" :rules="rulesRUC">
        <template #append-inner v-if="isInputValid">
            <v-btn
                @click="search"
                size="small"
                prepend-icon="mdi-magnify"
                color="secondary"
                :loading="loading"
            >
                SUNAT
            </v-btn>
        </template>
    </v-text-field>
    <v-snackbar v-model="snackbar" multi-line>
        RUC [{{ value }}]: No encontrado
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
import { _searchSunat } from "@/Shared/services";
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
    keyAddress: {
        type: String,
        default: "address",
    },
    keyLocation: {
        type: String,
        default: "location",
    },
});

const value = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

const rulesRUC = [
    (v) => (!!v && props.required) || "Campo requerido",
    (v) => /^[0-9]{11}$/.test(v) || "No es un RUC válido",
];

const isInputValid = computed(() => {
    const rules = rulesRUC;
    return rules.every((rule) => rule(value.value) === true);
});

const loading = ref(false);
const snackbar = ref(false);

const search = async () => {
    loading.value = true;
    const response = await _searchSunat(value.value);

    console.log(response);

    if (response === null) {
        snackbar.value = true;
        loading.value = false;
        return;
    }

    props.formState[`${props.keyName}`] = response.nombre_o_razon_social;
    props.formState[`${props.keyAddress}`] = response.direccion_completa;

    let location = {
        code: response.ubigeo_sunat,
        location:
            response.departamento +
            ", " +
            response.provincia +
            ", " +
            response.distrito,
    };

    props.formState[`${props.keyLocation}`] = { ...location };
    emit("onSearch", response);
    loading.value = false;
};
</script>
