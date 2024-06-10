<template>
    <AdminLayout>
        <v-card>
            <v-toolbar>
                <v-toolbar-title>
                    {{ project.name }}
                </v-toolbar-title>
                <v-spacer></v-spacer>

                <v-btn
                    density="comfortable"
                    icon="mdi-pencil"
                    class="me-2"
                    variant="tonal"
                ></v-btn>
                <v-btn
                    density="comfortable"
                    icon="mdi-delete"
                    variant="tonal"
                    color="red"
                ></v-btn>
            </v-toolbar>

            <v-container>
                <v-row justify="center">
                    <v-col cols="12" md="4">
                        <v-card variant="tonal" class="mx-auto">
                            <v-card-item>
                                <div>
                                    <div class="text-overline mb-1">
                                        Responsable
                                    </div>
                                    <div class="text-h6 mb-1">
                                        Hugo Sanchez
                                    </div>
                                    <div class="text-caption">
                                        Responsable de la empresa contratista
                                    </div>
                                </div>
                            </v-card-item>

                            <v-card-actions>
                                <v-btn> Gestionar </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-card variant="tonal" class="mx-auto">
                            <v-card-item>
                                <div>
                                    <div class="text-overline mb-1">
                                        Supervisor
                                    </div>
                                    <div class="text-h6 mb-1">
                                        Juan Sanchez
                                    </div>
                                    <div class="text-caption">
                                        Supervisor de los trabajos (operadores  )
                                    </div>
                                </div>
                            </v-card-item>

                            <v-card-actions>
                                <v-btn> Gestionar </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-card variant="tonal" class="mx-auto">
                            <v-card-item>
                                <div>
                                    <div class="text-overline mb-1">
                                        25 Vehiculo
                                    </div>
                                    <div class="text-h6 mb-1">
                                        Vehiculos Asignados
                                    </div>
                                    <div class="text-caption">
                                        Vehiculos asignados a la empresa
                                    </div>
                                </div>
                            </v-card-item>

                            <v-card-actions>
                                <v-btn> Gestionar </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>

            <v-table>
                <thead>
                    <tr>
                        <th>Vehiculo</th>
                        <th>responsale</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" :key="item.id">
                        <td>{{ item.car }}</td>
                        <td>{{ item.responsable }}</td>
                        <td>{{ item.proveedor }}</td>

                        <td>
                            <v-btn
                                icon="mdi-pencil"
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

const props = defineProps({
    project: Object,
});

const items = [
    {
        id: 1,
        car: "Toyota SDF-454, 2021 4x4",
        responsable: "Juan",
        proveedor: "Toyota",
    },
    {
        id: 2,
        car: "Toyota DX-454, 2021 4x4",
        responsable: "Juan",
        proveedor: "Toyota",
    },
    {
        id: 3,
        car: "Toyota DX-454, 2021 4x4",
        responsable: "Juan",
        proveedor: "Toyota",
    },
];
</script>
