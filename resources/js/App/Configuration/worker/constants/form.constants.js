export const url = "/workers";

export const idKey = "id";

export const formStructure = [
    {
        key: "area_id",
        label: "Área",
        type: "combobox",
        required: true,
        itemTitle: "name",
        itemValue: "id",
        options: [],
        cols: 12,
        default: "",
    },
    {
        key: "name",
        label: "Nombre",
        type: "text",
        required: false,
        cols: 12,
        default: "",
    },
    {
        key: "document",
        label: "Documento",
        type: "text",
        required: false,
        cols: 12,
        colMd: 6,
        default: "",
    },

    {
        key: "phone",
        label: "Teléfono",
        type: "text",
        required: false,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "email",
        label: "Email",
        type: "text",
        required: false,
        cols: 12,
        default: "",
    },
   
    {
        key: "is_enabled",
        label: "Activo",
        type: "checkbox",
        required: false,
        colMd: 12,
        default: true,
    },
];
