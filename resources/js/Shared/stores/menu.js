import { defineStore } from "pinia";
import { ref } from "vue";

const useMenuStore = defineStore("menu", () => {


    const breadCrumbs = ref([]);
    
    const menu = ref([]);
    const current = ref(null);
    

    const setCurrent = (item) => {
        // obtener la ruta actual
        const path = window.location.pathname;
        console.log(path);
        current.value = item;
    };

    const setBreadCrumbs = (value) => {
    
        breadCrumbs.value = value;
    }

    return {
        menu,
        current,
        setCurrent,
        breadCrumbs,
        setBreadCrumbs,
    };
});

export default useMenuStore;
