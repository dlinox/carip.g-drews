import axios from "axios";
export const _dataTable = async (data) => {
    try {
        let response = await axios.post("/seguridad/usuarios/lista", data);
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
