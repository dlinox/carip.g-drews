<template>
    <v-card class="rounded-0" elevation="0">
        <v-toolbar density="compact">
            <v-toolbar-title>
                <small> Responsable(s) </small>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <LnxDialog title="Asignar Responsable" width="400px">
                <template v-slot:activator="{ dialog }">
                    <v-btn
                        prepend-icon="mdi-plus"
                        color="primary"
                        @click="dialog"
                    >
                        asignar
                    </v-btn>
                </template>
                <template v-slot:content="{ dialog }">
                    <FormCreate
                        @onSubmit="assignManager($event, dialog)"
                        :formStructure="formAssignManager"
                        @onCancel="dialog"
                    />
                </template>
            </LnxDialog>
        </v-toolbar>
        <v-list-item
            v-for="manager in managers"
            :key="manager.id"
            :title="manager.name"
            :subtitle="manager.area_name"
            two-line
            class="border-b py-2"
        >
            <template v-slot:prepend>
                <v-icon icon="mdi-account-tie"></v-icon>
            </template>
            <template v-slot:append>
                <v-btn
                    color="error"
                    variant="tonal"
                    size="small"
                    prepend-icon="mdi-minus-circle"
                    @click="unassignManager(manager)"
                >
                    Desasignar
                </v-btn>
            </template>
        </v-list-item>
    </v-card>
</template>

<script setup>
import { ref } from "vue";
import { formAssignManagerInit } from "@/App/Project/forms";
import FormCreate from "@/App/Project/components/FormCreate.vue";
import LnxDialog from "@/Shared/components/LnxDialog.vue";

import {
    _companymManagers,
    _assignManager,
    _unassignManager,
    _managers,
} from "@/App/Project/services";
import { da } from "vuetify/locale";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const companyManagers = ref([]);
const managers = ref([]);

const formAssignManager = ref({});

const assignManager = async (data, dialog) => {
    data.project_id = props.project.id;
    const response = await _assignManager(data);

    if (response) {
        await init();
        dialog();
    }
};

const unassignManager = async (manager) => {
    let data = {
        worker_id: manager.id,
        project_id: props.project.id,
    };
    const response = await _unassignManager(data);

    if (response) {
        await init();
    }
};

const init = async () => {
    managers.value = await _managers(props.project.id);
    companyManagers.value = await _companymManagers(props.project.company_id);

    formAssignManager.value = await formAssignManagerInit({
        managers: companyManagers.value,
    });
};

init();
</script>
