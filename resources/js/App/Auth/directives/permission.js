import { useUserStore } from "@/App/Auth/stores";

export default {
    inserted(el, binding) {
        const { value } = binding;
        const userStore = useUserStore();
        const userPermissions = userStore.permissions;
        
        console.log("userPermissions", userPermissions);

        if (value && value instanceof Array) {
            if (value.length > 0) {
                const permissionRoles = value;
                console.log("permissionRoles", permissionRoles);
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
