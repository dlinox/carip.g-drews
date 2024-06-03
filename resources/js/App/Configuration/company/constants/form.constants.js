export const url = "/companies";

export const idKey = "id";

export const formStructure = [
    {
        key: "ruc",
        label: "Ruc",
        type: "text",
        required: true,
        cols: 12,
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
        key: "social",
        label: "Social",
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
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "email",
        label: "Email",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "ubication",
        label: "Ubicación",
        type: "text",
        required: true,
        cols: 12,
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
