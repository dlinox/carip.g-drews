import axios from "axios";

import { useToast } from "vue-toastification";

const toast = useToast();

///items/vehicles/{projectId}
export const _vehicles = async (projectId) => {
    try {
        let response = await axios.get("/projects/items/vehicles/" + projectId);
        return response.data;
    } catch (error) {
        toast.error(
            "Error al cargar los listados de vehículos asignados al proyecto"
        );
        return false;
    }
};

export const _suppliers = async () => {
    try {
        let response = await axios.get("/projects/suppliers");
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _vehiclesBySupplier = async (supplierId) => {
    try {
        let response = await axios.get(
            "/projects/vehicles/supplier/" + supplierId
        );
        return response.data;
    } catch (error) {
        return false;
    }
};

export const _assignVehicle = async (data) => {
    try {
        let response = await axios.post("/projects/assign/vehicle", data);
        toast.success(response.data.message);
        return response.data;
    } catch (error) {
        toast.error("Error al asignar el vehículo");
        return false;
    }
};

export const _unassignVehicle = async (data) => {
    try {
        let response = await axios.post("/projects/unassign/vehicle", data);
        toast.success(response.data.message);
        return response.data;
    } catch (error) {
        toast.error("Error al desasignar el vehículo");
        return false;
    }
};

///time-sheets post
export const _storeTimeSheet = async (data) => {
    try {
        let response = await axios.post("/projects/time-sheets", data);
        toast.success(response.data.message);
        return response.data;
    } catch (error) {
        toast.error("Error al guardar la hoja de tiempo");
        return false;
    }
};

//vehicles-for-time-sheet/{projectId}
export const _vehiclesForTimeSheet = async (projectId, date) => {
    try {
        let response = await axios.get(
            "/projects/vehicles-for-time-sheet/" + projectId + "/" + date
        );
        return response.data;
    } catch (error) {
        return false;
    }
};

//timeSheetByMonth
export const _timeSheetByMonth = async (projectId, month) => {
    try {
        let response = await axios.get(
            "/projects/time-sheet-by-month/" + projectId + "/" + month
        );
        return response.data;
    } catch (error) {
        return false;
    }
};
