<script setup>
import { defineProps, defineEmits, computed } from 'vue'

const props = defineProps({
    document: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['close'])

// Déterminer le type de prévisualisation en fonction de l'extension
const fileType = computed(() => {
    const extension = props.document.chemin.split('.').pop().toLowerCase()
    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']
    const pdfExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']
    const documentsExtensions = ['htfhtf']
    const textExtensions = ['txt', 'md', 'csv']

    if (imageExtensions.includes(extension)) return 'image'
    if (pdfExtensions.includes(extension)) return 'pdf'
    if (textExtensions.includes(extension)) return 'text'
    if (documentsExtensions.includes(extension)) return 'document'
    return 'other'
})

// URL de prévisualisation
const previewUrl = computed(() => {
    return route('documents.download', props.document.id_document)
})

// Télécharger le document
const downloadDocument = () => {
    window.location.href = previewUrl.value
}
</script>

<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] flex flex-col">
            <!-- En-tête -->
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-xl font-semibold">{{ document.nom }}</h2>
                <button
                    @click="$emit('close')"
                    class="text-gray-600 hover:text-gray-900"
                >
                    ✕
                </button>
            </div>

            <!-- Corps de la prévisualisation -->
            <div class="flex-grow overflow-auto p-4">
                <!-- Prévisualisation d'image -->
                <div v-if="fileType === 'image'" class="flex justify-center">
                    <img
                        :src="previewUrl"
                        :alt="document.nom"
                        class="max-w-full max-h-[70vh] object-contain"
                    />
                </div>

                <!-- Prévisualisation PDF -->
                <div v-else-if="fileType === 'pdf'" class="w-full h-[70vh]">
                    <iframe
                        :src="previewUrl"
                        class="w-full h-full"
                        border="0"
                    ></iframe>
                </div>

                <!-- Prévisualisation document -->
                <div v-else-if="fileType === 'document'" class="w-full h-[70vh]">
                    <iframe
                        :src="previewUrl"
                        class="w-full h-full"
                        border="0"
                    ></iframe>
                </div>

                <!-- Prévisualisation texte -->
                <div v-else-if="fileType === 'text'" class="w-full">
                    <iframe
                        :src="previewUrl"
                        class="w-full h-[70vh]"
                        border="0"
                    ></iframe>
                </div>

                <!-- Autre type de fichier -->
                <div v-else class="text-center p-4">
                    <p class="mb-4">Prévisualisation non disponible pour ce type de fichier.</p>
                </div>
            </div>

            <!-- Pied de page -->
            <div class="p-4 border-t flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Téléversé par {{ document.user.pseudo }}
                    le {{ new Date(document.created_at).toLocaleDateString() }}
                </div>
                <button
                    @click="downloadDocument"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                >
                    Télécharger
                </button>
            </div>
        </div>
    </div>
</template>
