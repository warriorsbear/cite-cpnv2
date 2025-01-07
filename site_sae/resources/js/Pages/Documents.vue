<script setup>
import { ref, onMounted } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Footer from "@/Components/Footer.vue"
import DocumentModal from '@/Components/DocumentModal.vue'
import DocumentCard from '@/Components/DocumentCard.vue'
import DocumentPreviewModal from '@/Components/DocumentPreviewModal.vue'
import axios from 'axios'

// Données réactives
const documents = ref([])
const isLoading = ref(true)
const error = ref(null)
const showModal = ref(false)

// Récupérer les documents
const fetchDocuments = async () => {
    try {
        const response = await axios.get(route('documents.index'))
        documents.value = response.data.documents
        isLoading.value = false
    } catch (err) {
        error.value = "Impossible de charger les documents"
        isLoading.value = false
    }
}

// Ouvrir le modal d'ajout de document
const openDocumentModal = () => {
    showModal.value = true
}

// Fermer le modal
const closeDocumentModal = () => {
    showModal.value = false
}

// Ajouter un nouveau document
const addDocument = async (documentData) => {
    try {
        const response = await axios.post(route('documents.upload'), documentData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })

        // recharge les documents
        await fetchDocuments()
        closeDocumentModal()
        window.location.reload()
    } catch (err) {
        error.value = "Erreur lors de l'ajout du document"
        console.error(err) // Pour le débogage
    }
}

// État pour la prévisualisation
const selectedDocument = ref(null)
const showPreviewModal = ref(false)

// Méthode de prévisualisation
const previewDocument = (document) => {
    selectedDocument.value = document
    showPreviewModal.value = true
}

// Fermer la prévisualisation
const closePreviewModal = () => {
    showPreviewModal.value = false
    selectedDocument.value = null
}

// Charger les documents au montage du composant
onMounted(fetchDocuments)

// Récupérer l'utilisateur connecté
const user = usePage().props.auth.user
</script>

<template>
    <Head title="Documents" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Documents du club
                </h2>
                <button
                    @click="openDocumentModal"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                >
                    Ajouter un document
                </button>
            </div>
        </template>

        <div class="conteuneur">
            <div v-if="isLoading" class="w-full text-center">
                Chargement des documents...
            </div>

            <div v-else-if="error" class="w-full text-center text-red-500">
                {{ error }}
            </div>

            <div v-else-if="documents.length === 0" class="w-full text-center">
                Aucun document disponible
            </div>

            <DocumentCard
                v-else
                v-for="document in documents"
                :document="document"
                @preview="previewDocument"
                class="w-full"
            />
        </div>

        <DocumentModal
            v-if="showModal"
            @close="closeDocumentModal"
            @add-document="addDocument"
        />

        <DocumentPreviewModal
            v-if="showPreviewModal"
            :document="selectedDocument"
            @close="closePreviewModal"
        />

        <Footer />
    </AuthenticatedLayout>
</template>

<style scoped>
.conteuneur {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: flex-start;
    padding: 5%;
    background-color: rgb(255, 255, 255);

}
</style>
