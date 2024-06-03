<template>
    <AdminLayout>
        <v-card>
            <v-toolbar>
               <v-toolbar-title>
                Proyecto 1
               </v-toolbar-title>
               <v-spacer></v-spacer>

               <v-btn density="comfortable" icon="mdi-car-lifted-pickup" color="blue"  class="me-2" variant="tonal" ></v-btn>
               <v-btn density="comfortable" icon="mdi-pencil" class="me-2" variant="tonal"></v-btn>
               <v-btn density="comfortable" icon="mdi-delete" variant="tonal" color="red" ></v-btn>
            </v-toolbar>

            <v-table >
                <thead>
                    <tr>
                        <th>Vehiculo </th>
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

const search = ref("");


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

]
</script>
