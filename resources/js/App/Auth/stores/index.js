import { defineStore } from "pinia";
import { ref } from "vue";

export const useUserStore = defineStore("user", () => {
    // user: ref({});

    const permissions = ref([]);

    const setUser = (user) => {
        // user.value = user;
        permissions.value = user.permissions;
    };

    return {
        setUser,
        permissions,
    };
});
