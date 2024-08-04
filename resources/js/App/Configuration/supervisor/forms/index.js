import { _searchLocation } from "@/Shared/services";
export const formInit = ({ typeDocuments = [], defaultGeoCode = [] }) => {
    return [
        {
            key: "document_type",
            label: "Tipo de documento",
            type: "combobox",
            required: true,
            itemTitle: "name",
            itemValue: "id",
            options: typeDocuments,
            cols: 12,
            colMd: 6,
            default: "001",
        },
        {
            key: "document_number",
            label: "Número de documento",
            type: "document-dni",
            required: true,
            searchIn: "reniec",
            cols: 12,
            colMd: 6,
            default: "",
        },

        {
            key: "name",
            label: "Nombre",
            type: "text",
            required: true,
            cols: 12,
            default: "",
        },
        {
            key: "paternal_surname",
            label: "Apellido paterno",
            type: "text",
            required: true,
            cols: 12,
            colMd: 6,
            default: "",
        },
        {
            key: "maternal_surname",
            label: "Apellido materno",
            type: "text",
            required: true,
            cols: 12,
            colMd: 6,
            default: "",
        },
        {
            key: "birthdate",
            label: "Fecha de nacimiento",
            type: "date",
            required: true,
            cols: 12,
            colMd: 6,
            default: "",
        },
        {
            key: "phone",
            label: "Teléfono",
            type: "text",
            required: true,
            cols: 12,
            colMd: 6,
            default: "",
        },
        {
            key: "email",
            label: "Correo electrónico",
            type: "email",
            required: true,
            cols: 12,
            colMd: 6,
            default: "",
        },
        {
            key: "gender",
            label: "Género",
            type: "combobox",
            required: true,
            options: [
                { value: "M", title: "Masculino" },
                { value: "F", title: "Femenino" },
            ],
            cols: 12,
            colMd: 6,
            default: null,
        },
        {
            key: "birth_place",
            label: "Lugar de nacimiento",
            type: "search-server",
            default: defaultGeoCode,
            required: true,
            itemValue: "code",
            itemTitle: "location",
            service: _searchLocation,
            cols: 12,
            colMd: 6,
        },
        {
            key: "residence_place",
            label: "Lugar de residencia",
            type: "search-server",
            default: defaultGeoCode,
            required: true,
            itemValue: "code",
            itemTitle: "location",
            service: _searchLocation,
            cols: 12,
            colMd: 6,
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
