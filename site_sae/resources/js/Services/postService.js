import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api'; // URL de ton backend Laravel

export const fetchPosts = async () => {
    try {
        const response = await axios.get(`${API_URL}/posts`);
        return response.data;
    } catch (error) {
        console.error("Erreur lors de la récupération des posts :", error);
        throw error;
    }
};
