<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import Box_even from "@/Components/box_even.vue";
import Footer from "@/Components/Footer.vue";


const Evenement = {
    id_evenement: Number,
    titre: String,
    descriptif: String,
    date_heure: String,
    lieu: String,
    type: String,
    officiel: Boolean,
    id_utilisateur: Number
}

const evenements = ref([]);
const loading = ref(true);

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


onMounted(() => {
    fetchEvenements();
});
</script>

<template>
    <Head title="Evenement" />

    <AuthenticatedLayout>

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Evenement
            </h2>
        </template>

                        <div v-if="loading" class="loading-icon">
                            <h1>Chargement des événements...</h1>
                            <img src="../public/images/loading.gif" alt="Loading..." />
                        </div>
                        <div v-else class ="conteuneur">
                            <box_even
                                v-for="evenement in evenements.data"
                                :key="evenement.id"
                                :titre_even="evenement.titre"
                                :description_even="evenement.description"
                                :Date_even="evenement.date_heure"
                                :Lieu_even="evenement.lieu"
                                :Type_even="evenement.type"
                                :Officiel_even="evenement.officiel"
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

.titre{
    padding: 40px;
    background-color: rgb(255, 255, 255);
    color: rgba(0, 0, 0, 0.87);
    font-family: 'Poppins', sans-serif;


}

.buttons {
    padding: 10px 15px;
    margin:5px;
    border-radius: 5px;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.5s;
}

button:hover{
    background-color: #ff9900;
}


.conteuneur{
    display: flex;
    flex-wrap: wrap; /* Allow items to wrap to the next row */
    gap: 30px; /* Consistent space between items */
    justify-content: flex-start; /* Align items to the left */
    padding: 20px;
    background-color: rgb(255, 255, 255);
    /*

     */
}
</style>
