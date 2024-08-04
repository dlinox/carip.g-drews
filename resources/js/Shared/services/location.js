import axios from "axios";

export const _searchLocation = async (search) => {
    try {
        const response = await axios.get(`/service/locations/${search}`);
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const _searchReniec = async (dni) => {
    try {
        const response = await axios.get(`/service/reniec/${dni}`);
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const _searchSunat = async (ruc) => {
    try {
        const response = await axios.get(`/service/sunat/${ruc}`);
        return response.data;
    } catch (error) {
        throw error;
    }
};
