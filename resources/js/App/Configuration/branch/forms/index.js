import { _searchLocation } from "@/Shared/services";
export const formInit = ({ defaultGeoCode = [] }) => {
    return [
        {
            key: "name",
            label: "Nombre",
            type: "text",
            required: true,
            cols: 12,
            default: "",
        },
        {
            key: "location",
            label: "Ubicación",
            type: "search-server",
            default: defaultGeoCode,
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
            cols: 12,
            default: true,
        },
    ];
};
