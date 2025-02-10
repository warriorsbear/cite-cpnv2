<template>
    <div v-if="isModalOpen" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="title">Séance de Visionnage</h2>
                <button @click="closeModal" class="close-button">
                    <span>&times;</span>
                </button>
            </div>

            <div v-if="photos.length > 0" class="photo-display">
                <div class="photo-container">
                    <img :src="currentPhoto.url" alt="Photo" class="main-photo">
                </div>

                <div class="info-section">
                    <p class="date">{{ formatDate(currentPhoto.date_prise) }}</p>

                    <div v-if="isAuthorRevealed" class="author-info">
                        <p>Par {{ currentPhoto.auteur.prenom }} {{ currentPhoto.auteur.nom }}</p>
                    </div>

                    <div class="progress">
                        {{ currentIndex + 1 }} / {{ photos.length }}
                    </div>
                </div>

                <div class="controls">
                    <button v-if="!isAuthorRevealed"
                            @click="revealAuthor"
                            class="button reveal-button">
                        Révéler l'auteur
                    </button>
                    <button v-if="currentIndex+1 < photos.length"
                            @click="nextPhoto"
                            class="button next-button">
                        Suivante
                    </button>
                    <button @click="closeModal"
                            class="button close-modal-button">
                        Terminer
                    </button>
                </div>
            </div>

            <div v-else class="no-photos">
                <p>Aucune photo disponible pour ce visionnage.</p>
            </div>
        </div>
    </div>
</template>

<script>
// Le script reste identique
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
    background-color: rgba(0, 0, 0, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: white;
    border-radius: 12px;
    width: 90%;  /* Réduit de 95% à 90% */
    height: 90vh; /* Hauteur fixe de 90% de la hauteur de la fenêtre */
    max-width: 900px; /* Réduit de 1000px à 900px */
    position: relative;
    display: flex;
    flex-direction: column;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.modal-header {
    padding: 15px 20px; /* Réduit le padding */
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
}

.title {
    font-size: 1.3rem; /* Réduit de 1.5rem */
    color: #333;
    margin: 0;
    font-weight: 600;
}

.close-button {
    background: none;
    border: none;
    font-size: 24px; /* Réduit de 28px */
    color: #666;
    cursor: pointer;
    padding: 0 8px;
    transition: color 0.2s;
}

.close-button:hover {
    color: #333;
}

.photo-display {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding: 15px;
    overflow-y: auto;
}

.photo-container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f8f8f8;
    border-radius: 8px;
    overflow: hidden;
    min-height: 0; /* Important pour le flex */
}

.main-photo {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.info-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10px;
    color: #666;
    flex-shrink: 0;
}

.date {
    margin: 0;
    font-size: 0.9rem;
}

.author-info {
    text-align: center;
    font-weight: 500;
}

.progress {
    font-size: 0.9rem;
    color: #999;
}

.controls {
    display: flex;
    gap: 10px;
    justify-content: center;
    padding: 10px;
    flex-shrink: 0;
}

.button {
    padding: 8px 20px; /* Réduit de 10px 24px */
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.9rem; /* Réduit de 0.95rem */
    font-weight: 500;
    transition: all 0.2s ease;
}

.reveal-button {
    background-color: #d68f26;
    color: white;
}

.reveal-button:hover {
    background-color: #c48322;
}

.next-button {
    background-color: #f0f0f0;
    color: #333;
}

.next-button:hover {
    background-color: #e5e5e5;
}

.close-modal-button {
    background-color: #dc2626;
    color: white;
}

.close-modal-button:hover {
    background-color: #c72121;
}

.no-photos {
    padding: 30px;
    text-align: center;
    color: #666;
}

@media (max-width: 640px) {
    .modal-content {
        width: 100%;
        height: 100vh;
        border-radius: 0;
    }

    .controls {
        flex-direction: column;
        padding: 10px 15px;
    }

    .button {
        width: 100%;
    }

    .info-section {
        flex-direction: column;
        gap: 8px;
        text-align: center;
    }
}
</style>
