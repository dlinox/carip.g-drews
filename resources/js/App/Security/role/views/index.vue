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
                            :formStructure="formStructure"
                            :url="url"
                            @oncancel="dialog"
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

                    <LnxDialog title="Asignar permisos" width="800px">
                        <template v-slot:activator="{ dialog }">
                            <v-btn
                                icon
                                variant="outlined"
                                density="comfortable"
                                class="me-1"
                                color="dark"
                                @click="dialog"
                            >
                                <v-icon
                                    size="x-small"
                                    icon="mdi-security-network"
                                ></v-icon>
                            </v-btn>
                        </template>
                        <template v-slot:content="{ dialog }">
                            <FormPermissions
                                @on-cancel="dialog"
                                @onSuccess="
                                    loadItems({
                                        page: 1,
                                        itemsPerPage: 10,
                                        sortBy: [],
                                    })
                                "
                                :permissions="permissions"
                                :rolPermissions="item.permissions"
                                :url="urlPermisos"
                                :roleId="item.id"
                            />
                        </template>
                    </LnxDialog>
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
                                :formStructure="formStructure"
                                :url="url + '/' + item[`${idKey}`]"
                                :edit="true"
                                :formData="item"
                                @onCancel="dialog"
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
import { ref } from "vue";
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";
import FormCreate from "@/App/Security/role/components/FormCreate.vue";
import FormPermissions from "@/App/Security/role/components/FormPermissions.vue";
import { _items } from "@/App/Security/role/services/role.services";
import { itemsResponse } from "@/Shared/constants";
import LnxDialog from "@/Shared/components/LnxDialog.vue";

import {
    url,
    idKey,
    formStructure,
} from "@/App/Security/role/constants/form.constants";


const props = defineProps({
    permissions: Object,
    rolPermissions: Array,
});

const urlPermisos = "/roles/permissions";

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
</script>
