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
                            <v-card-item v-if="projectManager">
                                <div>
                                    <div class="text-overline mb-1">
                                        Responsable
                                    </div>
                                    <div class="text-h6 mb-1">
                                        {{ projectManager.worker_name }}
                                    </div>
                                    <div class="text-caption">
                                        {{ projectManager.company_name }} -
                                        {{ projectManager.area_name }}
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
                                                assignResponsibleCompany(
                                                    $event,
                                                    dialog
                                                )
                                            "
                                            :formStructure="
                                                formStructureAssignResponsibleCompany
                                            "
                                            @onCancel="dialog"
                                        />
                                    </template>
                                </LnxDialog>
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
                                        {{
                                            projectSupervisor
                                                ? projectSupervisor.name
                                                : "No asignado"
                                        }}
                                    </div>
                                    <div class="text-caption">
                                        Supervisor de los trabajos (operadores)
                                    </div>
                                </div>
                            </v-card-item>

                            <v-card-actions>
                                <LnxDialog
                                    title="Asignar Supervisor"
                                    width="400px"
                                >
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
                                                assignProjectSupervisor(
                                                    $event,
                                                    dialog
                                                )
                                            "
                                            :formStructure="
                                                formStructureAssignProjectSupervisor
                                            "
                                            @onCancel="dialog"
                                        />
                                    </template>
                                </LnxDialog>
                            </v-card-actions>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-card variant="tonal" class="mx-auto">
                            <v-card-item>
                                <div>
                                    <div class="text-overline mb-1">
                                        {{
                                            assignedVehicles.length > 0
                                                ? assignedVehicles.length +
                                                  " Vehiculos"
                                                : "No hay vehículos asignados"
                                        }}
                                    </div>
                                    <div class="text-h6 mb-1">
                                        Vehiculos Asignados
                                    </div>
                                    <div class="text-caption">
                                        Vehiculos asignados al proyecto
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
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in assignedVehicles" :key="item.id">
                        <td>{{ item.vehicle }}</td>
                        <td>{{ item.operator }}</td>
                        <td>{{ item.supplier_name }}</td>

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

import { ref, watch } from "vue";

import {
    _vehicles,
    _operators,
    _itemsAssignedVehicles,
    _assignVehicle,
    _assignResponsibleCompany,
    _companies,
    _responsibleByCompany,
    _projectManager,
    _supervisoryOperators,
    _assignProjectSupervisor,
    _projectSupervisor,
} from "@/App/Project/services";

import {
    url,
    idKey,
    formStructureAssignVehicle,
    formStructureAssignProjectSupervisor,
    formStructureAssignResponsibleCompany,
} from "@/App/Project/constants/form.constants";

import FormCreate from "@/App/Project/components/FormCreate.vue";

import LnxDialog from "@/Shared/components/LnxDialog.vue";

const props = defineProps({
    project: Object,
});

const projectSupervisor = ref(null);

const operators = ref([]);
const supervisoryOperators = ref([]);
const vehicles = ref([]);

const companies = ref([]);
const workers = ref([]);

const projectManager = ref(null);

const assignedVehicles = ref([]);

const getCompanies = async () => {
    companies.value = await _companies();
    formStructureAssignResponsibleCompany.value[0].options = companies.value;
    formStructureAssignResponsibleCompany.value[1].options = workers.value;
    formStructureAssignResponsibleCompany.value[0].onUpdate = (value) =>
        getResponsibleByCompany(value);
};

const getResponsibleByCompany = async (idCompany) => {
    console.log(idCompany);
    workers.value = await _responsibleByCompany(idCompany);
    formStructureAssignResponsibleCompany.value[1].options = workers.value;
};

const getProjectSupervisor = async (projectId) => {
    projectSupervisor.value = await _projectSupervisor(projectId);
};

const itemsAssignedVehicles = async () => {
    assignedVehicles.value = await _itemsAssignedVehicles(props.project.id);
};

const assignProjectSupervisor = async (data, dialog) => {
    data.processing = true;
    data.project_id = props.project.id;

    let response = await _assignProjectSupervisor(
        data,
        url + "/assign-project-supervisor"
    );
    if (response) {
        dialog();
        await getProjectSupervisor(props.project.id);
    }
    data.processing = false;
};

const assignVehicle = async (data, dialog) => {
    data.processing = true;
    data.project_id = props.project.id;

    let response = await _assignVehicle(data, url + "/assign-vehicle");
    if (response) {
        dialog();
        await itemsAssignedVehicles();
    }
    data.processing = false;
};

const assignResponsibleCompany = async (data, dialog) => {
    data.processing = true;
    data.project_id = props.project.id;

    let response = await _assignResponsibleCompany(
        data,
        url + "/assign-responsible-company"
    );
    if (response) {
        dialog();

        await getProjectManager(props.project.id);
    }
    data.processing = false;
};

const getProjectManager = async (projectId) => {
    projectManager.value = await _projectManager(projectId);
};

const init = async () => {
    await itemsAssignedVehicles();

    await getCompanies();
    await getProjectSupervisor(props.project.id);

    await getProjectManager(props.project.id);

    operators.value = await _operators();
    vehicles.value = await _vehicles();
    supervisoryOperators.value = await _supervisoryOperators();

    formStructureAssignVehicle[0].options = vehicles.value;
    formStructureAssignVehicle[1].options = operators.value;
    formStructureAssignProjectSupervisor[1].options =
        supervisoryOperators.value;
};

init();
</script>
