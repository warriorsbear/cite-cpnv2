import { expect, it, describe, vi } from 'vitest';
import { mount } from '@vue/test-utils';
import PageMessagerie from '../resources/js/Pages/Messagerie.vue';
import { createRouter, createWebHistory } from 'vue-router';

// Function to wait for promises to resolve
const flushPromises = () => new Promise(setImmediate);

// Mock the fetch function
global.fetch = vi.fn(() =>
    Promise.resolve(new Response(JSON.stringify([
        {
            id_utilisateur: 1,
            pseudo: 'JohnDoe',
            nom: 'Doe',
            prenom: 'John',
            adresse: '9 rue de la voile',
            cp: '75000',
            ville: 'Paris',
            telephone: '0123456789',
            mail: 'john@example.com',
            mdp: '123456',
            role: 'membre',
            statut: true,
            notif_mail: false,
            statut_cotisation: true,
            photo_de_profile: ''
        },
        {
            id_utilisateur: 2,
            pseudo: 'JaneDoe',
            nom: 'Doe',
            prenom: 'Jane',
            adresse: '10 rue de la mer',
            cp: '75001',
            ville: 'Paris',
            telephone: '0987654321',
            mail: 'jane@example.com',
            mdp: 'abcdef',
            role: 'admin',
            statut: true,
            notif_mail: true,
            statut_cotisation: false,
            photo_de_profile: ''
        },
    ]))),
);

// Create a mock router
const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', redirect: '/PageMessagerie' },
        { path: '/PageMessagerie', component: PageMessagerie },
    ]
});

describe('LesTestsDePageMessagerie', () => {

    it('PageMessagerie comporte bien un titre "Messagerie"', async () => {
        const wrapper = mount(PageMessagerie, {
            global: {
                plugins: [router],
            },
        });
        const html = wrapper.html();
        expect(html).toContain('Messagerie');
    });

    it('Affiche l\'icône de chargement quand les données sont en chargement', async () => {
        const wrapper = mount(PageMessagerie, {
            global: {
                plugins: [router],
            },
            data() {
                return {
                    entrainDeCharger: true,
                };
            },
        });
        expect(wrapper.find('.loading-icon').exists()).toBe(true);
    });

    it('affiche les utilisateurs lorsque les données sont chargées', async () => {
        const wrapper = mount(PageMessagerie, {
            global: {
                plugins: [router],
            },
        });

        await flushPromises();
        expect(wrapper.vm.entrainDeCharger).toBe(false);
        expect(wrapper.findAll('.user').length).toBe(2);
    });

    it('vérification que l\'affichage est correct après une recherche', async () => {
        const wrapper = mount(PageMessagerie, {
            global: {
                plugins: [router],
            },
            data() {
                return {
                    recherche: 'Jane',
                };
            },
        });
        await flushPromises();
        expect(wrapper.findAll('.user').length).toBe(1);
    });
});
