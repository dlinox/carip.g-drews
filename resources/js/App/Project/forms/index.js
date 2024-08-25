import { _searchLocation } from "@/Shared/services";
import { _vehiclesBySupplier } from "@/App/Project/services";

export const formInit = ({ companies = [] }) => {
    return [
        {
            key: "company_id",
            label: "Empresa responsable",
            type: "combobox",
            options: companies,
            required: true,
            itemTitle: "name",
            itemValue: "id",
            cols: 12,
            default: null,
        },
        {
            key: "name",
            label: "Nombre del proyecto",
            type: "text",
            required: true,
            colMd: 12,
        },
        {
            key: "description",
            label: "Descripción del proyecto",
            type: "textarea",
            required: true,
            colMd: 12,
        },
        {
            key: "start_date",
            label: "Fecha de inicio",
            type: "date",
            required: true,
            colMd: 12,
        },

        {
            key: "location",
            label: "Ubicación",
            type: "search-server",
            default: [],
            required: true,
            itemValue: "code",
            itemTitle: "location",
            service: _searchLocation,
        },
    ];
};

export const formAssignSupervisorInit = ({ supervisors = [] }) => {
    return [
        {
            key: "supervisor_id",
            label: "Supervisor",
            type: "combobox",
            options: supervisors,
            required: true,
            itemTitle: "name",
            itemValue: "id",
            cols: 12,
            default: null,
        },
    ];
};

export const formAssignManagerInit = ({ managers = [] }) => {
    return [
        {
            key: "worker_id",
            label: "Trabajador",
            type: "combobox",
            options: managers,
            required: true,
            itemTitle: "name",
            itemValue: "id",
            cols: 12,
            default: null,
        },
    ];
};

export const formAssignVehicleInit = ({ suppliers = [], vehicles = [] }) => {
    return [
        //proveedor
        {
            key: "supplier_id",
            label: "Proveedor",
            type: "combobox",
            options: suppliers,
            required: true,
            itemTitle: "name",
            itemValue: "id",
            cols: 12,
            default: null,
            onUpdate: () => {},
        },
        {
            key: "vehicle_id",
            label: "Vehículo",
            type: "combobox",
            options: vehicles,
            required: true,
            itemTitle: "name",
            itemValue: "id",
            cols: 12,
            default: null,
            onUpdate: () => {},
        },
        //fecha de inicio
        {
            key: "start_date",
            label: "Fecha de inicio",
            type: "date",
            required: true,
            default: null,
            colMd: 6,
        },
        {
            key: "vehicle_price",
            label: "Precio por día",
            type: "text",
            required: true,
            default: null,
            colMd: 6,
        },
    ];
};

export const formAssignOperatorInit = ({ operators = [] }) => {
    return [
        {
            key: "operator_id",
            label: "Operador",
            type: "combobox",
            options: operators,
            required: true,
            itemTitle: "name",
            itemValue: "id",
            cols: 12,
            default: null,
        },
        {
            key: "start_date",
            label: "Fecha de inicio",
            type: "date",
            required: true,
            default: Date.now(),
            colMd: 6,
        },
        {
            key: "operator_salary",
            label: "Salario por día",
            type: "text",
            required: true,
            default: 0,
            colMd: 6,
        },
    ];
};
