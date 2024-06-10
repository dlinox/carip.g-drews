export const url = "/companies";

export const idKey = "id";

export const formStructure = [
    {
        key: "ruc",
        label: "Ruc",
        type: "text",
        required: true,
        cols: 12,
        colMd: 4,
        default: "",
    },
    {
        key: "name",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        colMd: 8,
        default: "",
    },
    {
        key: "social",
        label: "Social",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "address",
        label: "Dirección",
        type: "text",
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
        colMd: 4,
        default: "",
    },
    {
        key: "email",
        label: "Email",
        type: "text",
        required: true,
        cols: 12,
        colMd: 4,
        default: "",
    },
    {
        key: "ubication",
        label: "Ciudad",
        type: "text",
        required: true,
        cols: 12,
        colMd: 4,
        default: "",
    },
    {
        key: "is_enabled",
        label: "Activo",
        type: "checkbox",
        required: false,
        colMd: 12,
        default: true,
    }
];
