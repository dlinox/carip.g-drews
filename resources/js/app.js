import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";

//store pinia
import { createPinia } from "pinia";

import vuetify from "@/Shared/plugins/vuetify";

const pinia = createPinia();

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./App/**/*.vue", { eager: true });
        return pages[`./App/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(pinia)
            .use(plugin)
            .use(vuetify)
            .mount(el);
    },
});
