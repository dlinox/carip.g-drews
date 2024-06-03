<template>
    <v-card variant="flat">
  
        <v-tabs v-model="tab">
            <v-tab
                v-for="(item, index) in permissions"
                :key="index"
                :value="index"
            >
                {{ index }}
            </v-tab>
        </v-tabs>
        <v-window v-model="tab" style="height: 300px; overflow-y: auto;">
            <v-window-item
                v-for="(items, index) in permissions"
                :key="index"
                :value="index"
            >
                <v-list nav>
                    <v-list-item
                        v-for="item in items"
                        divider
                        class="border-b py-2"
                    >
                        <v-list-item-title>
                            <v-icon>mdi-circle-small</v-icon>
                            {{ trasnformTitle(item.name) }}
                        </v-list-item-title>
                        <template v-slot:append>
                            <v-switch
                            density="compact"
                                v-model="form.permissions"
                                :value="item.name"
                                hide-details
                                inset
                                color="primary"
                            ></v-switch>
                        </template>
                    </v-list-item>
                </v-list>
            </v-window-item>
        </v-window>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn variant="tonal" color="red" @click="$emit('onCancel')">
                cancelar
            </v-btn>

            <v-btn
                variant="flat"
                @click="submit"
                class="ms-3"
                :loading="form.processing"
                :disabled="!form.isDirty"
            >
                Guardar
            </v-btn>
        </v-card-actions>
    </v-card>
</template>
<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const emit = defineEmits(["onCancel", "onSubmit", "onSuccess"]);

const props = defineProps({
    permissions: Object,
    rolPermissions: Array,
    url: String,
    roleId: Number, 
});

const tab = ref(null);

const trasnformTitle = (title) => {
    const transformedTitle = title.replace(/-/g, " ");
    return transformedTitle.toUpperCase();
};

const form = useForm({
    roleId: props.roleId,
    permissions: props.rolPermissions.map((permission) => permission.name),
});

const submit = async () => {

    console.log(form);
    form.post(props.url, option);
};

const option = {
    onSuccess: (page) => {
        console.log("onSuccess");
        emit("onSuccess");
        emit("onCancel");
    },
    onError: (errors) => {
        console.log("onError");
    },
    onFinish: (visit) => {
        console.log("onFinish");
    },
};
</script>
