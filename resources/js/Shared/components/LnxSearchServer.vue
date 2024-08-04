<template>
    <v-menu
        v-model="menu"
        transition="slide-y-transition"
        :close-on-content-click="false"
    >
        <template v-slot:activator="{ props }">
            <v-text-field
                v-bind="props"
                :label="label"
                placeholder="Buscar"
                outlined
                clearable
                @click:clear="onClearable"
                v-model="result"
                readonly
                :rules="[
                    required ? (v) => !!v || 'Campo requerido' : () => true,
                ]"
            >
            </v-text-field>
        </template>
        <v-card>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    placeholder="Ingrese su búsqueda"
                    @update:model-value="onSearch"
                    :autofocus="menu"
                    ref="searchRef"
                ></v-text-field>
            </v-card-title>
            <v-divider class="mt-3"></v-divider>
            <v-card-text
                class="pa-0"
                style="max-height: 200px; overflow-y: auto"
            >
                <v-list v-model="list" density="compact">
                    <v-list-item
                        v-for="(item, index) in items"
                        :key="index"
                        :value="index"
                        @click="onSelect(item)"
                    >
                        <v-list-item-title>
                            {{ item[props.itemTitle] }}
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-menu>
</template>
<script setup>
import { ref, computed, nextTick } from "vue";
import { isRequired } from "@/Shared/helpers/validations.helpers.js";
const emit = defineEmits(["update:modelValue"]);
const props = defineProps({
    itemValue: {
        type: String,
        default: "value",
    },
    itemTitle: {
        type: String,
        default: "title",
    },
    label: {
        type: String,
        default: "",
    },
    service: {
        type: Function,
    },

    itemsDefault: {
        type: Array,
        default: () => [],
    },

    required: {
        type: Boolean,
        default: false,
    },

    modelValue: {
        type: Object,
    },
});

const valueResult = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

const menu = ref(false);
const result = ref(null);
const search = ref("");
const searchRef = ref(null);
const list = ref(1);

const items = ref([...props.itemsDefault]);

const onClearable = () => {
    result.value = null;
    valueResult.value = null;
};

const onSearch = async (value) => {
    if (value.length < 3) {
        items.value = [];
        return;
    }
    let item = await props.service(value);
    items.value = item;
    console.log(item);
};

const onSelect = (item) => {
    result.value = item[props.itemTitle];
    menu.value = false;
    valueResult.value = item;
};

const init = () => {
    console.log("init");
    if (props.modelValue) {
        result.value = props.modelValue[props.itemTitle];
    }
};

init();
</script>
