<template>
    <v-card class="rounded-0" elevation="0">
        <v-toolbar density="compact">
            <v-toolbar-title>
                <small> Supervisor(s) </small>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <LnxDialog title="Asignar Supervisor" width="400px">
                <template v-slot:activator="{ dialog }">
                    <v-btn
                        v-if="!supervisor"
                        prepend-icon="mdi-plus"
                        color="primary"
                        @click="dialog"
                    >
                        asignar
                    </v-btn>
                </template>
                <template v-slot:content="{ dialog }">
                    <FormCreate
                        @onSubmit="assignSupervisor($event, dialog)"
                        :formStructure="formAssignSupervisor"
                        @onCancel="dialog"
                    />
                </template>
            </LnxDialog>
        </v-toolbar>
        <v-list-item
            v-if="supervisor"
            :title="supervisor.name"
            subtitle="Supervisor"
            class="border-b py-2"
        >
            <template v-slot:prepend>
                <v-icon icon="mdi-account-star"></v-icon>
            </template>
            <template v-slot:append>
                <v-btn
                    color="error"
                    variant="tonal"
                    size="small"
                    prepend-icon="mdi-minus-circle"
                    @click="unassignSupervisor()"
                >
                    Desasignar
                </v-btn>
            </template>
        </v-list-item>
    </v-card>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { formAssignSupervisorInit } from "@/App/Project/forms";
import FormCreate from "@/App/Project/components/FormCreate.vue";
import LnxDialog from "@/Shared/components/LnxDialog.vue";
import {
    _supervisor,
    _supervisors,
    _assignSupervisor,
    _unassignSupervisor,
} from "@/App/Project/services";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});
const supervisor = ref(null);
const supervisors = ref([]);

const formAssignSupervisor = ref([]);

const assignSupervisor = async (data, dialog) => {
    data.project_id = props.project.id;
    console.log(data);

    const response = await _assignSupervisor(data);
    if (response) {
        dialog();
        supervisors.value = await _supervisors();
        supervisor.value = await _supervisor(props.project.id);
    }
};

const unassignSupervisor = async () => {
    let data = {
        project_id: props.project.id,
        supervisor_id: supervisor.value.id,
    };

    const response = await _unassignSupervisor(data);
    if (response) {
        supervisors.value = await _supervisors();
        supervisor.value = null;
    }
};
const init = async () => {
    supervisors.value = await _supervisors();
    supervisor.value = await _supervisor(props.project.id);
    formAssignSupervisor.value = formAssignSupervisorInit({
        supervisors: supervisors.value,
    });
};

init();
</script>
