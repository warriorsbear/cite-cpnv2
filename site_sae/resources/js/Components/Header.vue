<template>
    <header class="app-header">
        <div class="logo-container">
            <Link :href="route('dashboard')">
                <img src="../public/images/logo-CPN-Noir.png" alt="Logo de l'association" class="logo">
            </Link>
        </div>
        <button class="menu-toggle" @click="toggleMenu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <div v-if="estConnecte" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Accueil</NavLink>
            <NavLink :href="route('evenement')" :active="route().current('evenement')">Événement</NavLink>
            <NavLink :href="route('messagerie')" :active="route().current('messagerie')">Messagerie</NavLink>
            <NavLink :href="route('profile.edit')" :active="route().current('profile.edit')">Mon compte</NavLink>
        </div>
        <div v-else class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <NavLink :href="route('contact')" :active="route().current('contact')">Contact</NavLink>
            <NavLink :href="route('login')" :active="route().current('login')">Connexion</NavLink>
            <NavLink :href="route('register')" :active="route().current('register')">Inscription</NavLink>
        </div>
    </header>
</template>

<script>
import NavLink from "@/Components/NavLink.vue";
import { Link } from "@inertiajs/vue3";

export default {
    components: { Link, NavLink },
    props: {
        logoUrl: {
            type: String,
            required: true
        },
        estConnecte: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            isMenuOpen: false
        };
    },
    methods: {
        toggleMenu() {
            this.isMenuOpen = !this.isMenuOpen;
        }
    }
};
</script>

<style scoped>
.app-header {
    background: linear-gradient(to right, #ffffff, #d79026);
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-family: 'Poppins', sans-serif;
    position: relative;
}

.logo-container {
    display: flex;
    align-items: center;
}

.logo {
    height: 60px;
    margin-right: 15px;
}

.button-container {
    display: flex;
    gap: 10px;
}

.header-button {
    background: none;
    border: none;
    color: #2b3033;
    font-weight: bold;
    font-size: 16px;
    cursor: pointer;
    padding: 10px 20px;
    text-decoration: none;
}

.header-button:hover {
    text-decoration-line: underline;
}

.menu-toggle {
    display: none;
    flex-direction: column;
    justify-content: space-around;
    width: 30px;
    height: 30px;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
}

.menu-toggle .bar {
    width: 100%;
    height: 3px;
    background-color: #2b3033;
    border-radius: 10px;
}

.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 5;
}

@media (max-width: 768px) {
    .app-header {
        flex-direction: row;
        justify-content: space-between;
    }

    .button-container {
        position: fixed;
        top: 0;
        right: 0;
        height: 100%;
        width: 250px;
        background-color: #ffffff;
        flex-direction: column;
        align-items: flex-start;
        padding: 20px;
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
        z-index: 10;
    }

    .button-container.menu-open {
        transform: translateX(0);
    }

    .header-button {
        width: 100%;
        text-align: left;
        padding: 10px 0;
        font-size: 16px;
        display: block;
    }

    .menu-toggle {
        display: flex;
    }
}
</style>
