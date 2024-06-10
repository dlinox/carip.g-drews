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
                                    <div class="text-h6 mb-1">Hugo Sanchez</div>
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
                                    <div class="text-h6 mb-1">Juan Sanchez</div>
                                    <div class="text-caption">
                                        Supervisor de los trabajos (operadores )
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
                                <LnxDialog title="Editar" width="500px">
                                    <template v-slot:activator="{ dialog }">
                                        <v-btn
                                            block
                                            color="primary"
                                            variant="tonal"
                                            link
                                            @click="dialog"
                                        >
                                            asignar
                                        </v-btn>
                                    </template>
                                    <template v-slot:content="{ dialog }">
                                        <FormCreate
                                            @onSubmit="
                                                assignVehicle($event, dialog)
                                            "
                                            :formStructure="
                                                formStructureAssignVehicle
                                            "
                                            @onCancel="dialog"
                                        />
                                    </template>
                                </LnxDialog>
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

                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in assignedVehicles" :key="item.id">
                        <td>{{ item.vehicle }}</td>
                        <td>{{ item.operator }}</td>

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

import {
    _vehicles,
    _operators,
    _itemsAssignedVehicles,
    _assignVehicle,
} from "@/App/Project/services";

import {
    url,
    idKey,
    formStructureAssignVehicle,
} from "@/App/Project/constants/form.constants";

import FormCreate from "@/App/Project/components/FormCreate.vue";

import LnxDialog from "@/Shared/components/LnxDialog.vue";

const props = defineProps({
    project: Object,
});

const itemsAssignedVehicles = async () => {
    assignedVehicles.value = await _itemsAssignedVehicles(props.project.id);
    
};

const assignVehicle = async (data, dialog) => {
    data.processing = true;
    data.project_id = props.project.id;

    console.log(data);
    let response = await _assignVehicle(data, url + "/assign-vehicle");
    if (response) {

        dialog();
        await itemsAssignedVehicles();
    }

    data.processing = false;
};

const operators = ref([]);
const vehicles = ref([]);

const assignedVehicles = ref([]);

const init = async () => {

    await itemsAssignedVehicles();
   
    operators.value = await _operators();
    vehicles.value = await _vehicles();

    formStructureAssignVehicle[0].options = vehicles.value;
    formStructureAssignVehicle[1].options = operators.value;
};

init();
// init();
</script>
