<template>
    <AdminLayout>
        <v-toolbar class="bg-primary">
            <v-tabs v-model="tab" color="white">
                <v-tab :value="1">Tareo Diario</v-tab>
                <v-tab :value="2">Resumen</v-tab>
            </v-tabs>
        </v-toolbar>

        <template v-if="tab === 1">
            <v-row no-gutters>
                <v-col cols="12" md="5" lg="4">
                    <v-date-picker
                        width="100%"
                        class="rounded-0"
                        title="Selecciona una fecha"
                        v-model="date"
                        :min="project.start_date"
                        :max="today"
                        color="primary"
                        @update:model-value="getTimesheet"
                    >
                    </v-date-picker>
                </v-col>
                <v-col cols="12" md="7" lg="8">
                    <v-toolbar class="w-100" color="primary">
                        <v-toolbar-title>
                            Tareo
                            <br />
                            <small class="text-wrap">
                                {{
                                    date.toLocaleDateString("es-ES", {
                                        year: "numeric",
                                        month: "numeric",
                                        day: "numeric",
                                    })
                                }}
                            </small>
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="dark"
                            variant="outlined"
                            @click="saveTimeSheet"
                        >
                            Guardar
                        </v-btn>
                    </v-toolbar>
                    <v-card class="rounded-0">
                        <v-overlay
                            v-model="loading"
                            class="align-center justify-center"
                            contained
                        >
                            <v-progress-circular
                                indeterminate
                                color="primary"
                            ></v-progress-circular>
                        </v-overlay>
                        <v-table>
                            <thead>
                                <tr>
                                    <th class="column-sticky">
                                        Vehículo / Operador
                                    </th>
                                    <th>Marcar Asistencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, index) in vehicles"
                                    :key="index"
                                >
                                    <td class="column-sticky">
                                        <v-list-item>
                                            <v-list-item-title>
                                                <small class="font-weight-bold">
                                                    {{ item.vehicle_name }}
                                                    /
                                                    {{
                                                        item.operator_name
                                                            ? item.operator_name
                                                            : "Sin operador"
                                                    }}
                                                </small>
                                            </v-list-item-title>
                                            <v-list-item-subtitle>
                                                <small>
                                                    {{ item.supplier_name }}
                                                </small>
                                            </v-list-item-subtitle>
                                        </v-list-item>
                                    </td>
                                    <td>
                                        <v-select
                                            v-model="item.type"
                                            :items="items"
                                            item-text="title"
                                            item-value="value"
                                            dense
                                            outlined
                                            class="rounded-0"
                                        ></v-select>
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>
                    </v-card>
                </v-col>
            </v-row>
        </template>
        <template v-if="tab === 2">
            <v-toolbar class="bg-primary">
                <v-toolbar-title>
                    <small> Resumen mensual</small>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="month"
                    style="max-width: 210px"
                    class="mx-3"
                    type="month"
                    @update:model-value="getTimesheetMonth"
                ></v-text-field>
            </v-toolbar>

            <v-table>
                <thead>
                    <tr>
                        <th class="column-sticky">Vehículo / Operador</th>
                        <th
                            class="column-day"
                            v-for="(day, index) in timesheet[0]?.types"
                            :key="index"
                        >
                            {{ index + 1 }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in timesheet" :key="index">
                        <td class="column-sticky">
                            <v-list-item>
                                <v-list-item-title>
                                    <small class="font-weight-bold">
                                        {{ item.vehicle_name }}
                                        /
                                        {{
                                            item.operator_name
                                                ? item.operator_name
                                                : "Sin operador"
                                        }}
                                    </small>
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    <small>
                                        {{ item.supplier_name }}
                                    </small>
                                </v-list-item-subtitle>
                            </v-list-item>
                        </td>
                        <th
                            class="column-day"
                            v-for="(day, index) in item.types"
                            :key="index"
                        >
                        <v-chip class="rounded-sm">

                            {{ day ?? "-" }}
                        </v-chip>
                        </th>
                    </tr>
                </tbody>
            </v-table>
        </template>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";
import { useLayoutStore } from "@/Shared/stores";

import {
    _vehiclesForTimeSheet,
    _storeTimeSheet,
    _timeSheetByMonth,
} from "@/App/Project/services";

import { ref } from "vue";

const props = defineProps({
    title: String,
    today: String,
    todayJs: String,
    project: Object,
});

const tab = ref(1);

const month = ref(new Date().toISOString().split("T")[0].slice(0, 7));

const items = [
    { value: "T", title: "Trabajado" },
    { value: "N", title: "No trabajado" },
    { value: "I", title: "Falta injustificada" },
    { value: "P", title: "Permiso" },
    { value: "M", title: "Mantenimiento" },
    { value: "E", title: "Caso de emergencia" },
];

const date = ref(new Date(props.today));
const layoutStore = useLayoutStore();

const vehicles = ref([]);

const timesheet = ref([]);
const getTimesheetMonth = async () => {
    timesheet.value = await _timeSheetByMonth(props.project.id, month.value);
};
const loading = ref(false);

const getTimesheet = async (event) => {
    loading.value = true;
    vehicles.value = await _vehiclesForTimeSheet(
        props.project.id,
        new Date(event).toISOString().split("T")[0]
    );
    loading.value = false;
};

const saveTimeSheet = async () => {
    let data = vehicles.value.map((item) => {
        return {
            operator_id: item.operator_id,
            vehicle_id: item.vehicle_id,
            type: item.type,
            project_id: props.project.id,
            register_at: new Date(date.value).toISOString().split("T")[0],
        };
    });
    await _storeTimeSheet(data);
};

const init = async () => {
    layoutStore.title = props.title;
    await getTimesheet(date.value);
    await getTimesheetMonth();
};

init();
</script>

<style scoped>
.column-sticky {
    min-width: 300px;
    position: sticky;
    top: 0;
    left: 0;
    background-color: white;
    z-index: 1;
}
.column-day {
    width: 50px;
}
</style>
