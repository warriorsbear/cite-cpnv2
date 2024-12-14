<template>
    <div class="main-app">
        <PhotoPost
            v-for="post in posts"
            :key="post.id"
            :username="post.user.pseudo"
            :userAvatar="post.user.photo_de_profile"
            :postTime="post.created_at"
            :imageUrl="post.photos.chemin"
            :caption="post.Légende"
            :tags="post.tags"
            :comments="post.comments"
            @add-comment="addComment(post.id, $event)"
        />
    </div>
</template>

<script>
import PhotoPost from './PhotoPost.vue';
import {fetchPosts} from "@/Services/postService.js";
import {fetchCommentairesPosts} from "@/Services/commentairePostService.js";

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
        } catch (error) {
            console.error("Erreur lors du chargement des données :", error);
        }
    },
    methods: {
        addComment(postId, comment) {
            const post = this.posts.find(post => post.id === postId);
            post.comments.push(comment);
        },
    },
};
</script>

<style>
* {
    font-family: 'Open Sans', sans-serif;
}

/* Styles globaux pour ton application */
.main-app {
    /* Ajoute ici les styles pour structurer ton composant */
    display: grid;
    flex-direction: column;
    justify-items: center;
}
</style>
