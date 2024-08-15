<template>
    <v-container>
        <LnxForm
            :formStructure="formStructure"
            :formErrors="form.errors"
            :loading="form.processing"
            v-model="form"
            @onCancel="$emit('onCancel')"
            @onSumbit="submit"
        >
        </LnxForm>
    </v-container>
</template>

<script setup>
import { ref, watch } from "vue";

import LnxForm from "@/Shared/components/LnxForm.vue";

const emit = defineEmits([
    "onCancel",
    "onSubmit",
    "onSuccess",
    "onSubmit",
    "onUpdated",
]);

const props = defineProps({
    formData: {
        type: Object,
        default: (props) =>
            props.formStructure?.reduce((acc, item) => {
                acc[item.key] = item.default;
                return acc;
            }, {}),
    },
    formStructure: {
        type: Array,
    },
});

const form = ref({ ...props.formData });

watch(
    () => form.value,
    (value) => {
        emit("onUpdated", value);
    },
    {
        deep: true,
    }
);


const submit = async () => {
    emit("onSubmit", form.value);
};
</script>
