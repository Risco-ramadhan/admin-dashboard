import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

// Mengimpor HighchartsVue
import HighchartsVue from "highcharts-vue";

// Mendapatkan nama aplikasi
const appName = import.meta.env.VITE_APP_NAME || "Laravel";

// Membuat aplikasi Inertia dan menambahkan HighchartsVue
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        // Membuat aplikasi Vue
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(HighchartsVue) // Menambahkan plugin HighchartsVue
            .mount(el);

        return app;
    },
    progress: {
        color: "#4B5563",
    },
});
