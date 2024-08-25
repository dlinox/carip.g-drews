import { createVuetify } from "vuetify";
import defaults from "./defaults";
import theme from "./theme";
import { es } from "vuetify/locale";
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";

export default createVuetify({
    defaults,
    theme,
    locale: {
        locale: "es",
        fallback: "es",
        messages: { es },
    },
});
