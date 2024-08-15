import axios from "axios";

import { useToast } from "vue-toastification";

const toast = useToast();

export const _companymManagers = async (companyId) => {
    try {
        let response = await axios.get(
            "/projects/items/company-managers/" + companyId
        );
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _managers = async (projectId) => {
    try {
        let response = await axios.get("/projects/managers/" + projectId);

        return response.data;
    } catch (error) {
        return false;
    }
};

export const _assignManager = async (data) => {
    try {
        let response = await axios.post("/projects/assign/manager", data);
        toast.success(response.data.message);
        return true;
    } catch (error) {
        toast.error(error.response.data.message);
        return false;
    }
};

export const _unassignManager = async (data) => {
    try {
        let response = await axios.post("/projects/unassign/manager", data);
        toast.success(response.data.message);
        return true;
    } catch (error) {
        toast.error(error.response.data.message);
        return false;
    }
};
