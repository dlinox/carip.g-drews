<template>
    <AdminLayout> </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/Shared/layouts/AdminLayout.vue";
import { useLayoutStore } from "@/Shared/stores";

const props = defineProps({
    title: String,
});

const layoutStore = useLayoutStore();

const init = async () => {
    layoutStore.title = props.title;
};

init();
</script>
