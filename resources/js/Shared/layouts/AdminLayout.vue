<template>
    <v-app app>
        <v-navigation-drawer app color="grey-lighten-3" width="70">
            <v-avatar class="d-block mx-auto mt-4 pa-1" tile>
                <img
                    src="https://caripperu.com/img/bg-header/caripperu.png"
                    alt="Caripperu"
                    class="w-100"
                />
            </v-avatar>

            <v-divider class="mx-3 my-5"></v-divider>

            <v-btn
                class="d-block mx-auto mb-1"
                variant="text"
                icon
                v-for="menu in menuApp"
                :key="menu.title"
                @click="
                    menu.childrens.length > 0
                        ? handleMenu(menu)
                        : handleSubMenu(menu)
                "
            >
                <v-tooltip activator="parent" location="end">
                    {{ menu.title }}
                </v-tooltip>
                <v-icon size="24">{{ menu.icon }}</v-icon>
            </v-btn>
        </v-navigation-drawer>

        <v-navigation-drawer app width="200" v-model="layoutStore.drawer">
            <h6 class="text-h6 ma-4">
                {{ currentMenu ? currentMenu.title : "Dashboard" }}
            </h6>

            <v-list nav>
                <v-list-item
                    v-for="child in currentMenu ? currentMenu.childrens : []"
                    :key="child.title"
                    prepend-icon="mdi-minus"
                    density="compact"
                    link
                    @click="handleSubMenu(child)"
                >
                    <v-list-item-title>{{ child.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app flat class="bg-grey-lighten-3">
            <v-spacer></v-spacer>
            <v-btn
                icon="mdi-bell"
                class="me-2"
                color="info"
                variant="tonal"
                density="comfortable"
            />
            <v-btn icon="mdi-account" variant="tonal" density="comfortable" />
        </v-app-bar>

        <v-main>
            <v-toolbar app flat class="bg-grey-lighten-3">
                <v-toolbar-title class="text-small">
                    {{ currentMenu ? currentMenu.title : "Dashboard" }}
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-breadcrumbs :items="menuStore.breadCrumbs">
                    <template v-slot:title="{ item }">
                        <small>
                            {{ item.title }}
                        </small>
                    </template>
                </v-breadcrumbs>
            </v-toolbar>

            <slot />
        </v-main>

        <v-footer app>
            <small class="w-100 text-end">
                CopyRight {{ new Date().getFullYear() }}- All Rights Reserved |
                Developed by Linox <v-icon size="12">mdi-heart</v-icon>
            </small>
        </v-footer>
    </v-app>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import { ref, computed } from "vue";

import { useMenuStore, useLayoutStore } from "@/Shared/stores";

const menuStore = useMenuStore();
const layoutStore = useLayoutStore();

const currentMenu = computed(() => menuStore.current);

const menuApp = [
    {
        title: "Dashboard",
        icon: "mdi-view-dashboard-outline",
        link: "/dashboard",
        childrens: false,
    },
    {
        title: "Proyectos",
        icon: "mdi-boom-gate-up-outline",
        link: "/projects",
        childrens: false,
    },

    {
        title: "Configuraciones",
        icon: "mdi-cog-outline",
        link: "/",
        childrens: [
            {
                title: "Empresas",
                icon: "mdi-cog",
                link: "/companies",
                childrens: false,
            },

            {
                title: "Carros",
                icon: "mdi-cog",
                link: "/cars",
                childrens: false,
            },
        ],
    },
    {
        title: "Seguridad",
        icon: "mdi-security",
        link: "/seguridad",
        childrens: [
            {
                title: "Usuarios",
                icon: "mdi-account",
                link: "/users",
                childrens: false,
            },
            {
                title: "Roles",
                icon: "mdi-account-group",
                link: "/roles",
                childrens: false,
            },
        ],
    },
];

const items = [
    {
        title: "Dashboard",
        disabled: false,
        href: "breadcrumbs_dashboard",
    },
    {
        title: "Link 1",
        disabled: false,
        href: "breadcrumbs_link_1",
    },
    {
        title: "Link 2",
        disabled: true,
        href: "breadcrumbs_link_2",
    },
];

const handleMenu = (menu) => {
    menuStore.setCurrent(menu);

    if (menu.childrens.length > 0) {
        layoutStore.setDrawer(true);
    } else {
        layoutStore.setDrawer(false);
    }
};

const breadCrumbs = ref([]);

const handleSubMenu = (menu) => {
    if (menu.childrens.length > 0) {
        layoutStore.setDrawer(true);
    } else {
        layoutStore.setDrawer(false);
    }
    router.get(menu.link);
    // layoutStore.setBreadCrumbs(menu);

    breadCrumbs.value = [];

    breadCrumbs.value.push({
        title: "Dashboard",
        disabled: false,
        href: "",
    });

    breadCrumbs.value.push({
        title: menuStore.current.title,
        disabled: true,
        href: "breadcrumbs_link_1",
    });

    breadCrumbs.value.push({
        title: menu.title,
        disabled: true,
        href: "breadcrumbs_link_2",
    });

    menuStore.setBreadCrumbs(breadCrumbs.value);
};
</script>
