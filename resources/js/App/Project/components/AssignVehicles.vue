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
                    <th class="text-left">Opereradores</th>
                    <th class="text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(vehicle, index) in vehicles" :key="index">
                    <td>{{ vehicle.vehicle_name }}</td>
                    <td>{{ vehicle.supplier_name }}</td>
                    <td>{{ vehicle.vehicle_price }}</td>
                    <td>{{ vehicle.start_date }}</td>
                    <td>{{ vehicle.end_date }}</td>
                    <td>
                        <v-list-item
                            v-for="operator in vehicle.operators"
                            :key="operator.operator_id"
                        >
                            <v-list-item-title>
                                <small>
                                    {{ operator.name }}
                                </small>
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                <small>
                                    {{ operator.operator_salary }} |
                                    <v-chip tile>
                                        {{
                                            operator.is_enabled
                                                ? "Activo"
                                                : "Finalizado"
                                        }}
                                    </v-chip>
                                </small>
                            </v-list-item-subtitle>
                        </v-list-item>
                    </td>
                    <td>
                        <LnxDialog title="Asignar Operador" width="700px">
                            <template v-slot:activator="{ dialog }">
                                <v-btn
                                    icon="mdi-account-network"
                                    color="primary"
                                    @click="dialog"
                                >
                                </v-btn>
                            </template>
                            <template v-slot:content="{ dialog }">
                                <FormCreate
                                    @onSubmit="
                                        assignOperator(
                                            $event,
                                            dialog,
                                            vehicle.vehicle_id
                                        )
                                    "
                                    :formStructure="formAssignOperator"
                                    @onCancel="dialog"
                                    @onUpdated="onUpdate($event)"
                                >
                                </FormCreate>
                            </template>
                        </LnxDialog>
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
    _operators,
    _assignOperator,
} from "@/App/Project/services";
import {
    formAssignVehicleInit,
    formAssignOperatorInit,
} from "@/App/Project/forms";

const props = defineProps({
    project: Object,
    suppliers: Array,
});

const formAssignVehicle = ref([]);
const formAssignOperator = ref([]);

const vehicles = ref([]);
const operators = ref([]);

const assignVehicle = async (data, dialog) => {
    data.project_id = props.project.id;
    let response = await _assignVehicle(data);
    if (response) {
        await init();
        dialog();
    }
};

const assignOperator = async (data, dialog, vehicleId) => {
    data.project_id = props.project.id;
    data.vehicle_id = vehicleId;
    let response = await _assignOperator(data);
    if (response) {
        await init();
        dialog();
    }
};

const onUpdate = async (data) => {
    if (data.supplier_id) {
        formAssignVehicle.value = await formAssignVehicleInit({
            suppliers: props.suppliers,
            vehicles: await _vehiclesBySupplier(data.supplier_id),
        });
    }
};

const init = async () => {
    formAssignVehicle.value = await formAssignVehicleInit({
        suppliers: props.suppliers,
    });

    operators.value = await _operators();

    formAssignOperator.value = await formAssignOperatorInit({
        operators: operators.value,
    });

    vehicles.value = await _vehicles(props.project.id);
};

init();
</script>
