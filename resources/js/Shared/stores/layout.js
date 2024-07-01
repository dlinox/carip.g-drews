import { defineStore } from "pinia";
import { ref } from "vue";
const useLayoutStore = defineStore("layout", () => {
    const drawer = ref(true);
    const railDrawer = ref(false);
    const title = ref("Dashboard");

    const setDrawer = (value) => {
        drawer.value = value;
    };

    const menuOpen = ref([]);
    const menuActive = ref(null);

    const setRailDrawer = (value) => {
        railDrawer.value = value;
    };

    return {
        drawer,
        railDrawer,
        setDrawer,
        setRailDrawer,
        menuOpen,
        menuActive,
        title,
    };
});

export default useLayoutStore;
