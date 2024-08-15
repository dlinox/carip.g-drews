<template>
    <v-card class="rounded-0" elevation="0">
        <v-toolbar title="Asignar Vehículos">
            <v-spacer></v-spacer>

            <LnxDialog title="Asignar Supervisor" width="700px">
                <template v-slot:activator="{ dialog }">
                    <v-btn
                        prepend-icon="mdi-plus"
                        color="primary"
                        @click="dialog"
                    >
                        asignar
                    </v-btn>
                </template>
                <template v-slot:content="{ dialog }">
                    <FormCreate
                        @onSubmit="assignVehicle($event, dialog)"
                        :formStructure="formAssignVehicle"
                        @onCancel="dialog"
                        @onUpdated="onUpdate($event)"
                    >
                    </FormCreate>
                </template>
            </LnxDialog>
        </v-toolbar>

        <v-table>
            <thead>
                <tr>
                    <th class="text-left">Vehículo</th>
                    <th class="text-left">Proveedor</th>
                    <th class="text-left">Precio</th>

                    <th class="text-left">Fecha de inicio</th>
                    <th class="text-left">Fecha de fin</th>
                    <th class="text-left">Opererador</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="vehicle in vehicles" :key="vehicle.id">
                    <td>{{ vehicle.vehicle_name }}</td>
                    <td>{{ vehicle.supplier_name }}</td>
                    <td>{{ vehicle.vehicle_price }}</td>
                    <td>{{ vehicle.start_date }}</td>
                    <td>{{ vehicle.end_date }}</td>
                    <td>
                        <v-btn variant="tonal" prepend-icon="mdi-plus-circle">
                            Asignar Operador
                        </v-btn>
                    </td>
                </tr>
            </tbody>
        </v-table>
    </v-card>
</template>
<script setup>
import { ref } from "vue";
import FormCreate from "@/App/Project/components/FormCreate.vue";
import LnxDialog from "@/Shared/components/LnxDialog.vue";
import {
    _vehiclesBySupplier,
    _assignVehicle,
    _vehicles,
} from "@/App/Project/services";
import { formAssignVehicleInit } from "@/App/Project/forms";
const props = defineProps({
    project: Object,
    suppliers: Array,
});

const formAssignVehicle = ref([]);
const vehicles = ref([]);

const assignVehicle = async (data, dialog) => {
    data.project_id = props.project.id;
    let response = await _assignVehicle(data);
    if (response) {
        console.log(data);
        dialog();
    }
};

const onUpdate = async (data) => {
    formAssignVehicle.value = await formAssignVehicleInit({
        suppliers: props.suppliers,
        vehicles: await _vehiclesBySupplier(data.supplier_id),
    });
};

const init = async () => {
    formAssignVehicle.value = await formAssignVehicleInit({
        suppliers: props.suppliers,
    });

    vehicles.value = await _vehicles(props.project.id);
};

init();
</script>
