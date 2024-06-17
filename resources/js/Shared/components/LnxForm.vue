<template>
    <v-form ref="formRef" @submit.prevent="submit">
        <v-row>
            <v-col
                v-for="(field, index) in formStructure"
                :key="index"
                :cols="field.cols ?? 12"
                :md="field.colMd"
            >
                <slot :name="'field.' + field.key">
                    <template
                        v-if="
                            field.type === 'text' ||
                            field.type === 'password' ||
                            field.type === 'date' ||
                            field.type === 'email'
                        "
                    >
                        <v-text-field
                            v-model="form[`${field.key}`]"
                            :label="field.label"
                            :rules="field.required ? [isRequired] : []"
                            :error-messages="
                                form.errors ? form.errors[`${field.key}`] : null
                            "
                            :disabled="field.disabled"
                            :readonly="field.readonly"
                            :clearable="field.clearable"
                            :autocomplete="
                                field.type === 'password' ? 'off' : 'on'
                            "
                            :type="field.type"
                        ></v-text-field>
                    </template>
                    <template v-else-if="field.type === 'select'">
                        <v-select
                            v-model="form[`${field.key}`]"
                            :items="field.options"
                            :label="field.label"
                            :rules="field.required ? [isRequired] : []"
                        ></v-select>
                    </template>
                    <template v-else-if="field.type === 'number'">
                        <v-text-field
                            v-model="form[`${field.key}`]"
                            :label="field.label"
                            :rules="field.required ? [isRequired] : []"
                            type="number"
                        ></v-text-field>
                    </template>
                    <template v-else-if="field.type === 'textarea'">
                        <v-textarea
                            v-model="form[`${field.key}`]"
                            :label="field.label"
                            :rules="field.required ? [isRequired] : []"
                            :error-messages="
                                form.errors ? form.errors[`${field.key}`] : null
                            "
                        ></v-textarea>
                    </template>

                    <template v-else-if="field.type === 'checkbox'">
                        <v-checkbox
                            v-model="form[`${field.key}`]"
                            :label="field.label"
                            :rules="field.required ? [isRequired] : []"
                            :error-messages="
                                form.errors ? form.errors[`${field.key}`] : null
                            "
                        ></v-checkbox>
                    </template>

                    <template v-else-if="field.type === 'autocomplete'">
                        <v-autocomplete
                            v-model="form[`${field.key}`]"
                            :items="field.options"
                            :label="field.label"
                            :item-title="field.itemTitle"
                            :item-value="field.itemValue"
                            :rules="field.required ? [isRequired] : []"
                            :clearable="field.clearable ?? false"
                            :error-messages="
                                form.errors ? form.errors[`${field.key}`] : null
                            "
                            :no-data-text="search && search.length > 3 ? 'No se encontraron resultados' : 'Escribe al menos 3 caracteres para buscar'"
                            v-model:search="search"
                            @update:search="field.onSearch"
                            @update:modelValue="field.onUpdate"
                        />
                    </template>

                    <template v-else-if="field.type === 'combobox'">
                        <v-autocomplete
                            v-model="form[`${field.key}`]"
                            :items="field.options"
                            :label="field.label"
                            :item-title="field.itemTitle"
                            :item-value="field.itemValue"
                            :rules="field.required ? [isRequired] : []"
                            :clearable="field.clearable ?? false"
                            :error-messages="
                                form.errors ? form.errors[`${field.key}`] : null
                            "
                            @update:modelValue="field.onUpdate"
                        />
                    </template>
                </slot>
            </v-col>
            <v-col cols="12" class="d-flex flex-row-reverse">
                <slot name="actions">
                    <v-btn type="submit" class="ms-2" :loading="loading">
                        Guardar
                    </v-btn>
                    <v-btn
                        variant="tonal"
                        color="red"
                        @click="$emit('onCancel')"
                    >
                        cancelar
                    </v-btn>
                </slot>
            </v-col>
        </v-row>
    </v-form>
</template>
<script setup>
import { computed, ref } from "vue";
import { isRequired } from "@/Shared/helpers/validations.helpers.js";

const props = defineProps({
    formStructure: {
        type: Array,
        default: [],
    },
    formErrors: {
        type: Object,
        default: {},
    },
    loading: {
        type: Boolean,
        default: false,
    },
    modelValue: Object,
});

const emit = defineEmits(["update:modelValue", "onCancel", "onSumbit"]);

const formRef = ref(null);

const search = ref("");


const form = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

const submit = async () => {
    const { valid } = await formRef.value.validate();
    if (!valid) return;
    emit("onSumbit");
};
</script>
