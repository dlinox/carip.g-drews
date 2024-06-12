<template>
    <AdminLayout>
        <pre>

            {{ userStore.permissions }}
        </pre>
        <v-card>
            <v-toolbar>
                <v-btn variant="tonal" @click="dialog = !dialog">
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
                <template v-slot:item.is_enabled="{ item }">
                    <v-chip
                        :color="item.is_enabled ? 'success' : 'error'"
                        dark
                        label
                    >
                        {{ item.is_enabled ? "Activo" : "Inactivo" }}
                    </v-chip>
                </template>

                <template v-slot:item.actions="{ item }">
                    <v-btn
                        icon="mdi-pencil"
                        size="small"
                        color="primary"
                        variant="tonal"
                        link
                         v-permission="['501']"
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
                    :roles="roles"
                    @onSuccess="
                        (dialog = false),
                            loadItems({ page: 1, itemsPerPage: 10, sortBy: [] })
                    "
                />
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";

import { useUserStore } from "@/App/Auth/stores/";
import { ref } from "vue";

import { _items } from "@/App/Security/user/services/user.services";

import FormCreate from "@/App/Security/user/components/FormCreate.vue";

import {
    url,
    idKey,
    formStructure,
} from "@/App/Security/user/constants/form.constants";

import { itemsResponse } from "@/Shared/constants";



const props = defineProps({
    roles: Array,
});

const userStore = useUserStore();

const items = ref({ ...itemsResponse });

const dialog = ref(false);
const search = ref("");

const loading = ref(true);

const loadItems = async ({ page = 1, itemsPerPage = 10, sortBy = [] }) => {
    console.log(page, itemsPerPage, sortBy);
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
</script>
