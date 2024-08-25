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

                    <th class="text-left">Opereradores</th>
                    <th class="text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(vehicle, index) in vehicles" :key="index">
                    <td style="min-width: 300px">
                        <v-list-item>
                            <v-list-item-title>
                                {{ vehicle.vehicle_name }}
                            </v-list-item-title>
                            <v-list-item-subtitle class="mt-1">
                                S/. {{ vehicle.vehicle_price }} por día
                            </v-list-item-subtitle>
                            <v-list-item-subtitle class="mt-1">
                                <v-chip tile>
                                    <v-icon class="me-2"> mdi-calendar </v-icon>
                                    {{ vehicle.start_date }} |
                                    {{ vehicle.end_date ?? "Actualidad" }}
                                </v-chip>
                            </v-list-item-subtitle>
                        </v-list-item>
                    </td>
                    <td style="max-width: 200px">
                        {{ vehicle.supplier_name }}
                    </td>

                    <td style="min-width: 320px">
                        <v-list-item
                            v-for="operator in vehicle.operators"
                            :key="operator.operator_id"
                        >
                            <template v-slot:prepend>
                                <v-btn
                                    color="red"
                                    variant="tonal"
                                    class="me-2"
                                    density="comfortable"
                                    :disabled="operator.end_date !== null"
                                    icon
                                >
                                    <v-icon> mdi-minus-circle </v-icon>
                                    <LnxConfirm
                                        title="¿Está seguro de finalizar la asignación del operador?"
                                        text="El operador podrá ser asignado en este u otro proyecto."
                                        @onConfirm="
                                            removeOperator(
                                                vehicle.vehicle_id,
                                                operator.id
                                            )
                                        "
                                    />
                                </v-btn>
                            </template>

                            <v-list-item-title>
                                <small>
                                    {{ operator.name }}
                                </small>
                            </v-list-item-title>
                            <v-list-item-subtitle class="my-1">
                                S/. {{ operator.operator_salary }} por día
                            </v-list-item-subtitle>
                            <v-list-item-subtitle>
                                <small>
                                    <v-chip tile>
                                        <v-icon class="me-2">
                                            mdi-calendar
                                        </v-icon>
                                        {{ operator.start_date }}
                                        |
                                        {{ operator.end_date ?? "Actualidad" }}
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
                                    color="black"
                                    variant="tonal"
                                    @click="dialog"
                                    :disabled="vehicle.end_date !== null"
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

                        <v-btn
                            color="red"
                            variant="tonal"
                            class="ms-2"
                            :disabled="vehicle.end_date !== null"
                            icon
                        >
                            <v-icon> mdi-minus-circle </v-icon>
                            <LnxConfirm
                                title="¿Está seguro de finalizar la asignación del vehículo?"
                                text="Al finalizar la asignación, el vehículo podrá ser asignado en otro proyecto, pero no en este. Además, los operadores asignados a este vehículo serán desasignados con la fecha de fin actual."
                                @onConfirm="unassignVehicle(vehicle.vehicle_id)"
                            />
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
    _unassignVehicle,
    _vehicles,
    _operators,
    _assignOperator,
    _unassignOperator,
} from "@/App/Project/services";
import {
    formAssignVehicleInit,
    formAssignOperatorInit,
} from "@/App/Project/forms";
import LnxConfirm from "@/Shared/components/LnxConfirm.vue";

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

const unassignVehicle = async (vehicleId) => {
    let response = await _unassignVehicle({
        project_id: props.project.id,
        vehicle_id: vehicleId,
    });
    if (response) {
        await init();
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

const removeOperator = async (vehicleId, operatorId) => {
    let response = await _unassignOperator({
        project_id: props.project.id,
        vehicle_id: vehicleId,
        operator_id: operatorId,
    });
    if (response) {
        await init();
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
