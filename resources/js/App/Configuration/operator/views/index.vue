<template>
    <AdminLayout>
        <v-card>
            <v-toolbar>
                <LnxDialog title="Nuevo" width="500px">
                    <template v-slot:activator="{ dialog }">
                        <v-btn
                            variant="tonal"
                            @click="dialog"
                            prepend-icon="mdi-plus"
                        >
                            Agregar
                        </v-btn>
                    </template>
                    <template v-slot:content="{ dialog }">
                        <FormCreate
                            :formStructure="[
                                (formStructure[0].options = branches),
                                ...formStructure,
                            ]"
                            @onSubmit="store($event, dialog)"
                            @onCancel="dialog"
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
                item-value="id"
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
                    <LnxDialog title="Editar" width="500px">
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
                                :formStructure="[
                                    (formStructure[0].options = branches),
                                    ...formStructure,
                                ]"
                                :formData="{
                                    ...item,
                                }"
                                @onCancel="dialog"
                                @onSubmit="update($event, dialog)"
                            />
                        </template>
                    </LnxDialog>
                </template>
            </v-data-table-server>
        </v-card>
    </AdminLayout>
</template>
<script setup>
import { ref } from "vue";
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";
import FormCreate from "@/App/Configuration/operator/components/FormCreate.vue";
import { _items, _store, _update } from "@/App/Configuration/operator/services";
import { itemsResponse } from "@/Shared/constants";
import LnxDialog from "@/Shared/components/LnxDialog.vue";

import {
    url,
    idKey,
    formStructure,
} from "@/App/Configuration/operator/constants/form.constants";

const props = defineProps({
    title: String,
    branches: Array,
});

const search = ref("");

const loading = ref(true);

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

const store = async (data, dialog) => {
    data.processing = true;

    let response = await _store(data, url);
    if (response) {
        loadItems({
            page: 1,
            itemsPerPage: 10,
            sortBy: [],
        });
        dialog();
    }

    data.processing = false;
};

const update = async (data, dialog) => {
    data.processing = true;
    let response = await _update(data, url + "/" + data[`${idKey}`]);
    if (response) {
        loadItems({
            page: 1,
            itemsPerPage: 10,
            sortBy: [],
        });
        dialog();
    }

    data.processing = false;
};
</script>
