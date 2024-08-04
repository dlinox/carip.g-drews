import axios from "axios";

import { useToast } from "vue-toastification";

const toast = useToast();

export const _items = async (data) => {
    try {
        let response = await axios.post("/supervisors/items", data);

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

        toast.error('Error al cargar los items');
        return false;
    }
};


export const _store = async (data) => {
    try {
        let response = await axios.post("/supervisors", data);
        toast.success('Item creado con éxito');
        return response.data;
    } catch (error) {
        toast.error('Error al crear el item');
        return false;
    }
}

export const _update = async (data) => {
    try {
        let response = await axios.put(`/supervisors/${data.id}`, data);
        toast.success('Item actualizado con éxito');
        return response.data;
    } catch (error) {
        toast.error('Error al actualizar el item');
        return false;
    }
}