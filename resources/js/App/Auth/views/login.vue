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
                                        <v-col cols="12">
                                            <v-btn
                                                color="primary"
                                                block
                                                variant="outlined"
                                                prepend-icon="mdi-google"
                                                link
                                                href="/auth/google"
                                            >
                                                Google
                                            </v-btn>
                                        </v-col>
                                
                                    </v-row>
                                </div>
                            </v-card-text>

                            <v-divider class="my-3"> </v-divider>

                            <v-card-text>
                                <v-form @submit.prevent="submitSignIn">
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="form.email"
                                                label="Usuario"
                                                prepend-inner-icon="mdi-account"
                                                type="text"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                autocomplete="off"
                                                v-model="form.password"
                                                prepend-inner-icon="mdi-lock"
                                                :append-inner-icon="
                                                    showPassword
                                                        ? 'mdi-eye'
                                                        : 'mdi-eye-off'
                                                "
                                                @click:append-inner="
                                                    () =>
                                                        (showPassword =
                                                            !showPassword)
                                                "
                                                label="Contraseña"
                                                :type="
                                                    showPassword
                                                        ? 'text'
                                                        : 'password'
                                                "
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>

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
import { router, useForm } from "@inertiajs/vue3";
const showPassword = ref(false);

const form = useForm({
    email: "admin@gmail.com",
    password: "password",
});

const submitSignIn = () => {
    console.log("submitSignIn");

    form.post("/auth/sign-in", {
        preserveState: true,
        onSuccess: () => {
            console.log("onSuccess");
            router.get("dashboard");
        },
        onError: () => {
            alert("Error");
        },
    });
};
</script>
