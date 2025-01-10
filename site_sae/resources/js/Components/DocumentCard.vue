<script setup>
import { defineProps, defineEmits } from 'vue'
import { formatDistance } from 'date-fns'
import { fr } from 'date-fns/locale'

const emit = defineEmits(['preview'])

const props = defineProps({
    document: {
        type: Object,
        required: true
    }
})

// Formater la date de création
const formatCreatedAt = (date) => {
    return formatDistance(new Date(date), new Date(), {
        addSuffix: true,
        locale: fr
    })
}

const extension = props.document.chemin.split('.').pop().toLowerCase()

const nom_extension = props.document.nom+'.'+extension

// Méthode pour télécharger le document
const downloadDocument = (e) => {
    e.stopPropagation() // Empêcher la propagation vers le parent
    window.location.href = route('documents.download', props.document.id_document)
}

// Méthode pour supprimer le document
const deleteDocument = async (e) => {
    e.stopPropagation() // Empêcher la propagation vers le parent
    if (confirm('Êtes-vous sûr de vouloir supprimer ce document ?')) {
        try {
            // S'assurer que l'ID est bien passé dans l'URL
            await axios.delete(`/documents/${props.document.id_document}`)
            window.location.reload()
        } catch (error) {
            console.error('Erreur lors de la suppression:', error)
            alert('Erreur lors de la suppression du document')
        }
    }
}

// Nouvelle méthode pour prévisualiser
const previewDocument = () => {
    emit('preview', props.document)
}
</script>

<template>
    <div
        class="bg-white shadow-md rounded-lg p-4 w-64 hover:shadow-lg transition-shadow cursor-pointer"
        @click="previewDocument"
    >
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-semibold truncate">{{ nom_extension }}</h3>
            <span
                class="text-sm text-gray-500"
                :title="new Date(document.created_at).toLocaleString()"
            >
        {{ formatCreatedAt(document.created_at) }}
      </span>
        </div>

        <div class="flex justify-between items-center mt-4">
      <span class="text-sm text-gray-600">
        {{ document.user.pseudo }}
      </span>
            <div class="flex gap-2">
            <button
                @click="downloadDocument"
                class="text-blue-500 hover:text-blue-700 flex items-center"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-9.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                    />
                </svg>
            </button>
            <button
                @click="deleteDocument"
                class="text-red-500 hover:text-red-700 flex items-center"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd"
                    />
                </svg>
            </button>
        </div>
        </div>

        <div v-if="document.event" class="text-sm text-gray-500 mt-2">
            Événement : {{ document.event.titre }}
        </div>

    </div>
</template>
