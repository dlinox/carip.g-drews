import { ref } from "vue";

export const url = "/projects";

export const idKey = "id";

export const formStructure = [
    {
        key: "name",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "description",
        label: "Descripción",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "is_enabled",
        label: "Activo",
        type: "checkbox",
        required: false,
        default: true,
        colMd: 12,
    },
];

export const formStructureAssignVehicle = [
    {
        key: "vehicle_id",
        label: "Vehículo",
        type: "combobox",
        itemTitle: "name",
        itemValue: "id",
        options: [],
        required: true,
        colMd: 12,
    },
    {
        key: "operator_id",
        label: "Operador",
        type: "combobox",
        itemTitle: "name",
        itemValue: "id",
        options: [],
        required: true,
        colMd: 12,
    },
    {
        key: "project_id",
        label: "Proyecto",
        type: "hidden",
        colMd: 12,
    },
];

export const formStructureAssignResponsibleCompany = ref([
    {
        key: "company_id",
        label: "Empresa",
        type: "combobox",
        itemTitle: "name",
        itemValue: "id",
        onUpdate: () => {},
        clearable: true,
        options: [],
        required: true,
        colMd: 12,
    },
    {
        key: "worker_id",
        label: "Responsable",
        type: "combobox",
        itemTitle: "name",
        itemValue: "id",
        options: [],
        required: true,
        colMd: 12,
    },
    {
        key: "project_id",
        label: "Proyecto",
        type: "hidden",
        colMd: 12,
    },
]);


export const formStructureAssignProjectSupervisor = [
    {
        key: "project_id",
        label: "Proyecto",
        type: "hidden",
        colMd: 12,
    },
    {
        key: "operator_id",
        label: "Operador",
        type: "combobox",
        itemTitle: "name",
        itemValue: "id",
        options: [],
        required: true,
        colMd: 12,
    },
];