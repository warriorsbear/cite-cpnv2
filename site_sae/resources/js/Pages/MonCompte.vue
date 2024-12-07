<script setup>

import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Footer from "@/Components/Footer.vue";
</script>

<script>
import Box_even from "@/Components/box_even.vue";
export default {
    components: {Box_even},
    data() {
        return {
            utilisateur: {
                photo: "http://[::1]:5173/resources/js/public/images/avatar.jpg",
                banner: "http://[::1]:5173/resources/js/public/images/baniere.png",
                nom: "Dupont",
                prenom: "Bertrand",
                description: "Ceci est la description du profil.",
                photos: [
                    {id: 1, url: "http://[::1]:5173/resources/js/public/images/image1.jpg", description: "Photo 1"},
                    {id: 2, url: "http://[::1]:5173/resources/js/public/images/image2.jpg", description: "Photo 2"},
                    {id: 3, url: "http://[::1]:5173/resources/js/public/images/image3.jpg", description: "Photo 3"},
                    {id: 4, url: "http://[::1]:5173/resources/js/public/images/image4.png", description: "Photo 4"},
                    // Add more photos as needed
                ]
            },
            activeMenu: 'photos',
            showDescriptionInput: false,
            newDescription: ''
        };
    },
    methods: {
        toggleMenu(menu) {
            this.activeMenu = menu;
        },
        changeDescription(newDescription) {
            this.utilisateur.description = newDescription;
        },
        updateDescription() {
            this.changeDescription(this.newDescription);
            this.showDescriptionInput = false;
            this.newDescription = '';
        }
    }
};
</script>

<template>
    <Head title="Fil d'actu" />

    <AuthenticatedLayout>

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Fil d'actu
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
                <img :src="utilisateur.photo" alt="Profile Picture" class="profile-picture"/>
                <h1>{{ utilisateur.nom }} {{ utilisateur.prenom }}</h1>

            </div>


            <!-- Profile Description -->
            <div class="profile-description">
                <p>{{ utilisateur.description }}</p> <br>
                <router-link to="/pageMesInformations">
                    <button class="edit-button">Modifier mes informations</button>
                </router-link>
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
                    <div v-for="photo in utilisateur.photos" :key="photo.id" class="photo-item">
                        <img :src="photo.url" :alt="photo.description"/>
                    </div>
                </div>
            </div>

            <div v-if="activeMenu === 'evenements'" class="posted-events">
                <h2>Événements</h2>
                <!-- Add your events display logic here -->
                <box_even titre_even="Exemple" image-path="http://[::1]:5173/resources/js/public/images/baniere.png" description="Description de l'événement" />

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

.profile-header h1 {
    text-align: left;
}

.profile-picture {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 3px solid white;
}

.profile-info {
    display: flex;
    align-items: center;
    gap: 20px;
    flex: 1;
    justify-content: space-between;
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

edit-button:hover {
    background-color: #ff9900;
}
</style>
