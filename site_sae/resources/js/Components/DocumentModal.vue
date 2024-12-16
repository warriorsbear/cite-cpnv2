<script setup>
import {onMounted, ref} from 'vue'
import {usePage} from "@inertiajs/vue3";

const emit = defineEmits(['close', 'add-document'])

const documentName = ref('')
const documentFile = ref(null)
const eventId = ref(null)
const events = ref([]) // À remplir dynamiquement depuis l'API
const user = usePage().props.auth.user;

// Méthode pour gérer le changement de fichier
const handleFileChange = (event) => {
    documentFile.value = event.target.files[0]
}

// Méthode pour soumettre le document
const submitDocument = () => {
    if (!documentName.value || !documentFile.value) {
        alert('Veuillez remplir tous les champs obligatoires')
        return
    }

    const formData = new FormData()
    formData.append('nom', documentName.value)
    formData.append('file', documentFile.value)
    formData.append('id_utilisateur', user.id)
    if (eventId.value) {
        formData.append('id_evenement', eventId.value)
    }

    emit('add-document', formData)
}

// Charger les événements au montage du composant
onMounted(async () => {
    try {
        const response = await axios.get(route('events.list'))
        events.value = response.data.events
    } catch (error) {
        console.error('Erreur de chargement des événements', error)
    }
})
</script>

<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-96">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Ajouter un document</h2>
                <button
                    @click="$emit('close')"
                    class="text-gray-600 hover:text-gray-900"
                >
                    ✕
                </button>
            </div>

            <form @submit.prevent="submitDocument">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Nom du document</label>
                    <input
                        v-model="documentName"
                        type="text"
                        required
                        class="w-full px-3 py-2 border rounded-md"
                        placeholder="Nom du document"
                    />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Fichier</label>
                    <input
                        type="file"
                        @change="handleFileChange"
                        required
                        class="w-full px-3 py-2 border rounded-md"
                    />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Événement (optionnel)</label>
                    <select
                        v-model="eventId"
                        class="w-full px-3 py-2 border rounded-md"
                    >
                        <option value="">Aucun événement</option>
                        <option
                            v-for="event in events"
                            :key="event.id"
                            :value="event.id"
                        >
                            {{ event.titre }}
                        </option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button
                        type="button"
                        @click="$emit('close')"
                        class="mr-2 px-4 py-2 bg-gray-200 rounded"
                    >
                        Annuler
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                    >
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
