import { defineStore } from "pinia";
import { ref } from "vue";
const useLayoutStore = defineStore("layout", () => {
    const drawer = ref(false);
    const railDrawer = ref(false);

    const setDrawer = (value) => {
        drawer.value = value;
    };

    const setRailDrawer = (value) => {
        railDrawer.value = value;
    };

    return {
        drawer,
        railDrawer,
        setDrawer,
        setRailDrawer,
    };
});

export default useLayoutStore;
