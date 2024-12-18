<template>
    <div class="main-app">
        <PhotoPost
            v-for="post in posts"
            :key="post.id_post"
            :idPost="post.id_post"
            :username="post.user.pseudo"
            :userAvatar="post.user.photo_de_profile"
            :postTime="formatCreatedAt(post.created_at)"
            :imageUrl="post.photos"
            :caption="post.Légende"
            :tags="post.tags"
            :comments="this.commentaires"
            @add-comment="addComment(post.id, $event)"
        />
    </div>
</template>

<script>
import PhotoPost from './PhotoPost.vue';
import {fetchPosts} from "@/Services/postService.js";
import {fetchCommentairesPosts} from "@/Services/commentairePostService.js";
import {formatDistance} from "date-fns";
import {fr} from "date-fns/locale";

export default {
    components: {
        PhotoPost,
    },
    data() {
        return {
            posts: [],
            commentaires: [],
        };
    },
    async mounted() {
        try {
            this.posts = await fetchPosts(); // Appel de l'API
            this.commentaires = await fetchCommentairesPosts(); // Appel de l'API
            // console.log(this.commentaires);
            console.log(this.posts);

        } catch (error) {
            console.error("Erreur lors du chargement des données :", error);
        }
    },
    methods: {
        addComment(postId, comment) {
            const post = this.posts.find(post => post.id === postId);
            post.comments.push(comment);
        },
        getComments(postId) {
            return this.commentaires.filter(comment => comment.id_post === postId);
        },
        formatCreatedAt(date) {
            return formatDistance(new Date(date), new Date(), {
                addSuffix: true,
                locale: fr
            })
        },
    },
};

// NE FONCTIONNE PAS...
let lastScrollY = window.scrollY;
const navbar = () => document.querySelector('nav');

window.addEventListener('scroll', () => {
    // Cacher la navbar quand on descend
    if (window.scrollY > lastScrollY) {
        navbar.classList.add('hidden');
    }
    // Réafficher la navbar quand on remonte
    else {
        navbar.classList.remove('hidden');
    }
    lastScrollY = window.scrollY;
});

// Réafficher si la souris atteint le haut de l'écran
document.addEventListener('mousemove', (e) => {
    if (e.clientY < 50) {
        navbar.classList.remove('hidden');
    }
});
</script>

<style>
* {
    font-family: 'Open Sans', sans-serif;
}

nav {
    position: fixed;
    width: 100%;
    display: flex;
    justify-content: space-between;
    z-index: 10;
    transition: transform 0.3s ease-in-out; /* Animation douce */
}

nav.hidden {
    transform: translateY(-100%); /* Cache la navbar hors de l'écran */
}

header {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #333;
    color: white;
    font-size: 1.5rem;
    font-weight: bold;
    text-transform: uppercase;
    width: 100%;
}

/* Styles globaux pour ton application */
.main-app {
    /* Ajoute ici les styles pour structurer ton composant */
    display: grid;
    flex-direction: column;
    justify-items: center;
}
</style>
