
import axios from "axios";

import { useToast } from "vue-toastification";

const toast = useToast();

export const _items = async (data) => {
    try {
        let response = await axios.post("/projects/items", data);
        // return response.data;
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

export const _store = async (data, url) => {
    try {
        let response = await axios.post(url, data);
        toast.success(response.data.message);
        return true;
    } catch (error) {
        toast.error(error.response.data.message);
        return false;
    }
};

export const _update = async (data, url) => {
    try {
        let response = await axios.put(url, data);
        toast.success(response.data.message);
        return true;
    } catch (error) {
        toast.error(error.response.data.message);
        return false;
    }
};