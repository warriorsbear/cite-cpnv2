<script setup >
import { Head, Link } from '@inertiajs/vue3';
import Footer from "@/Components/Footer.vue";
import guest from "@/Layouts/GuestLayout.vue";
import newheaderauthentifie from "@/Layouts/newheaderauthentifie.vue";
import NavLink from "@/Components/NavLink.vue";
import Header from "@/Components/Header.vue";

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
</script>

<template>
    <Head title="Bienvenue - Club Photo Nailloux" />

    <main>
        <!-- Section principale avec image et introduction -->
        <section class="main-section">
            <div class="container">
                <div class="main-content">
                    <!-- Image principale (alignée à gauche) -->
                    <div class="main-image">
                        <img src="../public/images/images/inox2.png" alt="Présentation du club photo" />
                    </div>

                    <!-- Texte d'introduction (aligné à droite) -->
                    <div class="main-text">
                        <h2>Bienvenue au Club Photo Nailloux</h2>
                        <p>
                            Partageons notre passion pour la photographie et capturons des moments
                            inoubliables ensemble. Rejoignez-nous pour explorer la magie de
                            l'art photographique.
                        </p>
                        <Link :href="route('register')" class="btn login-btn" >S'inscrire</Link>
                        <Link :href="route('login')" class="btn" >Se connecter</Link>
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

        <!-- Section Galerie avec trois photos alignées -->
        <section class="gallery-section">
            <div class="container">
                <h3>Nos Activités en Images</h3>
                <div class="gallery-grid">
                    <div class="gallery-item">
                        <img src="../public/images/images/inox2.png" alt="Sortie photo nature" />
                        <p>Sortie Photo Nature</p>
                    </div>
                    <div class="gallery-item">
                        <img src="../public/images/images/inox2.png" alt="Atelier studio photo" />
                        <p>Atelier Studio</p>
                    </div>
                    <div class="gallery-item">
                        <img src="../public/images/images/inox2.png" alt="Évènement photo de groupe" />
                        <p>Événements</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <Footer />
</template>

<style scoped>
main {
    margin-left: 1rem;
    margin-right: 1rem;
}

/* Section principale avec image et texte */
.main-section {
    padding: 60px 0;
    background-color: #fff;
}

.main-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.main-image img {
    max-width: 100%;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}

.main-text {
    max-width: 50%;
}

.main-text h2 {
    font-size: 2.5rem;
    color: #333;
    margin-bottom: 20px;
}

.main-text p {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 30px;
}

.btn {
    display: inline-block;
    background-color: #ff6600;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    margin-right: 10px;
}

.btn:hover {
    background-color: #000;
}

.login-btn {
    background-color: #333;
}

.login-btn:hover {
    background-color: #000;
}

/* Section Qui Sommes Nous */
.about-section {
    padding: 60px 0;
    background-color: #f5f5f5;
    text-align: center;
}

.about-section h3 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 20px;
}

.about-section p {
    font-size: 1.2rem;
    color: #666;
    max-width: 800px;
    margin: 0 auto;
}

/* Section Galerie */
.gallery-section {
    padding: 60px 0;
    background-color: #f9f9f9;
    text-align: center;
}

.gallery-section h3 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 40px;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.gallery-item img {
    width: 100%;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

.gallery-item img:hover {
    transform: scale(1.1);
}

.gallery-item p {
    margin-top: 10px;
    font-size: 1rem;
    color: #333;
    text-align: center;
}
</style>
