import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api'; // URL de ton backend Laravel

export const fetchCommentairesPosts = async () => {
    try {
        const response = await axios.get(`${API_URL}/commentaires`);
        return response.data;
    } catch (error) {
        console.error("Erreur lors de la récupération des commentaires :", error);
        throw error;
    }
};
