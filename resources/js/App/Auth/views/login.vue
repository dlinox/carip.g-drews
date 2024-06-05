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
                                        <v-col cols="12" v-if="errorMessages">
                                            <v-alert
                                                type="error"
                                                dense
                                                variant="tonal"
                                            >
                                                {{ errorMessages }}
                                            </v-alert>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="form.email"
                                                label="Usuario"
                                                prepend-inner-icon="mdi-email"
                                                type="text"
                                                :error="
                                                    errors[`email`]
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    errors[`email`]
                                                "
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
                                                :error="
                                                    errors[`password`]
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    errors[`password`]
                                                "
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>

                                    <div
                                        class="text-center d-flex justify-space-between align-center my-2"
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
                                    <v-btn
                                        type="submit"
                                        color="primary"
                                        block
                                        :loading="loading"
                                    >
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
import { _signIn } from "@/App/Auth/services";

const form = ref({
    email: "admin@gmail.com",
    password: "password",
});

const loading = ref(false);
const errors = ref([]);
const errorMessages = ref(null);

const showPassword = ref(false);

const submitSignIn = async () => {
    loading.value = true;
    errors.value = [];
    errorMessages.value = null;

    let res = await _signIn(form.value);

    if (res.status === "error") {
        errorMessages.value = res.message;
        loading.value = false;
    }

    if (res.errors) {
        console.log("res.errors", res.errors);
        errors.value = res.errors;
        loading.value = false;
    }

    if (res.status === "success") {
        console.log("res.status", res.status);
        router.get("dashboard");
    }
};
</script>
