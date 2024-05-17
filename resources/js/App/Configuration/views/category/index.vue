<template>
    <AdminLayout>
        <v-card>
            <v-toolbar>
                <v-btn variant="tonal" color="primary" @click="dialog = true">
                    Agregar
                </v-btn>
                <v-spacer></v-spacer>

                <v-text-field
                    prepend-inner-icon="mdi-magnify"
                    label="Buscar"
                    class="mb-0"
                    v-model="search_"
                />
                <v-btn
                    class="ms-2"
                    icon="mdi-filter"
                    variant="tonal"
                    density="comfortable"
                ></v-btn>
            </v-toolbar>

            <v-data-table-server
                v-model:items-per-page="dataTable.itemsPerPage"
                :headers="dataTable.headers"
                :items="dataTable.items"
                :items-length="dataTable.totalItems"
                :loading="loading"
                :search="search_"
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
                        :color="item.status === true ? 'success' : 'error'"
                        dark
                        label
                    >
                        {{ item.status ? "Activo" : "Inactivo" }}
                    </v-chip>
                </template>

                <template v-slot:item.actions="{ item }">
                    <v-btn
                        icon="mdi-plus"
                        size="small"
                        color="primary"
                        variant="tonal"
                        link
                    >
                    </v-btn>

                    <v-btn
                        icon="mdi-pencil"
                        size="small"
                        color="primary"
                        variant="tonal"
                        link
                        class="ms-1"
                    >
                    </v-btn>
                </template>
            </v-data-table-server>
        </v-card>
        <categoryCreate v-model="dialog" :modelTypes="modelTypes">
        </categoryCreate>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";
import { _loadItems } from "@/App/Configuration/services/category.services";
import categoryCreate from "@/App/Configuration/components/categoryCreate.Dialog.vue";

import { ref } from "vue";

const dialog = ref(false);

const dataTable = ref({
    loading: false,
    headers: [],
    items: [],
    totalItems: 0,
    itemsPerPage: 10,
    filters: {
        page: 1,
        search: "",
        sortBy: [],
        perPage: 10,
    },
});

const props = defineProps({
    modelTypes: {
        type: Array,
    },
});

const search_ = ref("");

const loading = ref(true);

const loadItems = async ({ page, itemsPerPage, sortBy }) => {
    loading.value = true;
    let data = {
        page,
        itemsPerPage,
        sortBy,
        search: search_.value,
    };

    dataTable.value = await _loadItems(data);

    loading.value = false;
};
</script>
