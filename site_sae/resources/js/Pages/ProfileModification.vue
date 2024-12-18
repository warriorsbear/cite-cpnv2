<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from "../Layouts/AuthenticatedLayout.vue";
import {Head, usePage} from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";

const UtilisateurConnecter = usePage().props.auth.user; //variable pour stocker les informations de l'utilisateur connecté
const { id } = defineProps({
    id: String
});

const utilisateur = ref(null);

const fetchUtilisateur = async () => {
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/utilisateurs`);
        const data = await response.json();
        console.log("Les utilisateurs ont été récupérés :", data.value);
        utilisateur.value = data.find(user => user.id === id);
    } catch (error) {
        console.error('Erreur lors de la récupération de l\'utilisateur:', error);
    }
};
const RecuperationUtilisateurs = async () => {
    try {
        let response = await fetch('http://127.0.0.1:8000/api/utilisateurs');
        utilisateur.value = await response.json(); // Lit le corps en tant que JSON et le stocke dans `users`
    } catch (error) {
        console.error('Erreur lors de la récupération des utilisateurs:', error);
    }
};

onMounted(() => {
    RecuperationUtilisateurs();
});
</script>

<template>
    <Head title="Messagerie" />

    <AuthenticatedLayout>

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Profile de {{ utilisateur?.pseudo }}
            </h2>
        </template>
        <main>
            <div class="form-container">
                <h2>Modifications possibles</h2>
                <form>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="pseudo">Pseudo</label>
                        <input type="text" id="pseudo" name="pseudo" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Rôle</label>
                        <select id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </main>
        <Footer/>
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
.form-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
}
.form-container h2 {
    margin-bottom: 20px;
    text-align: center;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    margin-bottom: 5px;
}
.form-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.form-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
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
.form-group button:hover {
    background-color: #218838;
}
</style>
