import axios from "axios";

export const  _searchLocation = async (search) => {
    try {
        const response = await axios.get(`/service/locations/${search}`);
        return response.data;
    } catch (error) {
        throw error;
    }
};


