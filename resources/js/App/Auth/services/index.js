import axios from "axios";

export const _signIn = async (data) => {
    try {
        const response = await axios.post("/auth/sign-in", data);
        return response.data;
    } catch (error) {
        return error.response.data;
    }
};

export const _signOut = async () => {
    try {
        const response = await axios.post("/auth/sign-out");
        return response.data;
    } catch (error) {
        return error.response.data;
    }
};
