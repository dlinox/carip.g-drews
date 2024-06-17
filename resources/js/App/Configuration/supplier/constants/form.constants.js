
import { ref } from "vue";

export const url = "/suppliers";

export const idKey = "id";

export const formStructure = ref([
    {
        key: "ruc",
        label: "RUC",
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
        label: "Razon Social",
        type: "text",
        required: true,
        cols: 12,
        colMd: 12,
        default: "",
    },
    {
        key: "address",
        label: "Dirección",
        type: "text",
        required: true,
        cols: 12,
        colMd: 8,
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

        default: "",
    },
    {
        key: "ubication",
        label: "Ubicación",
        type: "autocomplete",
        required: true,
        cols: 12,
        itemValue: "code",
        itemTitle: "location",
        default: null,
        options: [],
        onSearch: () => {},
    },
    {
        key: "is_enabled",
        label: "Activo",
        type: "checkbox",
        required: false,
        colMd: 12,
        default: true,
    }
]);


