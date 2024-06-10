export const url = "/vehicles";

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
        key: "plate",
        label: "Placa",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "brand",
        label: "Marca",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "model",
        label: "Modelo",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "color",
        label: "Color",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "type",
        label: "Tipo",
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
        default: false,
        colMd: 12,
    },
];
