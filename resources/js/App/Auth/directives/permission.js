// resources/js/App/Auth/directives/permission.js

import { useUserStore } from "@/App/Auth/stores";

export default {
    mounted(el, binding) { // Cambia 'inserted' a 'mounted'
        const { value } = binding;
        const userStore = useUserStore();
        const userPermissions = userStore.permissions;
        
        if (value && value instanceof Array) {
            if (value.length > 0) {
                const permissionRoles = value;
                const hasPermission = userPermissions.some((role) =>
                    permissionRoles.includes(role)
                );

                if (!hasPermission) {
                    el.parentNode && el.parentNode.removeChild(el);
                }
            }
        } else {
            throw new Error(
                `El valor de la directiva 'v-permission' debería ser un Array! Por ejemplo: v-permission="['admin', 'editor']"`
            );
        }
    },
};
