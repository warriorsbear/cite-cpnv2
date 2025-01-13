import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { createPinia } from 'pinia';
import { ZiggyVue } from 'ziggy-js';

const pinia = createPinia(); // Initialisation de Pinia
const appName = 'Club Photo Nailloux'; // Nom de l'application

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.config.devtools = true; // Activation des outils de développement
        return app
            .use(plugin) // Utilisation correcte du plugin Inertia.js
            .use(pinia) // Ajout de Pinia
            .use(ZiggyVue) // Ajout de ZiggyVue
            .mount(el); // Montage de l'application
    },
    progress: {
        color: '#4B5563', // Couleur de la barre de progression
    },
});
