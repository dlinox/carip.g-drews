<template>
    <AdminLayout>
        <v-row no-gutters>
            <v-col cols="12" md="4" lg="3">
                <v-date-picker
                    width="100%"
                    class="rounded-0"
                    title="Selecciona una fecha"
                    v-model="date"
                    :max="today"
                    color="primary"
                    @update:model-value="
                        (event) => {
                            console.log(event);
                        }
                    "
                >
                </v-date-picker>
            </v-col>
            <v-col cols="12" md="8" lg="9">
                <v-toolbar class="w-100" color="primary">
                    <v-toolbar-title>
                        {{ date.toDateString() }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn color="white" variant="tonal">Guardar</v-btn>
                </v-toolbar>
                <v-table>
                    <thead>
                        <tr>
                            <th class="column-sticky">Vehículo / Operador</th>
                            <th v-for="day in 30" style="min-width: 100px">
                                Dia {{ day }} <br />
                                2021-09-01
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="column-sticky">Vehículo 1</td>
                            <td v-for="day in 30" style="min-width: 100px">
                                <v-menu>
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            color="primary"
                                            v-bind="props"
                                            icon
                                            density="compact"
                                            variant="outlined"
                                        >
                                            <small> F </small>
                                        </v-btn>
                                    </template>
                                    <v-list>
                                        <v-list-item
                                            v-for="(item, index) in items"
                                            :key="index"
                                            :value="index"
                                        >
                                            <v-list-item-title>
                                                {{ item.title }}
                                            </v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </v-col>
        </v-row>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";
import { useLayoutStore } from "@/Shared/stores";

import { ref } from "vue";

const props = defineProps({
    title: String,
    today: String,
    todayJs: String,
});

const selected = ref(null);

/*
   Dias trabajados           T
            Dias no trabajados        N 			
            faltas injustificadas	  I 		
            Permisos			      P 
            Mantenimiento		      M     	
            Casos de emergencia		  E   
*/

const items = [
    { value: "T", title: "Trabajado" },
    { value: "N", title: "No trabajado" },
    { value: "I", title: "Falta injustificada" },
    { value: "P", title: "Permiso" },
    { value: "M", title: "Mantenimiento" },
    { value: "E", title: "Caso de emergencia" },
];

const date = ref(new Date(props.todayJs));
const layoutStore = useLayoutStore();

const init = async () => {
    layoutStore.title = props.title;
};

init();
</script>

<style scoped>
.column-sticky {
    min-width: 200px;
    position: sticky;
    top: 0;
    left: 0;
    background-color: white;
    z-index: 1;
}
</style>
