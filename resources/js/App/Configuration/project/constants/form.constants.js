export const url = "/configuracion/proyectos";

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
        key: "isEnabled",
        label: "Activo",
        type: "checkbox",
        required: true,
        colMd: 12,
        default: true,
    },
];
