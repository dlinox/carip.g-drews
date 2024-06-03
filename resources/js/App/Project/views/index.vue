<template>
    <AdminLayout>
        <v-card>
            <v-toolbar>
                
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

            <v-table >
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" :key="item.id">
                        <td>{{ item.title }}</td>
                        <td>{{ item.description }}</td>
                        <td>
                            <v-btn
                                icon="mdi-eye"
                                size="small"
                                color="primary"
                                variant="tonal"
                                link
                                @click="router.get(url + '/' + item.id)"
                            >
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
               
            </v-table>
        </v-card>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
const search = ref("");

const headers = ref([
    {
        title: "Nombre",
        key: "name",
        align: "center",
    },
    {
        title: "Descripción",
        key: "description",
        align: "center",
    },
    {
        title: "Acciones",
        key: "actions",
        align: "end",
        sortable: false,
    },
]);
const items = [
    {
        id: 1,
        title: "Proyecto 1",
        description: "Descripción del proyecto 1",
    },
];

const url = "/projects";
</script>
