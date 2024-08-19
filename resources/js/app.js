import "./bootstrap";
import "../css/app.css";
import "vue-toastification/dist/index.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";

import Toast from "vue-toastification";

//store pinia
import { createPinia } from "pinia";

import vuetify from "@/Shared/plugins/vuetify";

import permission from "./App/Auth/directives/permission";

const pinia = createPinia();

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./App/**/*.vue", { eager: true });
        return pages[`./App/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(pinia)
            .directive("permission", permission)
            .use(plugin)
            .use(vuetify)
            .use(Toast, {
                position: "bottom-right",
                timeout: 1500,
            })
            .mount(el);
    },
});
