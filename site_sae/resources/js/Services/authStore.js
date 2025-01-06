import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: {
            id_utilisateur: null,  // ID de l'utilisateur
        },
    }),
    actions: {
        async fetchUser() {
            try {
                const response = null //await axios.get('http://127.0.0.1:8000/api/user');
                this.user = response.data; // Stocke les données utilisateur dans le store
            } catch (error) {
                console.error('Erreur lors de la récupération de l\'utilisateur :', error);
                this.user = null;
            }
        },
    },
});
