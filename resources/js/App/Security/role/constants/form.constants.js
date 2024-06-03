export const url = "/seguridad/roles";

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
        key: "routeRedirect",
        label: "Ruta base",
        type: "text",
        required: true,
        colMd: 12,
        default: "",
    },
    {
        key: "isEnabled",
        label: "Activo",
        type: "checkbox",
        required: false,
        colMd: 12,
        default: true,
    }
];
