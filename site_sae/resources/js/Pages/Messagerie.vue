<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import Footer from "@/Components/Footer.vue";

// Variable réactive pour stocker les utilisateurs
        const utilisateurs = ref([]);

// Définir utilisateurs sur l'objet window (pour les test cypress)
window.utilisateurs = utilisateurs;

// Variable réactive pour stocker la recherche
        const recherche = ref('');

// Variable réactive pour indiquer si les utilisateurs sont en cours de chargement
        const entrainDeCharger = ref(true);

        /**
         * Récupère les utilisateurs depuis l'API et les stocke dans la variable `utilisateurs`.
         */
        const creationBalisesUtilisateurs = async () => {
            try {
                let response = await fetch('http://127.0.0.1:8000/api/utilisateurs');
                utilisateurs.value = await response.json(); // Lit le corps en tant que JSON et le stocke dans `users`
                console.log("Les utilisateurs ont été récupérés :", utilisateurs.value);
            } catch (error) {
                console.error('Erreur lors de la récupération des utilisateurs:', error);
            } finally {
                if (utilisateurs.value.length !== 0) {
                    entrainDeCharger.value = false;
                }
            }
        }

// Propriété calculée pour filtrer les utilisateurs en fonction de la recherche
        const UtilisateurFiltre = computed(() => {
            if (!recherche.value) {
                return utilisateurs.value;
            }
            return utilisateurs.value.filter(utilisateur =>
                utilisateur.pseudo.toLowerCase().includes(recherche.value.toLowerCase()) ||
                utilisateur.nom.toLowerCase().includes(recherche.value.toLowerCase()) ||
                utilisateur.prenom.toLowerCase().includes(recherche.value.toLowerCase())
            );
        });

// Appelle la fonction lorsque le composant est monté (complètement chargé dans le DOM)
        onMounted(() => {
            creationBalisesUtilisateurs();
        });

        /**
         * Gère l'événement de clic sur un utilisateur et redirige vers un lien mailto.
         * @param utilisateur - L'objet utilisateur
         */
        const CliqueFonction = (utilisateur) => {
            const email = utilisateur.email;
            const subject = `Message de ${utilisateur.pseudo}`;
            const body = 'Salut ! Comment vas-tu ? \n Je t\'envoie ce mail depuis le site du Club Photo Nailloux ! \n';

            window.location.href = `mailto:${email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        };
</script>

<template>
    <Head title="Messagerie" />

    <AuthenticatedLayout>

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Messagerie
            </h2>
        </template>
            <main>
                <h1>Messagerie</h1>
                <form class="search-bar" @submit.prevent>
                    <input type="search" v-model="recherche" placeholder="Rechercher..." />
                    <button type="submit">🔍</button>
                </form>
                <div id="principale">
                    <!-- Afficher l'icône de chargement si les données sont en cours de chargement -->
                    <div v-if="entrainDeCharger" class="loading-icon">
                        <h1>Recherche d'utilisateurs ...</h1>
                        <img src="../public/images/loading.gif" alt="Loading..." />
                    </div>
                    <!-- Créer une balise div pour chaque utilisateur filtré -->
                    <div v-else v-for="utilisateur in UtilisateurFiltre" :key="utilisateur.id_utilisateur" @click="CliqueFonction(utilisateur)" class="user" >
                        <img v-if="utilisateur.photo_de_profil" :src="utilisateur.photo_de_profil" alt="logo" id="pp" width="100" height="100">
                        <div class="infoUtilisateur">
                            <p id="pseudo">{{ utilisateur.pseudo }}</p>
                            <p>{{ utilisateur.nom }} {{ utilisateur.prenom }}</p>
                        </div>
                        <img id="logo" src="../public/images/enveloppe.ico" alt="logo envoyer" width="60" height="60">
                    </div>
                </div>
            </main>
            <Footer />
    </AuthenticatedLayout>
</template>

<style scoped>
.content-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
main {
    flex-grow: 1;
    display: flex;
    flex-direction: column;

    font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif;

    background-image: linear-gradient(rgba(255, 255, 255, 0.45), rgba(252, 252, 255, 0.45)),
    url("../public/images/messagerie/backgroundMessagrie.jpg");
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

.loading-icon {
    display: flex;
    flex: 1;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
}
.loading-icon h1 {
    border: none;
}
h1 {
    margin-top: 2%;
    align-self: center;
    justify-self: center;
    width: 100%;
    text-align: center;
}
#principale {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    flex: 1;
    height: 100%;
    align-content: flex-start;
    justify-content: center;
}

.user {
    display: flex;
    flex-direction: row;
    justify-content: left;
    align-items: flex-start;
    max-height: 120px;
    min-width: 80%;
    max-width: 80%;

    flex-grow: 1;
    flex-shrink: 1;

    border-style: solid;
    border-color: #dda115;
    border-radius: 10px;
    margin: 1%;
    padding: 10px 20px 10px 10px;

    background-color: rgba(62, 62, 62, 0.71);
}
.user:hover {
    cursor: pointer;
    background-color: #3e3e3e;
}
.user img {
    align-self: center;
}
.user > img#pp {
    border-radius: 50%;
}
@media (max-width: 420px) {
    img#logo {
        visibility: hidden;
    }
}
.user > .infoUtilisateur {
    display: flex;
    flex-wrap: nowrap;
    flex: 1;
    flex-direction: column;
    justify-content: center;
    margin-left: 10px;

    font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif;
    color: #f6f6f6;
}
#pseudo {
    Font-size: 1.5em;
    font-weight: bold;
}

/* Style barre de recherche */
.search-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 20px;
}
.search-bar input {
    width: 300px;
    padding: 10px;
    border: 2px solid #dda115;
    border-radius: 5px 0 0 5px;
    font-size: 16px;
    outline: none;
    transition: border 0.3s ease;
}
.search-bar input:focus {
    border-color: #ffb300;
}
.search-bar button {
    padding: 10px 20px;
    border: none;
    background-color: #dda115;
    color: white;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}
.search-bar button:hover {
    background-color: #ffb300;
}
</style>
