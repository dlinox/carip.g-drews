<template>
    <AdminLayout>
        <v-card class="rounded-0">
            <v-toolbar class="bg-primary">
                <LnxDialog title="Nuevo" width="700px">
                    <template v-slot:activator="{ dialog }">
                        <v-btn
                            variant="outlined"
                            color="dark"
                            @click="dialog"
                            prepend-icon="mdi-plus"
                        >
                            Agregar
                        </v-btn>
                    </template>
                    <template v-slot:content="{ dialog }">
                        <FormCreate
                            @onCancel="dialog"
                            :formStructure="formStructure"
                            @onSubmit="store($event, dialog)"
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
                <template v-slot:item.location="{ item }">
                    {{ item.location["location"] }}
                </template>
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
                        class="me-2"
                        color="black"
                        variant="tonal"
                        prepend-icon="mdi-car-pickup"
                        @click="
                            router.get(
                                url + '/' + item[`${idKey}`] + '/vehicles'
                            )
                        "
                    >
                        Vehiculos
                    </v-btn>
                    <LnxDialog title="Editar" width="500px">
                        <template v-slot:activator="{ dialog }">
                            <v-btn
                                icon="mdi-pencil"
                                density="comfortable"
                                color="primary"
                                variant="tonal"
                                link
                                @click="dialog"
                            >
                            </v-btn>
                        </template>
                        <template v-slot:content="{ dialog }">
                            <FormCreate
                                @onSubmit="update($event, dialog)"
                                :formStructure="formStructure"
                                :formData="item"
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
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";

import LnxDialog from "@/Shared/components/LnxDialog.vue";
import { _items, _store, _update } from "@/App/Configuration/supplier/services";

import { itemsResponse } from "@/Shared/constants";

import FormCreate from "@/App/Configuration/supplier/components/FormCreate.vue";

import { formInit } from "@/App/Configuration/supplier/forms";
import { useLayoutStore } from "@/Shared/stores";
import {
    url,
    idKey,
} from "@/App/Configuration/supplier/constants/form.constants";

const props = defineProps({
    title: String,
});

const layoutStore = useLayoutStore();
const items = ref({ ...itemsResponse });

const search = ref("");

const loading = ref(true);

const formStructure = ref([]);

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

const init = async () => {
    layoutStore.title = props.title;
    formStructure.value = formInit({});
};

onMounted(() => {
    init();
});
</script>
