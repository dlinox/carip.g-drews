//operators

import axios from "axios";

import { useToast } from "vue-toastification";

const toast = useToast();

export const _operators = async () => {
    try {
        let response = await axios.get("/projects/free/operators");
        console.log(response.data);
        return response.data;
    } catch (error) {
        toast.error("Error al cargar los operadores");
        return false;
    }
};

//assign/operator
export const _assignOperator = async (data) => {
    try {
        let response = await axios.post("/projects/assign/operator", data);
        toast.success(response.data.message);
        return response.data;
    } catch (error) {
        toast.error("Error al asignar el operador");
        return false;
    }
};
