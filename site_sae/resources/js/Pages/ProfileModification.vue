<script setup>
// Importation des fonctions et composants nécessaires depuis Vue et Inertia.js
import {ref, onMounted, watch} from 'vue';
import AuthenticatedLayout from "../Layouts/AuthenticatedLayout.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

// Variable pour stocker les informations de l'utilisateur connecté
const UtilisateurConnecter = usePage().props.auth.user; //variable pour stocker les informations de l'utilisateur connecté

//fonction qui vérifie que la personne qui va modifier est bien un admin
const verificationAdmin = () => {
    if (UtilisateurConnecter.role !== 'admin') {
        alert('Vous n\'avez pas les droits pour accéder à cette page');
        location.href = '/';
    }
};

// Définition des propriétés attendues par le composant
const { user } = defineProps({
    user: Object
});
// Référence pour stocker les données de l'utilisateur
const utilisateur = ref([]);

// Utilisation de useForm pour gérer le formulaire de modification de profil
const form = useForm({
    nom: user.nom,
    prenom: user.prenom,
    pseudo: user.pseudo,
    role: user.role,
});

// Vérification des droits d'admin lors du montage du composant
onMounted(() => {
    verificationAdmin()
});
</script>

<template>
    <!-- Définition du titre de la page -->
    <Head title="Messagerie" />

    <!-- Utilisation du layout authentifié -->
    <AuthenticatedLayout>

        <!-- En-tête de la page -->
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Profile de {{ utilisateur?.pseudo }}
            </h2>
        </template>

        <!-- Contenu principal de la page -->
        <main>
            <div class="form-container">
                <h2>Modifications possibles</h2>
                <!-- Formulaire de modification de profil -->
                <form @submit.prevent="form.patch(route('profile.updateModif', { id: user.id }))">
                    <div class="form-group">
                        <InputLabel for="nom" value="Nom" />
                        <TextInput id="nom" type="text" v-model="form.nom" required />
                        <InputError :message="form.errors.nom" />
                    </div>
                    <div class="form-group">
                        <InputLabel for="prenom" value="Prénom" />
                        <TextInput id="prenom" type="text" v-model="form.prenom" required />
                        <InputError :message="form.errors.prenom" />
                    </div>
                    <div class="form-group">
                        <InputLabel for="pseudo" value="Pseudo" />
                        <TextInput id="pseudo" type="text" v-model="form.pseudo" required />
                        <InputError :message="form.errors.pseudo" />
                    </div>
                    <div class="form-group">
                        <InputLabel for="role" value="Rôle" />
                        <select id="role" v-model="form.role" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <InputError :message="form.errors.role" />
                    </div>
                    <div class="form-group">
                        <PrimaryButton :disabled="form.processing">Sauvegarder</PrimaryButton>
                    </div>
                </form>
            </div>
        </main>
        <!-- Pied de page -->
        <Footer/>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Style pour le conteneur principal */
.content-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
/* Réinitialisation des marges et des paddings */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
/* Style pour le contenu principal */
main{
    flex-grow: 1;
    min-height: 42rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif;
    color: #2a2828;
}
/* Style pour le conteneur du formulaire */
.form-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
}
/* Style pour le titre du formulaire */
.form-container h2 {
    margin-bottom: 20px;
    text-align: center;
}
/* Style pour les groupes de champs du formulaire */
.form-group {
    margin-bottom: 15px;
}
/* Style pour les labels des champs */
.form-group label {
    display: block;
    margin-bottom: 5px;
}
/* Style pour les champs de saisie */
.form-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
/* Style pour les sélecteurs */
.form-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
/* Style pour les boutons */
.form-group button {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    border: none;
    border-radius: 4px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}
/* Style pour les boutons au survol */
.form-group button:hover {
    background-color: #218838;
}
</style>
