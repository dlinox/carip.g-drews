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
                            @onSuccess="
                                loadItems({
                                    page: 1,
                                    itemsPerPage: 10,
                                    sortBy: [],
                                })
                            "
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
                <template v-slot:item.isEnabled="{ item }">
                    <v-chip
                        :color="item.isEnabled ? 'success' : 'error'"
                        dark
                        label
                    >
                        {{ item.isEnabled ? "Activo" : "Inactivo" }}
                    </v-chip>
                </template>

                <template v-slot:item.actions="{ item }">

                    <LnxDialog title="Nuevo" width="500px">
                        <template v-slot:activator="{ dialog }">
                            <v-btn
                                icon="mdi-pencil"
                                size="small"
                                color="primary"
                                variant="tonal"
                                link
                                @click="dialog"
                            >
                            </v-btn>
                        </template>
                        <template v-slot:content="{ dialog }">
                            <FormCreate
                                @onCancel="dialog"
                                :formStructure="formStructure"
                                :url="url + '/' + item[`${idKey}`]"
                                :edit="true"
                                :formData="item"
                                @onSuccess="
                                    loadItems({
                                        page: 1,
                                        itemsPerPage: 10,
                                        sortBy: [],
                                    })
                                "
                            />
                        </template>
                    </LnxDialog>
                </template>
            </v-data-table-server>
        </v-card>
      
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";
import { ref } from "vue";

import { _items } from "@/App/Configuration/area/services";

import { itemsResponse } from "@/Shared/constants";

import FormCreate from "@/App/Configuration/area/components/FormCreate.vue";

import {
    url,
    idKey,
    formStructure,
} from "@/App/Configuration/area/constants/form.constants";
import LnxDialog from "@/Shared/components/LnxDialog.vue";

const items = ref({ ...itemsResponse });

const search = ref("");

const loading = ref(true);

const loadItems = async ({ page = 1, itemsPerPage = 10, sortBy = [] }) => {
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
