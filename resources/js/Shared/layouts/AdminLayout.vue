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
                    src="/logo.png"
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
            <!-- <v-btn
                icon="mdi-bell"
                class="me-2"
                color="info"
                variant="tonal"
                density="comfortable"
            /> -->
            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn
                        icon="mdi-account"
                        variant="tonal"
                        density="comfortable"
                        v-bind="props"
                    >
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item
                        title="Salir"
                        prepend-icon="mdi-logout"
                        @click="signOut()"
                    ></v-list-item>
                </v-list>
            </v-menu>
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
                Developed by <a href="">Linox</a>
            </small>
        </v-footer>
    </v-app>
</template>
<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";

import { useMenuStore, useLayoutStore } from "@/Shared/stores";
import { useUserStore } from "@/App/Auth/stores";

import { _signOut } from "@/App/Auth/services";

const menuStore = useMenuStore();
const layoutStore = useLayoutStore();
const userStore = useUserStore();

const currentMenu = computed(() => menuStore.current);

const user = computed(() => usePage().props.auth.user);

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
                title: "Sedes",
                props: {
                    prependIcon: "mdi-minus",
                    value: "branches",
                    onclick: () => router.get("/branches"),
                },
            },
            {
                title: "Empresas",
                props: {
                    prependIcon: "mdi-minus",
                    value: "companies",
                    onclick: () => router.get("/companies"),
                },
            },
            {
                title: "Proveedores",
                props: {
                    prependIcon: "mdi-minus",
                    value: "suppliers",
                    onclick: () => router.get("/suppliers"),
                },
            },
            {
                title: "Operadores",
                props: {
                    prependIcon: "mdi-minus",
                    value: "operators",
                    onclick: () => router.get("/operators"),
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

const signOut = async () => {
    let response = await _signOut();
    if (response.status === "success") {
        router.get("/auth");
    }
};

const init = async () => {

    userStore.permissions = user.value.permissions;
};

init();
</script>
