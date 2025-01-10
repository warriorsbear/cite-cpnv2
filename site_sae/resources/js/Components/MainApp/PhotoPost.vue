<template>
    <div class="photo-post">
        <div class="post">
            <div class="post-header">
                <div class="post-header-user">
                    <img :src="userAvatar" alt="Avatar" class="avatar"/>
                    <div class="user-info">
                        <h4 class="username">{{ username }}</h4>
                        <p class="post-time">{{ postTime }}</p>
                    </div>
                </div>
                <div>
                    <button @click="toggleDropdown">...</button>
                    <div v-if="isDropdownOpen" class="dropdown-menu">
                        <button @click="downloadPhoto">Télécharger la photo</button>
                        <button @click="viewExifData">Voir les données EXIF</button>
                    </div>
                    <div v-if="isEXIFOpen && isDropdownOpen" class="dropdown-menu exif-menu">
                        <button @click="toggleDropdown">Fermer</button>
                        <div>
                            <p>Boitier : {{ imageUrl[0].exif1 }}</p>
                            <p>Objectif : {{ imageUrl[0].exif2 }}</p>
                            <p>Distance focale : {{ imageUrl[0].exif3 }}</p>
                            <p>Ouverture : {{ imageUrl[0].exif4 }}</p>
                            <p>Vitesse d'obturation : {{ imageUrl[0].exif5 }}</p>
                            <p>ISO : {{ imageUrl[0].exif6 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <img v-if="processedImages.length === 0" :src="imageUrl[0] ? imageUrl[0].chemin : 'http://127.0.0.1:8000/storage/photos/renault.jpg'"
                 alt="Photo du photographe" class="post-image"/>
            <div class="post-images" v-if="processedImages.length > 0">
                <img
                    :src="processedImages[currentImageIndex]"
                    :alt="`Photo ${currentImageIndex + 1}`"
                    class="post-image"
                />
                <button
                    v-if="processedImages.length > 1"
                    class="nav-arrow left"
                    @click="prevImage"
                >&#9664;</button>
                <button
                    v-if="processedImages.length > 1"
                    class="nav-arrow right"
                    @click="nextImage"
                >&#9654;</button>
            </div>
            <div class="post-caption">
                <p>{{ caption }}</p>
                <div class="tags">
                    <span v-for="tag in tags" :key="tag" class="tag">{{ tag }}</span>
                </div>
            </div>
        </div>
        <div class="comments">
            <CommentsSection
                :comments="this.comments.filter(comment => comment.id_post === this.idPost)"
                :postId="this.idPost"
            />
        </div>
    </div>
</template>

<script>
import CommentsSection from './CommentsSection.vue';
import {computed, nextTick, ref} from 'vue';

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
    components: {
        CommentsSection,
    },
    data() {
        return {
            isDropdownOpen: false,
            isEXIFOpen: false,
        };
    },
    async mounted() {
        nextTick(() => {
            this.setHeight();
        });
    },
    setup(props) {
        const currentImageIndex = ref(0);
        const processedImages = computed(() => {
            if (!props.imageUrl) return [];
            return props.imageUrl.map(img => {
                if (typeof img === 'string') return img;
                if (img && img.chemin) return img.chemin;
                return null;
            }).filter(Boolean);
        });
        const nextImage = () => {
            if (currentImageIndex.value < processedImages.value.length - 1) {
                currentImageIndex.value++;
            } else {
                currentImageIndex.value = 0;
            }
        };
        const prevImage = () => {
            if (currentImageIndex.value > 0) {
                currentImageIndex.value--;
            } else {
                currentImageIndex.value = processedImages.value.length - 1;
            }
        };
        return {
            currentImageIndex,
            processedImages,
            nextImage,
            prevImage
        };
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
        },
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
            this.isEXIFOpen = false;
        },
        downloadPhoto() {
            const link = document.createElement('a');
            link.href = this.imageUrl[0] ? this.imageUrl[0].chemin : 'http://127.0.0.1:8000/storage/photos/renault.jpg';
            link.download = 'photo.jpg';
            link.click();
        },
        viewExifData() {
            this.isEXIFOpen = !this.isEXIFOpen;
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
    justify-content: space-between;
    align-items: center;
    padding: 12px;
}

.post-header-user {
    display: flex;
    align-items: center;
}

.post-header button {
    /* Styles pour le bouton de menu */
    background: none;
    border: none;
    cursor: pointer;
    margin-right: 0.5rem;
    font-size: 0.9rem;
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

.dropdown-menu {
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 0.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    padding: 10px;
    width: 200px;
}

.dropdown-menu button {
    display: block;
    width: 100%;
    padding: 10px;
    text-align: left;
    border: none;
    background: none;
    cursor: pointer;
}

.dropdown-menu button:hover {
    background-color: #f0f0f0;
}

.exif-menu {
    padding: 15px;
    width: auto;
}

.exif-menu .close-button {
    background-color: #ff4d4d;
    color: white;
    border-radius: 0.3rem;
    margin-bottom: 10px;
}

.exif-menu .close-button:hover {
    background-color: #ff1a1a;
}

.exif-menu .exif-data p {
    margin: 5px 0;
    font-size: 0.9rem;
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
    height: auto;
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
