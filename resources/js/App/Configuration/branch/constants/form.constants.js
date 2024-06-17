
import { ref } from "vue";

export const url = "/branches";

export const idKey = "id";

export const formStructure = ref([
    {
        key: "name",
        label: "Nombre",
        type: "text",
        required: false,
        cols: 12,
        default: "",
    },
    {
        key: "geo_code",
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
        cols: 12,
        default: true,
    },
]);
