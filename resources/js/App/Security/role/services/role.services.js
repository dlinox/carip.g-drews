import axios from "axios";
export const _items = async (data) => {
    try {
        let response = await axios.post("/roles/items", data);

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
        console.log(data);
        // let response = await axios.post(url, data);
        // return response.data;
    } catch (error) {
        return error.response.data;
    }
};

export const _update = async (data, url) => {
    try {
        console.log(data);
        // let response = await axios.put(url, data);
        // return response.data;
    } catch (error) {
        return error.response.data;
    }
};
