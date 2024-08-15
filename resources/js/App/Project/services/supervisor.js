import axios from "axios";

import { useToast } from "vue-toastification";

const toast = useToast();

export const _supervisor = async (projectId) => {
    try {
        let response = await axios.get("/projects/supervisor/" + projectId);

        return isEmptyObject(response.data) ? null : response.data;
    } catch (error) {
        return false;
    }
};

export const _supervisors = async () => {
    try {
        let response = await axios.get("/projects/items/supervisors");
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _assignSupervisor = async (data) => {
    try {
        let response = await axios.post("/projects/assign/supervisor", data);
        toast.success(response.data.message);
        return true;
    } catch (error) {
        toast.error(error.response.data.message);
        return false;
    }
};

export const _unassignSupervisor = async (data) => {
    try {
        let response = await axios.post("/projects/unassign/supervisor", data);
        toast.success(response.data.message);
        return true;
    } catch (error) {
        toast.error(error.response.data.message);
        return false;
    }
};

const isEmptyObject = (obj) => {
    return Object.keys(obj).length === 0 && obj.constructor === Object;
};
