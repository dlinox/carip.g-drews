<template>
    <AdminLayout>
        <v-container fluid>
            <v-row>
                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-item>
                            <Bar id="my-chart-id" :data="chartData" />
                        </v-card-item>
                    </v-card>
                </v-col>
                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-item>
                            <Doughnut :data="data" :options="options" />
                        </v-card-item>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import { _searchLocation } from "@/Shared/services";
import LnxSearchServer from "@/Shared/components/LnxSearchServer.vue";
import LnxInputReniecOrSunat from "@/Shared/components/LnxInputReniecOrSunat.vue";

import AdminLayout from "@/Shared/layouts/AdminLayout.vue";

import { Bar, Doughnut } from "vue-chartjs";

import { ref } from "vue";
import {
    Chart as ChartJS,
    Title,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    ArcElement,
} from "chart.js";

const lnxVal = ref(null);

const auxResult = ref({
    code: "200901",
    location: "PUNO, SAN ROMAN, JULIACA",
});

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement
);

const chartData = {
    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio"],
    datasets: [
        {
            label: "Ventas",
            backgroundColor: "#f87979",
            data: [40, 20, 12, 39, 10, 40, 39],
        },
        {
            label: "Gastos",
            backgroundColor: "#79f8f8",
            data: [20, 30, 22, 19, 20, 30, 29],
        },
    ],
};

const data = {
    labels: ["op1", "op2", "op3", "op4"],
    datasets: [
        {
            backgroundColor: ["#41B883", "#E46651", "#00D8FF", "#DD1B16"],
            data: [40, 20, 80, 10],
        },
    ],
};

const options = {
    responsive: true,
    maintainAspectRatio: false,
};
</script>
