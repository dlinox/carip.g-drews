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
import { ref } from "vue";

import LnxForm from "@/Shared/components/LnxForm.vue";

const emit = defineEmits(["onCancel", "onSubmit", "onSuccess", "onSubmit"]);

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
    edit: {
        type: Boolean,
        default: false,
    },
    url: String,
});

const form = ref({ ...props.formData });

const submit = async () => {
    emit("onSubmit", form.value);

    // if (props.edit) form.put(props.url, option);
    // else form.post(props.url, option);
};
</script>
