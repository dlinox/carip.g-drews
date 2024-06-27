export const url = "/seguridad/usuarios";

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
        key: "username",
        label: "Nombre de usuario",
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
        key: "password",
        label: "Contraseña",
        type: "password",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "role",
        label: "Seleccione un rol",
        type: "combobox",
        required: true,
        itemTitle: "name",
        itemValue: "id",
        colMd: 12,
        default: null,
        options:[],
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
