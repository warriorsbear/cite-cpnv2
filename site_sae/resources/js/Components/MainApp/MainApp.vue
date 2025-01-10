<template>
    <div class="main-app">
        <PhotoPost
            v-for="post in posts"
            :key="post.id_post"
            :idPost="post.id_post"
            :username="post.user.pseudo"
            :userAvatar="post.user.photo_de_profil"
            :postTime="formatCreatedAt(post.created_at)"
            :imageUrl="post.photos"
            :caption="post.Légende"
            :tags="post.tags"
            :comments="this.commentaires"
            @add-comment="addComment(post.id, $event)"
            :context="'feed'"
        />
    </div>
    <div v-if="loading" class="loading">Chargement...</div>
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
            page: 1,
            loading: false,
            allLoaded: false,
        };
    },
    async mounted() {
        try {
            await this.loadPosts();
            this.commentaires = await fetchCommentairesPosts(); // Appel de l'API
            window.addEventListener('scroll', this.handleScroll);
        } catch (error) {
            console.error("Erreur lors du chargement des données :", error);
        }
    },
    beforeDestroy() {
        window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        async loadPosts() {
            if (this.loading || this.allLoaded) return;
            this.loading = true;
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/fetch-posts?page=${this.page}`);
                const newPosts = response.data.data;
                if (newPosts.length > 0) {
                    this.posts = [...this.posts, ...newPosts];
                    this.page++;
                } else {
                    this.allLoaded = true;
                }
            } catch (error) {
                console.error("Error lors du chargement des posts:", error);
            } finally {
                this.loading = false;
            }
        },
        handleScroll() {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500) {
                this.loadPosts();
            }
        },
        formatCreatedAt(date) {
            return formatDistance(new Date(date), new Date(), {
                addSuffix: true,
                locale: fr
            })
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

.loading {
    text-align: center;
    margin: 20px 0;
}
</style>
