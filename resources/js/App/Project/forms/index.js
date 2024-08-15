import { _searchLocation } from "@/Shared/services";
import { _vehiclesBySupplier } from "@/App/Project/services";

export const formInit = ({ companies = [] }) => {
    return [
        {
            key: "company_id",
            label: "Empresa",
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
            label: "Nombre",
            type: "text",
            required: true,
            colMd: 12,
        },
        {
            key: "description",
            label: "Descripción",
            type: "textarea",
            required: true,
            colMd: 12,
        },
        {
            key: "start_date",
            label: "Fecha de inicio",
            type: "date",
            required: true,
            colMd: 6,
        },
        {
            key: "end_date",
            label: "Fecha de fin",
            type: "date",
            required: true,
            colMd: 6,
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

        {
            key: "is_enabled",
            label: "Activo",
            type: "checkbox",
            required: false,
            colMd: 6,
            default: true,
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

        //fecha de fin
        {
            key: "end_date",
            label: "Fecha de fin",
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
