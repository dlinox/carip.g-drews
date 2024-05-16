<template>
    <AdminLayout>
        <v-card>
            <v-tabs v-model="tab" density="comfortable">
                <v-tab value="one">
                    <small>Primer Piso</small>
                </v-tab>
                <v-tab value="two">
                    <small>Segundo Piso</small>
                </v-tab>
                <v-tab value="three">
                    <small>Tercer Piso</small>
                </v-tab>
            </v-tabs>

            <v-container>
                <v-row>
                    <v-col
                        v-for="room in rooms"
                        :key="room.id"
                        cols="12"
                        md="4"
                    >
                        <v-card
                            variant="outlined"
                            class="border border-solid rounded-lg shadow-lg mt-4 "
                            :class="
                                room.status === 'Disponible'
                                    ? 'border-red'
                                    : room.status === 'Ocupada'
                                    ? 'border-error'
                                    : 'border-warning'
                            "
                        >
                            <v-card-title>
                                <h6 class="text-h6">{{ room.name }}</h6>
                            </v-card-title>
                            <v-card-text>
                                <p class="text-caption">
                                    Piso: {{ room.floor }}
                                </p>
                                <p class="text-caption">
                                    Estado: {{ room.status }}
                                </p>
                            </v-card-text>
               
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </AdminLayout>
</template>
<script setup>
import { ref } from "vue";
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";
const tab = ref("one");

const rooms = [
    {
        id: 1,
        name: "Habitación 101",
        floor: 1,
        status: "Disponible",
    },
    {
        id: 2,
        name: "Habitación 102",
        floor: 1,
        status: "Limpieza",
    },
    {
        id: 3,
        name: "Habitación 103",
        floor: 1,
        status: "Disponible",
    },
    {
        id: 4,
        name: "Habitación 201",
        floor: 2,
        status: "Disponible",
    },
    {
        id: 5,
        name: "Habitación 202",
        floor: 2,
        status: "Ocupada",
    },
    {
        id: 6,
        name: "Habitación 203",
        floor: 2,
        status: "Reservada",
    },
    {
        id: 7,
        name: "Habitación 301",
        floor: 3,
        status: "Disponible",
    },
    {
        id: 8,
        name: "Habitación 302",
        floor: 3,
        status: "Ocupada",
    },
    {
        id: 9,
        name: "Habitación 303",
        floor: 3,
        status: "Disponible",
    },
];
</script>
