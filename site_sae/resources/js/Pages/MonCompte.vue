<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Footer from "@/Components/Footer.vue";
import {usePage} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import Box_even from "@/Components/box_even.vue";
import PhotoPost from "@/Components/MainApp/PhotoPost.vue";
import Post_account from "@/Components/Post_account.vue";

const participations = ref([]);
const allEvents = ref([]);
const evenements= ref([]);
const photos = ref([]);
const posts = ref([]);
const loading = ref(true);

const user = usePage().props.auth.user;

const form = useForm({
    id: user.id,
    nom: user.nom,
    prenom: user.prenom,
    pseudo: user.pseudo,
    email: user.email,
    photo: user.photo_de_profil,
});
const activeMenu = ref('photos');
const showDescriptionInput= ref(false);
const newDescription= ref('');
const description = ref('Ceci est la description du profil.');

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
        const participationsResponse = await fetch(`http://127.0.0.1:8000/api/participations?user_id=${user.id}`);
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
    } finally {
        loading.value = false;
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
    } finally {
        loading.value = false;
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
        const userPosts = postsData.filter(post => post.id_utilisateur === user.id);
        posts.value = userPosts;
        console.log("Les posts de l'utilisateur ont été récupérés :", posts.value);
    } catch (error) {
        console.error('Erreur lors de la récupération des posts:', error);
    } finally {
        loading.value = false;
    }
};

const toggleMenu = (menu) => {
    activeMenu.value = menu;
};

const changeDescription = (newDescription) => {
    description.value = newDescription;
};

const updateDescription = () => {
    changeDescription(newDescription);
    showDescriptionInput.value = false;
    newDescription.value = '';
};

onMounted(() => {
    fetchPhotos();
    fetchEvenements();
    fetchPost();
});
</script>

<!--<script>-->
<!--export default {-->
<!--    components: {Box_even},-->
<!--    data() {-->
<!--        return {-->
<!--            utilisateur: {-->
<!--                photo: "http://[::1]:5173/resources/js/public/images/avatar.jpg",-->
<!--                banner: "http://[::1]:5173/resources/js/public/images/baniere.png",-->
<!--                nom: usePage().props.auth.user.nom.split(' ')[1] || '',-->
<!--                prenom: usePage().props.auth.user.prenom.split(' ')[0] || '',-->
<!--                description: "Ceci est la description du profil.",-->
<!--                photos: [-->
<!--                ]-->
<!--            },-->
<!--            activeMenu: 'photos',-->
<!--            showDescriptionInput: false,-->
<!--            newDescription: ''-->
<!--        };-->

<!--    },-->
<!--    mounted() {-->
<!--        this.fetchUserPhotos();-->
<!--    },-->
<!--    methods: {-->
<!--        async fetchUserPhotos() {-->
<!--            try {-->
<!--                const response = await axios.get('/user/photos', {-->
<!--                    params: {-->
<!--                        userId: usePage().props.auth.user.id-->
<!--                    }-->
<!--                });-->

<!--                // Transformez les données de la réponse-->
<!--                this.utilisateur.photos = response.data.data.map(photo => ({-->
<!--                    id: photo.id,-->
<!--                    url: `/storage/app/public/photos/${photo.nom}`, // Assurez-vous que le chemin est correct-->
<!--                    description: photo.legende || 'Sans légende'-->
<!--                }));-->
<!--            } catch (error) {-->
<!--                console.error('Erreur lors de la récupération des photos:', error);-->
<!--                // Optionnel : gérer l'erreur (message à l'utilisateur, etc.)-->
<!--            }-->
<!--        },-->
<!--        toggleMenu(menu) {-->
<!--            this.activeMenu = menu;-->
<!--        },-->
<!--        changeDescription(newDescription) {-->
<!--            this.utilisateur.description = newDescription;-->
<!--        },-->
<!--        updateDescription() {-->
<!--            this.changeDescription(this.newDescription);-->
<!--            this.showDescriptionInput = false;-->
<!--            this.newDescription = '';-->
<!--        }-->
<!--    }-->
<!--};-->
<!--</script>-->

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

        <body>
        <div class="mon-compte">
            <!-- Banner -->
            <div class="banner">
                <!--<img :src="utilisateur.banner" alt="Banner Image" /> -->
            </div>

            <!-- Profile Picture and Name -->

            <div class="profile-header">
                <img src="../public/images/avatar.jpg" alt="Profile Picture" class="profile-picture"/>
                <h1>{{ user.nom }} {{ user.prenom }} </h1>

            </div>




            <!-- Profile Description -->
            <div class="profile-description">
                <p>{{ description }}</p> <br>

                <Link :href="route('profile.edit')" class="edit-button" >Modifier les informations</Link>

                <button class="edit-button" @click="showDescriptionInput = true">Changer votre description</button>
                <div v-if="showDescriptionInput" class="description-input">
                    <textarea v-model="newDescription" placeholder="Entrez une nouvelle description"></textarea>
                    <button class="edit-button" @click="updateDescription">Valider</button>
                </div>
            </div>

            <!-- Toggle Bar -->
            <div class="toggle-bar">
                <button :class="{'active': activeMenu === 'photos'}" @click="toggleMenu('photos')">Photos</button>
                <button :class="{'active': activeMenu === 'evenements'}" @click="toggleMenu('evenements')">Événements</button>
            </div>

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
                <div v-if="loading" class="loading-icon">
                    <h1>Chargement des événements...</h1>
                    <img src="../public/images/loading.gif" alt="Loading..." />
                </div>
                <div v-else>
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
                        />
                    </div>
                </div>
            </div>
        </div>
        </body>
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

.description-input {
    margin-top: 10px;
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


.banner {
    background-color: #838383;
    width: 60%;
    height: 200px;
    object-fit: cover;
    align-self: flex-start;
    border-bottom-right-radius: 1500px;
}

.profile-header {
    display: flex;
    align-items: center;
    align-self: flex-start;
    justify-content: space-between;
    width: 30%;
    margin-top: -50px;
    padding: 20px;

}
.photo_user {
    width: 300px; /* Set a fixed width */
    height: 200px; /* Set a fixed height */
    object-fit: cover; /* Ensure the image covers the area while maintaining aspect ratio */
    border-radius: 8px;
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



.profile-description {
    margin-left: 10px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    margin-top: 20px;
    width: 60%;
    align-self: flex-start;
    border: 1px solid black;
}

.toggle-bar {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.toggle-bar button.active {
    background-color: #426580;
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


.edit-button {
    padding: 10px 15px;
    margin: 5px;
    border-radius: 5px;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.5s;
}

.edit-button:hover {
    background-color: #ff9900;
}
.events-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin: 10px;
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
