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
        return false;
    }
};
