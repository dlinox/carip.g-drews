<template>
    <AdminLayout>
        <v-card>
            <v-toolbar>
                <LnxDialog title="Nuevo" width="800px">
                    <template v-slot:activator="{ dialog }">
                        <v-btn variant="tonal" link @click="dialog">
                            Agregar
                        </v-btn>
                    </template>
                    <template v-slot:content="{ dialog }">
                        <FormCreate
                            @onCancel="dialog"
                            :formStructure="formStructure"
                            :url="url"
                        />
                    </template>
                </LnxDialog>

                <v-spacer></v-spacer>

                <v-text-field
                    prepend-inner-icon="mdi-magnify"
                    label="Buscar"
                    class="mb-0"
                    v-model="search"
                />
                <v-btn
                    class="ms-2"
                    icon="mdi-filter"
                    variant="tonal"
                    density="comfortable"
                ></v-btn>
            </v-toolbar>
        </v-card>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";
import { ref } from "vue";

import LnxDialog from "@/Shared/components/LnxDialog.vue";
import FormCreate from "@/App/Configuration/worker/components/FormCreate.vue";

const search = ref("");

const formStructure = ref([
    {
        key: "plate",
        label: "Placa",
        type: "text",
        required: true,
        colMd: 6,
        default: "",
    },
    {
        key: "model",
        label: "Modelo",
        type: "text",
        required: true,
        colMd: 6,
        default: "",
    },
    {
        key: "year",
        label: "Año",
        type: "text",
        required: true,
        colMd: 6,
        default: "",
    },
    {
        key: "color",
        label: "Color",
        type: "text",
        required: true,
        colMd: 6,
        default: "",
    },

    {
        key: "description",
        label: "Descripción",
        type: "text",
        required: true,
        colMd: 6,
        default: "",
    },
    {
        key: "is_enabled",
        label: "Activo",
        type: "checkbox",
        required: false,
        colMd: 6,
        default: true,
    }
]);

const url = "/workers";
</script>
