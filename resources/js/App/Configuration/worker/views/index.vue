<template>
    <AdminLayout>
        <v-card>
            <v-toolbar>
                <LnxDialog title="Nuevo" width="500px">
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
        key: "name",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "document",
        label: "Documento",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "email",
        label: "Email",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    }
]);

const url = "/workers";
</script>
