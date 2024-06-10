<template>
    <v-container>
        <LnxForm
            :formStructure="formStructure"
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

const emit = defineEmits(["onCancel", "onSubmit"]);

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

const submit = async () => {
    emit("onSubmit", form.value);
};
</script>
