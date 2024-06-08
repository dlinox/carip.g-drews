<template>
    <v-app app>
        <v-navigation-drawer
            app
            color="grey-lighten-3"
            :rail="layoutStore.railDrawer && layoutStore.menuOpen.length === 0"
            v-model="layoutStore.drawer"
        >
            <v-sheet
                class="d-flex flex-column justify-center align-center pa-1 bg-grey-lighten-2"
                style="height: 60px"
            >
                <img
                    src="https://caripperu.com/img/bg-header/caripperu.png"
                    alt="Caripperu"
                    class="h-100"
                />
            </v-sheet>

            <v-list
                nav
                color="primary"
                :items="listItems"
                density="compact"
                v-model:selected="layoutStore.menuActive"
                v-model:opened="layoutStore.menuOpen"
            >
            </v-list>

            <template #append>
                <v-btn
                    class="mx-auto"
                    :icon="
                        layoutStore.railDrawer
                            ? 'mdi-arrow-expand-right'
                            : 'mdi-arrow-expand-left'
                    "
                    block
                    variant="tonal"
                    rounded="0"
                    @click="layoutStore.setRailDrawer(!layoutStore.railDrawer)"
                >
                </v-btn>
            </template>
        </v-navigation-drawer>

        <v-app-bar app flat class="bg-grey-lighten-3">
            <v-btn icon @click="layoutStore.setDrawer(!layoutStore.drawer)">
                <v-icon>mdi-menu</v-icon>
            </v-btn>
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

const listItems = ref([
    {
        title: "Dashboard",

        props: {
            value: "dashboard",
            prependIcon: "mdi-view-dashboard-outline",
            onclick: () => {
                router.get("/dashboard");
            },
        },
    },
    {
        title: "Proyectos",
        props: {
            value: "projects",
            prependIcon: "mdi-boom-gate-up-outline",
            onclick: () => router.get("/projects"),
        },
    },
    {
        title: "Configuraciones",
        props: {
            value: "config",
            prependIcon: "mdi-cog-outline",
        },
        children: [
            {
                title: "Empresas",
                props: {
                    prependIcon: "mdi-minus",
                    value: "companies",
                    onclick: () => router.get("/companies"),
                },
            },
            {
                title: "Carros",
                props: {
                    prependIcon: "mdi-minus",
                    value: "cars",
                    onclick: () => router.get("/cars"),
                },
            },
        ],
    },

    {
        title: "Seguridad",
        props: {
            value: "security",
            prependIcon: "mdi-security",
        },
        children: [
            {
                title: "Usuarios",
                props: {
                    prependIcon: " mdi-minus",
                    value: "users",
                    onclick: () => router.get("/users"),
                },
            },
            {
                title: "Roles",
                props: {
                    prependIcon: " mdi-minus",
                    value: "roles",
                    onclick: () => router.get("/roles"),
                },
            },
        ],
    },
]);

const breadCrumbs = ref([]);
</script>
