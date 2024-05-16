<template>
    <v-app app>
        <v-main class="min-h-screen">
            <v-row class="h-100" no-gutters>
                <v-col cols="12" md="5" class="bg-white">
                    <v-container
                        class="h-100 d-flex justify-space-between align-center flex-column"
                    >
                        <div>
                            <h1>logo</h1>
                        </div>
                        <v-card class="w-md-75 bg-white">
                            <div class="pa-4">
                                <h4 class="text-center">
                                    Bienvenido al sistema de gestión de su
                                    <span class="text-primary">hotel</span>
                                </h4>
                                <p class="text-center">
                                    Ingrese sus credenciales para acceder al
                                    sistema.
                                </p>
                            </div>
                            <v-card-text>
                                <div class="">
                                    <div class="text-overline">
                                        Ingresar con
                                    </div>

                                    <v-row class="justify-center">
                                        <v-col cols="6">
                                            <v-btn
                                                color="primary"
                                                block
                                                variant="outlined"
                                                prepend-icon="mdi-google"
                                                >Google</v-btn
                                            >
                                        </v-col>
                                        <v-col cols="6">
                                            <v-btn
                                                color="primary"
                                                block
                                                variant="outlined"
                                                prepend-icon="mdi-facebook"
                                                >Facebook</v-btn
                                            >
                                        </v-col>
                                    </v-row>
                                </div>
                            </v-card-text>

                            <v-divider class="my-3"> </v-divider>

                            <v-card-text>
                                <v-form @submit.prevent="submitSignIn">
                                    <v-text-field
                                        v-model="email"
                                        label="Usuario"
                                        prepend-inner-icon="mdi-account"
                                        type="text"
                                    ></v-text-field>
                                    <v-text-field
                                        autocomplete="off"
                                        v-model="password"
                                        prepend-inner-icon="mdi-lock"
                                        :append-inner-icon="
                                            showPassword
                                                ? 'mdi-eye'
                                                : 'mdi-eye-off'
                                        "
                                        @click:append-inner="
                                            () => (showPassword = !showPassword)
                                        "
                                        label="Contraseña"
                                        :type="
                                            showPassword ? 'text' : 'password'
                                        "
                                    ></v-text-field>

                                    <div
                                        class="text-center d-flex justify-space-between align-center"
                                    >
                                        <v-checkbox
                                            color="primary"
                                            label="Recordar"
                                            required
                                            density="compact"
                                        ></v-checkbox>

                                        <a href="" class="text-primary">
                                            Olvidaste tu contraseña?
                                        </a>
                                    </div>
                                    <v-btn type="submit" color="primary" block>
                                        Ingresar
                                    </v-btn>
                                </v-form>
                            </v-card-text>
                        </v-card>

                        <div class="text-center">
                            <small>
                                Copyrigth &copy; {{ new Date().getFullYear() }}
                            </small>
                        </div>
                    </v-container>
                </v-col>

                <v-col cols="12" md="7" class="d-none d-md-block bg-black">
                </v-col>
            </v-row>
        </v-main>
    </v-app>
</template>
<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
const showPassword = ref(false);
const email = ref("");
const password = ref("");

const submitSignIn = () => {
    console.log("submitSignIn");
    router.get("/dashboard");
};
</script>
