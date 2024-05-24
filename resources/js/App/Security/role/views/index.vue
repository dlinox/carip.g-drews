<template>
    <AdminLayout>
        <v-card>
            <v-toolbar>
                <v-btn variant="tonal" link @click="dialog = !dialog">
                    Agregar
                </v-btn>
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

            <v-data-table-server
                v-model:items-per-page="items.itemsPerPage"
                :headers="items.headers"
                :items="items.items"
                :items-length="items.totalItems"
                :loading="loading"
                :search="search"
                multi-sort
                :items-per-page-options="[1, 5, 10, 25, 50]"
                item-value="name"
                @update:options="loadItems"
                no-data-text="No se encontraron registros"
                items-per-page-text="Registros por página"
                loading-text="Cargando registros"
            >
                <template v-slot:item.status="{ item }">
                    <v-chip
                        :color="item.status ? 'success' : 'error'"
                        dark
                        label
                    >
                        {{ item.status ? "Activo" : "Inactivo" }}
                    </v-chip>
                </template>

                <template v-slot:item.actions="{ item }">
                    <v-btn
                        icon="mdi-pencil"
                        size="small"
                        color="primary"
                        variant="tonal"
                        link
                    >
                    </v-btn>
                </template>
            </v-data-table-server>
        </v-card>
        <v-dialog v-model="dialog" max-width="500px">
            <v-card class="rounded-lg">
                <v-card-title class="headline"> Titulo </v-card-title>
                <v-divider></v-divider>
                <FormCreate
                    @on-cancel="dialog"
                    :formStructure="formStructure"
                    :url="url"

                />
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>
<script setup>
import { ref } from "vue";
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";

import FormCreate from "@/App/Security/role/components/FormCreate.vue";

import { _items } from "@/App/Security/role/services/role.services";
import { itemsResponse } from "@/Shared/constants";

import {
    url,
    idKey,
    formStructure,
} from "@/App/Security/role/constants/form.constants";

const search = ref("");
const loading = ref(true);

const dialog = ref(false);

const items = ref({ ...itemsResponse });

const loadItems = async ({ page, itemsPerPage, sortBy }) => {
    loading.value = true;
    let data = {
        page,
        itemsPerPage,
        sortBy,
        search: search.value,
    };

    items.value = await _items(data);

    loading.value = false;
};

const init = async () => {
    //    items.value = await _items();
};

init();
</script>
