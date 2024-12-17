<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Footer from "@/Components/Footer.vue";
import Header from "@/Components/Header.vue";
import ImageModale from "@/Components/ImageModale.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const modalVisible = ref(false);
const selectedImage = ref({ src: '', description: '' });

const openModal = (src, description) => {
    selectedImage.value = { src, description };
    modalVisible.value = true;
};

const closeModal = () => {
    modalVisible.value = false;
};
</script>

<template>
    <Head title="Bienvenue - Club Photo Nailloux" />
    <!-- En-tête -->
    <Header logo-url="../public/images/logo.png" :est-connecte="false" />

    <!-- Contenu principal -->
    <main>
        <!-- Section principale -->
        <section class="main-section">
            <div class="container">
                <div class="main-content">
                    <div class="main-image">
                        <img src="../public/images/_DSC3514.JPG" alt="Présentation du club photo" @click="openModal('../public/images/_DSC3514.JPG', 'Présentation du club photo')" />
                    </div>
                    <div class="main-text">
                        <h2>Bienvenue au Club Photo Nailloux</h2>
                        <p>
                            Partageons notre passion pour la photographie et capturons des moments
                            inoubliables ensemble. Rejoignez-nous pour explorer la magie de
                            l'art photographique.
                        </p>
                        <div class="btn-group">
                            <Link :href="route('register')" class="btn orange-btn">S'inscrire</Link>
                            <Link :href="route('login')" class="btn black-btn">Se connecter</Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Qui Sommes Nous -->
        <section class="about-section">
            <div class="container">
                <h3>Qui Sommes Nous ?</h3>
                <p>
                    Le Club Photo Nailloux est une communauté de passionnés de photographie
                    qui se réunit pour partager des connaissances, organiser des sorties et
                    des ateliers, et capturer des moments inoubliables. Nous accueillons
                    des photographes de tous niveaux, des débutants aux professionnels.
                </p>
            </div>
        </section>

        <!-- Section Activités -->
        <section class="gallery-section">
            <div class="container">
                <h3>Nos Activités en Images</h3>
                <div class="gallery-grid">
                    <div class="gallery-item" @click="openModal('../public/images/_DSC3283.JPG', 'Sortie Photo Nature')">
                        <img src="../public/images/_DSC3283.JPG" alt="Sortie photo nature" />
                        <p>Sortie Photo Nature</p>
                    </div>
                    <div class="gallery-item" @click="openModal('../public/images/_DSC3497.JPG', 'Atelier Studio')">
                        <img src="../public/images/_DSC3497.JPG" alt="Atelier studio photo" />
                        <p>Atelier Studio</p>
                    </div>
                    <div class="gallery-item" @click="openModal('../public/images/_DSC3514.JPG', 'Événements')">
                        <img src="../public/images/_DSC3514.JPG" alt="Évènement photo de groupe" />
                        <p>Événements</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Pied de page -->
    <Footer />
    <ImageModale
        :visible="modalVisible"
        :imageSrc="selectedImage.src"
        :description="selectedImage.description"
        @close="closeModal"
    />
</template>

<style scoped>
/* Réinitialisation des marges et espacements */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body, html {
    width: 100%;
    height: 100%;
    margin: 0;
}

/* Style du conteneur principal */
main {
    width: 100%;
    margin: 0 auto;
    text-align: center;
}

/* Style de chaque section */
section {
    width: 100%;
    padding: 60px 0;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Section principale */
.main-section {
    background-color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
}

.main-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 30px;
}

.main-image img {
    width: 100%;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    cursor: pointer;
}

.main-text {
    max-width: 500px;
    text-align: center;
}

.main-text h2 {
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 20px;
}

.main-text p {
    font-size: 1.2rem;
    color: #555;
    margin-bottom: 30px;
}

.btn-group {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.btn {
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s ease;
}

.orange-btn {
    background-color: #ff6600;
}

.orange-btn:hover {
    background-color: #333;
}

.black-btn {
    background-color: #000;
}

.black-btn:hover {
    background-color: #333;
}

/* Section Qui Sommes Nous */
.about-section {
    background-color: #f5f5f5;
    text-align: center;
}

.about-section h3 {
    font-size: 2rem;
    margin-bottom: 20px;
    color: #333;
}

.about-section p {
    font-size: 1.2rem;
    color: #555;
    max-width: 800px;
    margin: 0 auto;
}

/* Section Galerie */
.gallery-section {
    background-color: #fff;
    text-align: center;
}

.gallery-section h3 {
    font-size: 2rem;
    margin-bottom: 40px;
    color: #333;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}

.gallery-item img {
    width: 100%;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    cursor: pointer;
}

.gallery-item img:hover {
    transform: scale(1.05);
}

.gallery-item p {
    margin-top: 10px;
    font-size: 1rem;
    color: #333;
}
</style>
