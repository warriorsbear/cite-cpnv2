<template>
    <div class="comments-section">
        <h4 class="comments-title">Commentaires</h4>
        <div class="comments-docker">
            <hr/>
            <div v-for="comment in localComments" :key="comment.id_commentaire_p" class="comment">
                <div class="user-info-comment">
                    <div class="user-info-left">
                        <img :src="comment.user.photo_de_profil" alt="Avatar commentaire" class="avatar-comments"/>
                        <p class="user-comments"><strong>{{ comment.user.pseudo }}</strong></p>
                    </div>
                    <p class="date-comments">{{ formatCreatedAt(comment.created_at) }}</p>
                </div>
                <p class="text-comments">{{ comment.texte }}</p>
            </div>
        </div>
        <div class="add-comment">
            <input
                v-model="newComment"
                placeholder="Ajouter un commentaire..."
                aria-label="Champ pour ajouter un commentaire"
            />
            <button @click="addComment">Commenter</button>
        </div>
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
    </div>
</template>

<script>
import axios from 'axios';
import {formatDistance} from "date-fns";
import {fr} from "date-fns/locale";
import {usePage} from "@inertiajs/vue3";

export default {
    props: {
        comments: {
            type: Array,
            required: true,
        },
        postId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            newComment: '',
            errorMessage: '',
            localComments: [...this.comments],
        };
    },
    watch: {
        comments: {
            handler(newComments) {
                this.localComments = [...newComments]; // Synchronisation si la prop change
            },
            deep: true,
        },
    },
    methods: {
        async addComment() {
            if (this.newComment.trim() !== '') {
                try {
                    const response = await axios({
                        url: 'http://192.168.10.57/api/commentaires',
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        data: {
                            texte: this.newComment,
                            id_post: this.postId,
                            id_utilisateur: usePage().props.auth.user.id,
                        },
                    });
                    const newComment = await response.data;
                    this.localComments.unshift({
                        id_commentaire_p: newComment.commentaire.id,
                        texte: newComment.commentaire.texte,
                        created_at: newComment.commentaire.created_at,
                        user: {
                            pseudo: usePage().props.auth.user.pseudo || 'Utilisateur inconnu',
                            photo_de_profil: usePage().props.auth.user.photo_de_profil || null,
                        },
                    });
                    this.newComment = '';
                } catch (error) {
                    if (error.response) {
                        // La requête a été faite et le serveur a répondu avec un code de statut
                        // qui tombe hors de la plage de 2xx
                        this.errorMessage = `Erreur ${error.response.status}: ${error.response.data.message}`;
                    } else if (error.request) {
                        // La requête a été faite mais aucune réponse n'a été reçue
                        this.errorMessage = 'Aucune réponse du serveur. Vérifiez votre connexion.';
                    } else {
                        // Quelque chose s'est passé lors de la configuration de la requête qui a déclenché une erreur
                        this.errorMessage = 'Erreur lors de la configuration de la requête.';
                    }
                    console.error(error);
                }
            }
        },
        formatCreatedAt(date) {
            return formatDistance(new Date(date), new Date(), {
                addSuffix: true,
                locale: fr,
            });
        },
    },
};
</script>


<style scoped>
* {
    font-family: 'Open Sans', sans-serif;
}

.comments-section {
    /* Ajoute ici les styles pour les commentaires */
    display: flex;
    flex-direction: column;
    justify-content: start;
    font-size: small;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 12px;
    height: 100%;
    position: relative;
    background-color: white;
}

.comments-docker {
    /* Styles pour la section des commentaires */
    overflow-y: auto;
    scrollbar-width: none;
    padding-bottom: 20px;
}

.comments-docker:hover {
    scrollbar-width: thin;
}

.comments-title {
    font-size: larger;
    margin-bottom: 12px;
    margin-left: 8px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: start;
}

hr {
    margin: 0;
    border: none;
    background: #ddd;
    width: calc(100% - 0.5rem * 2);
    margin-inline: auto;
    border-radius: 15px;
    height: 2px;
    margin-bottom: 12px;
}

.comment {
    /* Styles pour chaque commentaire */
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 8px;
}

.comment:nth-child(1) {
    padding-top: 0;
    margin-top: 0;
}

.user-info-comment {
    /* Styles pour les informations de l'utilisateur */
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}

.user-info-left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.avatar-comments {
    /* Styles pour l'avatar */
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
}

.date-comments {
    /* Styles pour la date du commentaire */
    color: #777;
    font-size: small;
    justify-self: flex-end;
}

.text-comments {
    /* Styles pour le texte du commentaire */
    padding: 8px 16px;
    background-color: #eee;
    border: none;
    border-radius: 12px;
}

.add-comment {
    /* Styles pour le formulaire d'ajout de commentaire */
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    width: 100%;
    background: none;
    position: relative;
    gap: 12px;
    padding-top: 12px;
}

.add-comment::before {
    content: '';
    position: absolute;
    top: -30px;
    left: 0;
    width: 100%;
    height: 30px;
    background: linear-gradient(to bottom, rgba(255, 255, 255, 0), #fff);
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

.add-comment input {
    /* Styles pour le formulaire d'ajout de commentaire */
    padding: 8px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 8px;
}

.add-comment input:focus {
    border-color: #d79026;
    outline: none;
}

.add-comment button {
    padding: 0.5rem 1rem;
    background-color: #d79026;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.add-comment button:active {
    background-color: #b37e1f;
}

</style>
