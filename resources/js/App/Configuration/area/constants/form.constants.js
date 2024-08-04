export const url = "/areas";

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
        key: "is_enabled",
        label: "Activo",
        type: "checkbox",
        required: false,
        default: true,
        cols: 12,
    }
];
