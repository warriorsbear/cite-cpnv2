<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import Box_even from "@/Components/box_even.vue";
import Test_creation from "@/Components/test_creation.vue";
import Footer from "@/Components/Footer.vue";

const evenements = ref([]);
const loading = ref(true);
const montrerTestCreation = ref(false);

const user = usePage().props.auth.user;

const fetchEvenements = async () => {
    try {
        const response = await fetch('http://127.0.0.1:8000/api/evenements');
        evenements.value = await response.json();
        console.log("Les evenements ont été récupérés :", evenements.value);
    } catch (error) {
        console.error('Erreur lors de la récupération des événements:', error);
    } finally {
        loading.value = false;
    }
};

const handleFormSubmit = () => {
    montrerTestCreation.value = false;
    fetchEvenements();
};

onMounted(() => {
    fetchEvenements();
});

const currentDate = new Date();

const filteredEvenements = computed(() => {
    return evenements.value.data.filter(event => new Date(event.date_heure) >= currentDate);
});
</script>

<template>
    <Head title="Evenement" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Evenement
            </h2>
        </template>

        <button class="buttons" @click="montrerTestCreation = true">Créer un nouvel événement</button>

        <test_creation v-if="montrerTestCreation" @submit="handleFormSubmit" @close="montrerTestCreation = false"/>

        <div v-if="loading" class="loading-icon">
            <h1>Chargement des événements...</h1>
            <img src="../public/images/loading.gif" alt="Loading..." />
        </div>
        <div v-else class="conteuneur">
            <box_even
                v-for="evenement in filteredEvenements"
                :key="evenement.id"
                :id="evenement.id"
                :titre_even="evenement.titre"
                :description_even="evenement.description"
                :Date_even="evenement.date_heure"
                :Lieu_even="evenement.lieu"
                :Type_even="evenement.type"
                :Officiel_even="evenement.officiel"
                :participe_deja="false"
                :id_createur_even="evenement.id_utilisateur"
                :id_visionnage="evenement.id_visionnage"
            />
        </div>
        <Footer />
    </AuthenticatedLayout>
</template>

<style scoped>
.loading-icon {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.buttons {
    padding: 10px 15px;
    margin: 5px;
    border-radius: 5px;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.5s;
}

button:hover {
    background-color: #ff9900;
}

.conteuneur {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: flex-start;
    padding: 20px;
    background-color: rgb(255, 255, 255);
}
</style>
