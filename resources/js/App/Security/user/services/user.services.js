import axios from "axios";

import { useToast } from "vue-toastification";

const toast = useToast();

export const _items = async (data) => {
    try {
        let response = await axios.post("/users/items", data);

        return {
            loading: false,
            headers: response.data.headers,
            items: response.data.items.data,
            totalItems: response.data.items.total,
            itemsPerPage: response.data.items.per_page,
            filters: {
                search: response.data.filters.search,
                sortBy: response.data.filters.sortBy,
                perPage: response.data.filters.perPage,
            },
        };
    } catch (error) {
        return false;
    }
};

export const _store = async (data) => {
    try {
        let response = await axios.post("/users", data);
        toast.success("Item creado con éxito");
        return response.data;
    } catch (error) {
        toast.error("Error al crear el item");
        return false;
    }
};

export const _profilesByType = async (type) => {
    try {
        let response = await axios.get(`/users/${type}/profiles`);
        return response.data;
    } catch (error) {
        toast.error("Error al cargar los tipos de perfil");
        return false;
    }
};

export const _assignBranch = async (data) => {
    try {
        let response = await axios.post("/users/assign-branch", data);
        toast.success("Sucursal asignada con éxito");
        return response.data;
    } catch (error) {
        toast.error("Error al asignar la sucursal");
        return false;
    }
};

export const _disableBranch = async (data) => {
    try {
        let response = await axios.post("/users/disable-branch", data);
        toast.success("Sucursal deshabilitada con éxito");
        return response.data;
    } catch (error) {
        toast.error("Error al deshabilitar la sucursal");
        return false;
    }
};

export const _searchProjects = async (term, id) => {
    try {
        let response = await axios.get(
            "/users/search-projects/" + term + "/" + id
        );
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _assignProject = async (data) => {
    try {
        let response = await axios.post("/users/assign-project", data);
        toast.success("Proyecto asignado con éxito");
        return response.data;
    } catch (error) {
        toast.error("Error al asignar el proyecto");
        return false;
    }
}

export const _disableProject = async (data) => {
    try {
        let response = await axios.post("/users/disable-project", data);
        toast.success("Proyecto deshabilitado con éxito");
        return response.data;
    } catch (error) {
        toast.error("Error al deshabilitar el proyecto");
        return false;
    }
}
