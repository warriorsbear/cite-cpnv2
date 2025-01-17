<template>
    <div v-if="isModalOpen" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Séance de Visionnage</h2>
                <button @click="closeModal" class="close-button">&times;</button>
            </div>

            <div v-if="photos.length > 0" class="photo-display">
                <img :src="currentPhoto.url" alt="Photo" class="main-photo">
                <p>Date de prise: {{ formatDate(currentPhoto.date_prise) }}</p>

                <div v-if="isAuthorRevealed" class="author-info">
                    <p>Auteur: {{ currentPhoto.auteur.prenom }} {{ currentPhoto.auteur.nom }}</p>
                </div>

                <div class="controls">
                    <button v-if="!isAuthorRevealed" @click="revealAuthor" class="reveal-button">
                        Révéler l'auteur
                    </button>
                    <button v-if="currentIndex+1 < photos.length" @click="nextPhoto" class="next-button">
                        Photo suivante
                    </button>

                    <button @click="closeModal" class="fermer-button">
                        Fermer
                    </button>
                </div>

                <div class="progress">
                    Photo {{ currentIndex + 1 }} sur {{ photos.length }}
                </div>
            </div>

            <div v-else class="no-photos">
                Aucune photo disponible pour ce visionnage.
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isModalOpen: {
            type: Boolean,
            required: true
        },
        id_visionnage: {
            type: Number,
            required: true
        }
    },

    data() {
        return {
            photos: [],
            currentIndex: 0,
            isAuthorRevealed: false
        }
    },

    computed: {
        currentPhoto() {
            return this.photos[this.currentIndex] || {}
        }
    },

    methods: {
        async startVisionnage() {
            try {
                const response = await fetch(`/api/visionnage/start/${this.id_visionnage}`)
                const data = await response.json()
                this.photos = data.photos
            } catch (error) {
                console.error('Erreur lors du démarrage du visionnage:', error)
            }
        },

        closeModal() {
            this.$emit('close')
        },

        revealAuthor() {
            this.isAuthorRevealed = true
        },

        nextPhoto() {
            if (this.currentIndex < this.photos.length - 1) {
                this.currentIndex++
                this.isAuthorRevealed = false
            } else {
                this.closeModal()
            }
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString('fr-FR')
        }
    },

    mounted() {
        this.startVisionnage()
    }
}
</script>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    max-width: 800px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
}

.photo-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.main-photo {
    max-width: 100%;
    max-height: 60vh;
    object-fit: contain;
}

.controls {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.reveal-button, .next-button, .fermer-button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s;
}

.reveal-button {
    background-color: #d68f26;
    color: white;
}

.next-button {
    background-color: #5bc0de;
    color: white;
}

.fermer-button {
    background-color: #ed2a2a;
    color: white;
}

.progress {
    margin-top: 20px;
    color: #666;
}

.close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    border: none;
    background: none;
    cursor: pointer;
}
</style>
