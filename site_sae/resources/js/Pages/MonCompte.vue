<script setup>

import {Head, Link, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Footer from "@/Components/Footer.vue";
import {usePage} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";

const userDemanderId = usePage().props.id ? usePage().props.id : null;
const photos = ref([]);
const loading = ref(true);
let utilisateur = usePage().props.auth.user;

const form = useForm({
    id: utilisateur.id,
    nom: utilisateur.nom,
    prenom: utilisateur.prenom,
    pseudo: utilisateur.pseudo,
    email: utilisateur.email,
    photo: utilisateur.photo_de_profil,
});
const activeMenu = ref('photos');
const showDescriptionInput= ref(false);
const newDescription= ref('');
const description = ref('Ceci est la description du profil.');

const fetchUser = async (id) => {
    if(id != null) {
        console.log("id", id);
        try{
            let response;
            const utilisateurId = parseInt(id, 10); // Transforme id en integer
            response = await fetch(`http://127.0.0.1:8000/api/utilisateurs/${utilisateurId}`);
            const fetchedUser = await response.json();
            //Object.assign(utilisateur, fetchedUser);
            utilisateur = fetchedUser;
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
        console.log("Les evenements ont été récupérés :", photos.value);
    } catch (error) {
        console.error('Erreur lors de la récupération des événements:', error);
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
    fetchUser(userDemanderId);
    fetchPhotos();
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

        <body>
        <div class="mon-compte">
            <!-- Banner -->
            <div class="banner">
                <!--<img :src="utilisateur.banner" alt="Banner Image" /> -->
            </div>

            <!-- Profile Picture and Name -->

            <div class="profile-header">
                <img src="../public/images/avatar.jpg" alt="Profile Picture" class="profile-picture"/>
                <h1>{{ utilisateur.nom }} {{ utilisateur.prenom }} </h1>

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
                <h2>Photos</h2>
                <div class="photos-grid">
                    <div v-for="photo in photos.data" :key="photo.id_photo" class="photo-item">
                        <div>
                            <img :src="`/storage/${photo.nom}`" alt="Photo" class="photo_user"/>
                            <p>{{ photo.legende }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="activeMenu === 'evenements'" class="posted-events">
                <h2>Événements</h2>
                <!-- Add your events display logic here -->

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
</style>
