<script setup>
import {Head, Link, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Footer from "@/Components/Footer.vue";
import {onMounted, ref} from "vue";
import Box_even from "@/Components/box_even.vue";
import Post_account from "@/Components/Post_account.vue";

const userDemanderId = usePage().props.id ? usePage().props.id : null;
const participations = ref([]);
const allEvents = ref([]);
const evenements= ref([]);
const photos = ref([]);
const posts = ref([]);
const loading = ref(true);
let utilisateur = usePage().props.auth.user;


const activeMenu = ref('photos');

const fetchEvenements = async () => {
    try {
        // Fetch all events
        const eventsResponse = await fetch(`http://127.0.0.1:8000/api/evenements`);
        const eventsData = await eventsResponse.json();
        if (!Array.isArray(eventsData.data)) {
            throw new TypeError('Expected an array of events');
        }
        allEvents.value = eventsData.data;
        console.log("Les événements ont été récupérés :", allEvents.value);

         // Fetch user participations
        const participationsResponse = await fetch(`http://127.0.0.1:8000/api/participations?user_id=${utilisateur.id}`);
        const participationsData = await participationsResponse.json();
        if (!Array.isArray(participationsData)) {
            throw new TypeError('Expected an array of participations');
        }
        participations.value = participationsData;
        console.log("Les participations ont été récupérées :", participations.value);

        // Extract event IDs from user participations
        const userEventIds = participations.value.map(participation => participation.id_evenement);

        // Filter and sort events based on user participation
        evenements.value = allEvents.value.filter(event => userEventIds.includes(event.id));
        console.log("Les événements triés ont été récupérés :", evenements.value);
    } catch (error) {
        console.error('Erreur lors de la récupération des événements:', error);
    }
};


const fetchUser = async (id) => {
    if(id != null) {
        console.log("id", id);
        try{
            let response;
            const utilisateurId = parseInt(id, 10); // Transforme id en integer
            response = await fetch(`http://127.0.0.1:8000/api/utilisateurs/${utilisateurId}`);
            //Object.assign(utilisateur, fetchedUser);
            utilisateur = await response.json();
            console.log("Les informations de l'utilisateur ont été récupérées :", utilisateur);
        }catch (error){
            console.error('Erreur lors de la récupération des informations de l\'utilisateur:', error);
        }


    }else{
        console.log("id", id);
    }
};

const fetchPhotos = async () => {

    try {
        const response = await fetch('http://127.0.0.1:8000/api/photos/', {
        });
        photos.value = await response.json();
        console.log("Les photos ont été récupérés :", photos.value);
    } catch (error) {
        console.error('Erreur lors de la récupération des photos:', error);
    }
};
const fetchPost = async () => {

    try {
        const response = await fetch('http://127.0.0.1:8000/api/posts/');
        const postsData = await response.json();
        console.log(postsData);
        // Check if the response has a data property and if it's an array
        if (!postsData || !Array.isArray(postsData)) {
            throw new TypeError('Expected an array of posts');
        }

        // Filter the posts to only include those posted by the connected user
        posts.value = postsData.filter(post => post.id_utilisateur === utilisateur.id);
        console.log("Les posts de l'utilisateur ont été récupérés :", posts.value);
    } catch (error) {
        console.error('Erreur lors de la récupération des posts:', error);
    }
};

const toggleMenu = (menu) => {
    activeMenu.value = menu;
};



onMounted(async () => {
    await Promise.all([fetchPhotos(), fetchEvenements(), fetchPost(),fetchUser(userDemanderId)]);
    loading.value = false;


});
</script>

<template>
    <Head title="Mon compte" />

    <AuthenticatedLayout>

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Mon Compte
            </h2>
        </template>


        <div class="mon-compte">

            <!-- Banner -->
            <div class="banner-container">
                <div class="banner"></div>
                <div class="banner-overlay"></div>
            </div>

            <!-- Section profil avec les informations de l'utilisateur -->
            <div class="profile-container">
                <div class="profile-content">
                    <img
                        src="../public/images/avatar.jpg"
                        alt="Photo de profil"
                        class="profile-picture"
                    />
                    <div class="profile-info">
                        <h1 class="profile-name">{{ utilisateur.nom }} {{ utilisateur.prenom }}</h1>
                        <p class="profile-username">@{{ utilisateur.pseudo }}</p>
                        <Link
                            :href="route('profile.edit')"
                            class="edit-profile-button"
                        >
                            Modifier le profil
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Toggle Bar -->
            <div class="toggle-bar">
                <button :class="{'active': activeMenu === 'photos'}" @click="toggleMenu('photos')">Photos</button>
                <button :class="{'active': activeMenu === 'evenements'}" @click="toggleMenu('evenements')">Événements</button>
            </div>

            <div v-if="loading===true" class="loading-icon">
                <h1>Chargement des données...</h1>
                <img src="../public/images/loading.gif" alt="Loading..." />
            </div>

            <div v-else>
                <!-- Posted Photos -->
                <div v-if="activeMenu === 'photos'" class="posted-photos">
                    <div v-if="posts.length === 0" class="no-content-message">
                        <p class="messageAbs">Vous n'avez pas encore posté de photos.</p>
                    </div>
                    <div v-else class="photos-grid">
                        <Post_account
                            v-for="post in posts"
                            :key="post.id_post"
                            :idPost="post.id_post"
                            :username="post.user.pseudo"
                            :userAvatar="post.user.photo_de_profile"
                            :imageUrl="post.photos"
                            :context="'profile'"
                        />
                    </div>
                </div>

                <!-- Posted Events -->
                <div v-if="activeMenu === 'evenements'" class="posted-events">
                    <div v-if="evenements.length === 0" class="no-content-message">
                        <p class="messageAbs">Vous n'avez pas encore rejoint d'événements.</p>
                    </div>
                    <div v-else class="conteuneur">
                        <box_even
                            v-for="evenement in evenements"
                            :key="evenement.id"
                            :id="evenement.id"
                            :titre_even="evenement.titre"
                            :description_even="evenement.description"
                            :Date_even="evenement.date_heure"
                            :Lieu_even="evenement.lieu"
                            :Type_even="evenement.type"
                            :Officiel_even="evenement.officiel"
                            :participe_deja="true"
                            :id_createur_even="evenement.id_utilisateur"
                        />
                    </div>
                </div>

            </div>


        </div>
        <Footer />
    </AuthenticatedLayout>
</template>

<style scoped>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: auto; /* Ensure scrolling is enabled */
}
.messageAbs {
    text-align: center;
    font-size: 15px;
    margin: 20px;
    color: #991b1b;
}
.mon-compte {
    display: flex;
    flex-direction: column;
    align-items: center;
    font-family: 'Poppins', sans-serif;
}

.banner-container {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.banner-overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 100px;
    background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.3));
}

.description-input textarea {
    width: 100%;
    height: 100px;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-family: 'Poppins', sans-serif;
    margin-bottom: 10px;
}
.loading-icon {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.loading-icon img {
    width: 50px;
    height: 50px;
}

.banner {
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: #b8762a; /* Bleu profond */
    background-image: linear-gradient(135deg, #ffffff 0%, #4c390f 100%);
}

.profile-container {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    margin-top: -80px;
    z-index: 10;
}

.profile-content {
    display: flex;
    align-items: flex-end;
    gap: 30px;
    padding-bottom: 30px;
}

.profile-picture {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    background-color: white;
    object-fit: cover;
}

.profile-info {
    padding-bottom: 10px;
}

.profile-name {
    color: #1a202c;
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.profile-username {
    color: #4a5568;
    font-size: 1.1rem;
    margin: 5px 0 15px 0;
}

.edit-profile-button {
    display: inline-block;
    padding: 8px 20px;
    background-color: #ccc;
    color: #2a2a2a;
    border-radius: 9999px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.edit-profile-button:hover {
    background-color: #b8762a;
    transform: translateY(-1px);
}



.profile-header h1 {
    text-align: left;
}

.profile-picture {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 3px solid white;
}




.toggle-bar {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.toggle-bar button.active {
    background-color: #b8762a;
    color: white;
}

.toggle-bar button {
    padding: 10px 20px;
    border: none;
    background-color: #ddd;
    cursor: pointer;
    transition: background-color 0.3s;
}

.toggle-bar button:not(.active):hover {
    background-color: #ccc;
}

.posted-photos, .posted-events {
    margin-top: 30px;
    width: 100%;
}

h2 {
    margin-left: 10px;
}

.photos-grid {
    display: grid;
    margin: 10px;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: repeat(2, 1fr);
    gap: 10px;
}

.photo-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
}





.conteuneur{
    display: flex;
    flex-wrap: wrap; /* Allow items to wrap to the next row */
    gap: 30px; /* Consistent space between items */
    justify-content: flex-start; /* Align items to the left */
    padding: 20px;
    /*

     */
}

</style>
