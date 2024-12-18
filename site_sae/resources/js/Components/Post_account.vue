<template>
    <div class="photo-post">
        <div class="post">
            <div v-if="context==='feed'" class="post-header">
                <img src="../public/images/avatar.jpg" alt="Avatar" class="avatar"/>
                <div class="user-info">
                    <h4 class="username">{{ username }}</h4>
                    <p class="post-time">{{ postTime }}</p>
                </div>
            </div>
            <div class="post-images">
                <img :src="imageUrl[currentImageIndex].chemin" alt="Photo du photographe" class="post-image"/>
                <button class="nav-arrow left" @click="prevImage">&#9664;</button>
                <button class="nav-arrow right" @click="nextImage">&#9654;</button>
            </div>
            <div class="post-caption">
                <p>{{ caption }}</p>
                <div class="tags">
                    <span v-for="tag in tags" :key="tag" class="tag">{{ tag }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { nextTick } from 'vue';

export default {
    props: {
        idPost: Number,
        username: String,
        userAvatar: String,
        postTime: String,
        imageUrl: Array,
        caption: String,
        tags: Array,
        comments: Array,
        context: String,
    },
    data() {
        return {
            currentImageIndex: 0,
        };
    },
    /*
    async mounted() {
        nextTick(() => {
            this.setHeight();
        });
        console.log(this.imageUrl);
    },

     */
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
        },

        nextImage() {
            if (this.currentImageIndex < this.imageUrl.length - 1) {
                this.currentImageIndex++;
            } else {
                this.currentImageIndex = 0;
            }
        },
        prevImage() {
            if (this.currentImageIndex > 0) {
                this.currentImageIndex--;
            } else {
                this.currentImageIndex = this.imageUrl.length - 1;
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
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    padding: 20px;
    margin: 10px 0;
    font-size: small;
    max-width: 100%;
    box-sizing: border-box;
}

.post {
    width: 100%;
    max-width: 600px;
    display: flex;
    flex-direction: column;
    border: 1px solid #ccc;
    border-radius: 0.5rem;
    background-color: white;
    overflow: hidden;
    height: 400px; /* Fixed height for the post */
}

.post-header {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 12px;
}

.avatar {
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
    font-weight: bold;
}

.post-time {
    font-size: 0.9em;
    color: #777;
}

.post-images {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    height: 100%; /* Ensure the images container takes up the remaining height */
}

.post-image {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures the image covers the container */
}

.nav-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    z-index: 1;
}

.nav-arrow.left {
    left: 10px;
}

.nav-arrow.right {
    right: 10px;
}

.post-caption {
    margin: 12px;
}

.tags {
    display: flex;
    gap: 8px;
    margin-top: 8px;
}

.tag {
    background-color: #f0f0f0;
    padding: 0.2rem 0.5rem;
    border-radius: 0.3rem;
}

.comments {
    gap: 0.1rem;
    width: 100%;
    box-sizing: border-box;
}

@media (max-width: 1090px) {
    .photo-post {
        flex-direction: column;
        justify-content: start;
    }

    .comments {
        width: 100%;
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
