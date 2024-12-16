<template>
    <div class="photo-post">
        <div class="post">
            <div class="post-header">
                <img src="../../public/images/avatar.jpg" alt="Avatar" class="avatar"/>
                <div class="user-info">
                    <h4 class="username">{{ username }}</h4>
                    <p class="post-time">{{ postTime }}</p>
                </div>
            </div>
            <img src="../../public/images/image1.jpg" alt="Photo" class="post-image"/>
            <div class="post-caption">
                <p>{{ caption }}</p>
                <div class="tags">
                    <span v-for="tag in tags" :key="tag" class="tag">{{ tag }}</span>
                </div>
            </div>
        </div>
        <div class="comments">
            <CommentsSection :comments="this.comments.filter(comment => comment.id_post === this.idPost)"/>
        </div>
    </div>
</template>

<script>
import CommentsSection from './CommentsSection.vue';
import {nextTick} from 'vue';

export default {
    props: {
        idPost: Number,
        username: String,
        userAvatar: String,
        postTime: String,
        imageUrl: String,
        caption: String,
        tags: Array,
        comments: Array,
    },
    components: {
        CommentsSection,
    },
    async mounted() {
        nextTick(() => {
            this.setHeight();
        });
    },
    methods: {
        setHeight() {
            const postElement = this.$el.querySelector('.post');
            if (postElement) {
                const heightPost = postElement.offsetHeight;
                const commentsElement = this.$el.querySelector('.comments');
                if (commentsElement) {
                    commentsElement.style.maxHeight = `${heightPost}px`;
                    commentsElement.style.height = `${heightPost}px`;
                    document.querySelector('.comments-section').style.height = `${heightPost}px`;
                    document.querySelector('.comments-section').style.minHeight = `${heightPost}px`;
                    document.querySelector('.comments-section').style.maxHeight = `${heightPost}px`;
                }
            } else {
                console.error("L'élément avec la classe .post n'existe pas.");
            }
        }
    }
};

</script>

<style scoped>
* {
    font-family: 'Open Sans', sans-serif;
}

.photo-post {
    /* Styles pour le post */
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    padding: 20px;
    margin: 10px 0;
    font-size: small;
}

.post {
    /* Styles pour le post */
    width: 40rem;
    display: flex;
    flex-direction: column;
    border: 1px solid #ccc;
    border-radius: 0.5rem;
    background-color: white;
}

.post-header {
    /* Styles pour l'en-tête du post */
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 12px;
}

.avatar {
    /* Styles pour l'avatar */
    width: 2.4rem;
    height: 2.4rem;
    border-radius: 50%;
    margin-right: 12px;
}

.user-info {
    display: flex;
    flex-direction: column;
    align-items: start;
    justify-content: center;
}

.username {
    /* Styles pour le nom d'utilisateur */
    font-weight: bold;
}

.post-time {
    /* Styles pour le temps du post */
    font-size: 0.9em;
    color: #777;
}

.post-image {
    /* Styles pour l'image */
    width: 100%;
    height: auto;
}

.post-caption {
    /* Styles pour la légende */
    margin-inline: 12px;
    margin-block: 12px;

}

.tags {
    /* Styles pour les tags */
    display: flex;
    gap: 8px;
    margin-top: 8px;
}

.tag {
    /* Styles pour un tag */
    background-color: #f0f0f0;
    padding: 0.2rem 0.5rem;
    border-radius: 0.3rem;
}

.comments {
    /* Styles pour la section des commentaires */
    gap: 0.1rem;
    min-height: 100%;
    width: 25rem;
}

@media (max-width: 1090px) {
    .photo-post {
        flex-direction: column;
        justify-content: start;
    }

    .comments {
        width: 40rem;
    }
}

@media (max-width: 725px) {
    .photo-post {
        flex-direction: column;
        justify-content: start;
    }

    .post {
        width: 100%;
        height: min-content;
    }

    .comments {
        width: 100%;
    }
}
</style>
