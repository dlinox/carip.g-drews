<template>
    <AdminLayout>
        <v-card class="rounded-0">
            <v-toolbar class="bg-primary">
                <v-toolbar-title>
                    <v-list-item
                        :title="project.name.toUpperCase()"
                        :subtitle="project.company_name"
                    />
                </v-toolbar-title>

                <v-spacer></v-spacer>
            </v-toolbar>
            <v-row no-gutters class="">
                <v-col cols="12" md="6">
                    <AssignManagers :project="project" />
                </v-col>
                <v-col cols="12" md="6" class="border-s">
                    <AssignSupervisor :project="project" />
                </v-col>
            </v-row>
        </v-card>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";
import AssignSupervisor from "@/App/Project/components/AssignSupervisor.vue";
import AssignManagers from "@/App/Project/components/AssignManagers.vue";

import { useLayoutStore } from "@/Shared/stores";
const props = defineProps({
    title: String,
    project: Object,
});

const layoutStore = useLayoutStore();

const init = async () => {
    layoutStore.title = props.title;
};

init();
</script>
