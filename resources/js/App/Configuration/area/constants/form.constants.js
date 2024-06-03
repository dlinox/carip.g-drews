export const url = "/configuracion/areas";

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
        label: "Descripcion",
        type: "text",
        required: false,
        cols: 12,   
        default: "",
    },
    {
        key: "isEnabled",
        label: "Activo",
        type: "checkbox",
        required: false,
        default: true,
        colMd: 12,

    }
];
