import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { createPinia } from 'pinia';
import {route, ZiggyVue} from 'ziggy-js';
import { Ziggy } from './ziggy';


const pinia = createPinia(); // Initialisation de Pinia
const appName = 'Club Photo Nailloux'; // Nom de l'application

const customZiggy = {
    ...Ziggy,
    url: window.location.origin // <- on écrase l'URL hardcodée
};

window.route = (name, params, absolute) => route(name, params, absolute, customZiggy);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    async setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.config.devtools = true;
        app.config.globalProperties.route = window.route;
        app.use(plugin)
            .use(pinia)
            .use(ZiggyVue, customZiggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563', // Couleur de la barre de progression
    },
});
