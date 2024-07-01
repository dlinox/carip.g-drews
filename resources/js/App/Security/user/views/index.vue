<template>
    <AdminLayout>
        <v-card class="rounded-0">
            <v-toolbar class="bg-primary">
                <LnxDialog title="Nuevo" width="600px">
                    <template v-slot:activator="{ dialog }">
                        <v-btn
                            v-permission="['301']"
                            variant="flat"
                            @click="dialog"
                            prepend-icon="mdi-plus"
                        >
                            Nuevo
                        </v-btn>
                    </template>
                    <template v-slot:content="{ dialog }">
                        <FormCreate
                            :formStructure="formStructure"
                            @onSubmit="store($event, dialog)"
                            @onCancel="dialog"
                        />
                    </template>
                </LnxDialog>

                <v-spacer></v-spacer>

                <v-text-field
                    prepend-inner-icon="mdi-magnify"
                    label="Buscar"
                    class="mb-0 me-3"
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
           

                    <LnxDialog title="Asignar Sedes" width="600px">
                        <template v-slot:activator="{ dialog }">
                            <v-btn
                                icon="mdi-source-branch"
                                size="small"
                                color="black"
                                variant="outlined"
                                class="me-1"
                                @click="dialog"
                                v-permission="['302']"
                            >
                            </v-btn>
                        </template>
                        <template v-slot:content="{ dialog }">
                            <v-list lines="two" dense>
                                <v-list-item
                                    v-for="branch in branches"
                                    :value="branch.id"
                                    :key="branch.id"
                                    color="primary"
                                    :active="item.branches.includes(branch.id)"
                                    @click="
                                        item.branches.includes(branch.id)
                                            ? disableBranch(branch, item)
                                            : assignBranch(branch, item)
                                    "
                                >
                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action start>
                                            <v-switch
                                                inset
                                                class="ms-3"
                                                color="primary"
                                                :model-value="isActive"
                                            ></v-switch>
                                        </v-list-item-action>
                                    </template>

                                    <v-list-item-title>
                                        {{ branch.name }}
                                    </v-list-item-title>

                                    <v-list-item-subtitle>
                                        {{ branch.location.location }}
                                    </v-list-item-subtitle>
                                </v-list-item>
                            </v-list>
                        </template>
                    </LnxDialog>

                    <v-btn
                        icon="mdi-folder-network-outline"
                        size="small"
                        color="black"
                        variant="outlined"
                        class="me-1"
                        v-permission="['302']"
                    >
                    </v-btn>

                    <v-btn
                        icon="mdi-pencil"
                        size="small"
                        color="black"
                        variant="outlined"
                        link
                        v-permission="['302']"
                    >
                    </v-btn>
                </template>
            </v-data-table-server>
        </v-card>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";

import { onMounted, ref } from "vue";

import {
    _items,
    _profilesByType,
    _store,
    _assignBranch,
    _disableBranch,
} from "@/App/Security/user/services";

import FormCreate from "@/App/Security/user/components/FormCreate.vue";
import LnxDialog from "@/Shared/components/LnxDialog.vue";

import { formInit } from "@/App/Security/user/forms";

import { itemsResponse } from "@/Shared/constants";

import { useLayoutStore } from "@/Shared/stores";

const props = defineProps({
    title: String,
    roles: Array,
    profileTypes: Array,
    branches: Array,
});

const layoutStore = useLayoutStore();

const formStructure = ref([]);

const items = ref({ ...itemsResponse });

const search = ref("");

const loading = ref(true);

const store = async (data, dialog) => {
    await _store(data);
    dialog();
    loadItems({});
};

const assignBranch = async (branch, user) => {
    await _assignBranch({
        branch_id: branch.id,
        user_id: user.id,
    });
    loadItems({});
};

const disableBranch = async (branch, user) => {
    await _disableBranch({
        branch_id: branch.id,
        user_id: user.id,
    });
    loadItems({});
};

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

const onUpdateType = async (type) => {
    const profiles = await _profilesByType(type);
    formStructure.value[1].options = profiles;
};

const init = async () => {
    layoutStore.title = props.title;
    formStructure.value = formInit({
        roles: props.roles,
        profileTypes: props.profileTypes,
        onUpdateType: onUpdateType,
    });
};

onMounted(() => {
    init();
});
</script>
