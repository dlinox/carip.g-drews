import axios from "axios";

import { useToast } from "vue-toastification";

const toast = useToast();

export const _items = async (data) => {
    try {
        let response = await axios.post("/projects/items", data);
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

export const _assignVehicles = async (data, url) => {
    try {
        let response = await axios.post(url, data);
        toast.success(response.data.message);
        return true;
    } catch (error) {
        toast.error(error.response.data.message);
        return false;
    }
};

export const _vehicles = async () => {
    try {
        let response = await axios.get("/projects/items/vehicles");
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _operators = async () => {
    try {
        let response = await axios.get("/projects/items/operators");
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _itemsAssignedVehicles = async (idProject) => {
    try {
        let response = await axios.get(
            "/projects/assigned-vehicles/" + idProject
        );
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _assignVehicle = async (data, url) => {
    try {
        let response = await axios.post(url, data);
        toast.success(response.data.message);
        return true;
    } catch (error) {
        toast.error(error.response.data.message);
        return false;
    }
};

export const _companies = async () => {
    try {
        let response = await axios.get("/projects/items/companies");
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _responsibleByCompany = async (idCompany) => {
    try {
        let response = await axios.get(
            "/projects/items/responsible-by-company/" + idCompany
        );
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _assignResponsibleCompany = async (data, url) => {
    try {
        let response = await axios.post(url, data);
        toast.success(response.data.message);
        return true;
    } catch (error) {
        toast.error(error.response.data.message);
        return false;
    }
};

export const _projectManager = async (projectId) => {
    try {
        let response = await axios.get(
            "/projects/project-manager/" + projectId
        );
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _assignProjectSupervisor = async (data, url) => {
    try {
        let response = await axios.post(url, data);
        toast.success(response.data.message);
        return true;
    } catch (error) {
        toast.error(error.response.data.message);
        return false;
    }
};

export const _projectSupervisor = async (projectId) => {
    try {
        let response = await axios.get(
            "/projects/project-supervisor/" + projectId
        );
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _supervisoryOperators = async () => {
    try {
        let response = await axios.get("/projects/items/supervisory-operators");
        return response.data;
    } catch (error) {
        return false;
    }
};

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
