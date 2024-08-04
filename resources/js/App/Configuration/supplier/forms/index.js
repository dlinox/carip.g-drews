import { _searchLocation } from "@/Shared/services";
export const formInit = ({}) => {
    return [
        {
            key: "document_number",
            label: "Número de documento (RUC)",
            type: "document-ruc",
            required: true,
            searchIn: "reniec",
            cols: 12,
            default: "",
        },
        {
            //razon social
            key: "name",
            label: "Razón social",
            type: "text",
            required: true,
            cols: 12,
            default: "",
        },
        {
            key: "address",
            label: "Dirección",
            type: "text",
            required: true,
            cols: 12,
            default: "",
        },
        {
            key: "phone",
            label: "Teléfono",
            type: "text",
            required: false,
            cols: 12,
            default: "",
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
