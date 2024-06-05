import axios from "axios";

export const _signIn = async (data) => {
    try {
        const response = await axios.post("/auth/sign-in", data);
        return response.data;
    } catch (error) {
        return error.response.data;
    }
};
