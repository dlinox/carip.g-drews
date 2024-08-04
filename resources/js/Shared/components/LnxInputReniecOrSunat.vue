<template>
    <v-text-field
        v-model="value"
        :label="label"
        :rules="
            searchIn === 'RENIEC'
                ? rulesDNI
                : searchIn === 'SUNAT'
                ? rulesRUC
                : required
                ? [(v) => !!v || 'El campo es requerido']
                : rules
        "
    >
        <template
            #append-inner
            v-if="
                (searchIn === 'RENIEC' || searchIn === 'SUNAT') && isInputValid
            "
        >
            <v-btn
                @click="search"
                size="small"
                prepend-icon="mdi-magnify"
                color="secondary"
                :loading="loading"
            >
                {{ searchIn }}
            </v-btn>
        </template>
    </v-text-field>

    <pre>
        {{ form }}
    </pre>
    <v-snackbar v-model="snackbar" multi-line>
        {{ searchIn === "RENIEC" ? "DNI" : "RUC" }}: No encontrado
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
import { _searchReniec, _searchSunat } from "@/Shared/services";
const emit = defineEmits(["update:modelValue", "onSearch"]);
const props = defineProps({
    service: Function,
    modelValue: {
        type: String,
    },
    required: {
        type: Boolean,
        default: false,
    },
    label: {
        type: String,
        default: "",
    },
    rules: {
        type: Array,
        default: () => [],
    },
    searchIn: {
        type: [String, Boolean],
        default: "NONE",
        validator: (value) => {
            return ["RENIEC", "SUNAT", "NONE"].includes(value);
        },
    },
    form: {
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
    (v) => !!v || "El campo es requerido",
    //solo números y 8 dígitos
    (v) => /^[0-9]{8}$/.test(v) || "No es un DNI válido",
];

const rulesRUC = [
    (v) => !!v || "El campo es requerido",
    //solo números y 11 dígitos
    (v) => /^[0-9]{11}$/.test(v) || "No es un RUC válido",
];

const isInputValid = computed(() => {
    const rules =
        props.searchIn === "RENIEC"
            ? rulesDNI
            : props.searchIn === "SUNAT"
            ? rulesRUC
            : [];
    return rules.every((rule) => rule(value.value) === true);
});

const loading = ref(false);
const snackbar = ref(false);

const search = async () => {
    loading.value = true;
    if (props.searchIn === "RENIEC") {
        const response = await _searchReniec(value.value);
        if (response === null) {
            snackbar.value = true;
            loading.value = false;
            return;
        }
        props.form[`${props.keyName}`] = response.name;
        // props.form[`${props.keyPaternalSurname}`] = response.paternal_surname;

        emit("onSearch", response);
    } else if (props.searchIn === "SUNAT") {
        const response = await _searchSunat(value.value);
        if (response === null) {
            snackbar.value = true;
            loading.value = false;
            return;
        }
        emit("onSearch", response);
    }
    loading.value = false;
};
</script>
