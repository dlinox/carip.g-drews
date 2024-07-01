<template>
    <v-app app>
        <v-navigation-drawer :width="miniVariant ? 56 : 220" app>
            <v-list-item link title="List Item 1">
                <template #prepend>
                    <v-icon>mdi-home</v-icon>
                </template>
            </v-list-item>
            <v-list-item link title="List Item 2">
                <template #prepend>
                    <v-icon>mdi-home</v-icon>
                </template>
            </v-list-item>
            <v-list-item link title="List Item 3">
                <template #prepend>
                    <v-icon>mdi-account</v-icon>
                </template>
            </v-list-item>
        </v-navigation-drawer>

        <v-app-bar :elevation="2">
            <template v-slot:prepend>
                <v-app-bar-nav-icon @click="miniVariant = !miniVariant">
                </v-app-bar-nav-icon>
            </template>

            <v-app-bar-title>Application Bar</v-app-bar-title>
        </v-app-bar>
        <v-main app>
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="monto_"
                            label="Monto"
                            outlined
                            @change="calcular(monto_)"
                        ></v-text-field>
                    </v-col>
                </v-row>
                {{ total_ }}
            </v-container>
        </v-main>
    </v-app>
</template>
<script setup>
import { ref } from "vue";
const message = "Hello Vue 3!";

const miniVariant = ref(false);
//calcular pago 3.44% + $0.20 + IGV

const monto_ = ref(0);
const total_ = ref(0);

const calcular = (value) => {
    const monto = parseFloat(value);
    const comision = monto * 0.0344;
    //mas 2 dolares, (el monto es en soles)
    const comision2 = 0.2 * 3.8;
    const total = monto - comision;
    const igv = total * 0.18;
    const totalFinal = total - igv;
    total_.value = totalFinal - comision2;

    console.log(totalFinal);
};
</script>
