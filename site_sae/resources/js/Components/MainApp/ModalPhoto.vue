<template>
    <div>
        <!-- Bouton d'ouverture du modal -->
        <button
            @click="openModal"
            class="fixed bottom-6 right-6 bg-orange-500 text-white rounded-full p-4 shadow-lg hover:bg-orange-600 transition-colors"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>

        <!-- Modal d'upload de photo -->
        <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg w-[500px] max-h-[90vh] overflow-y-auto p-6 relative">
                <!-- Bouton de fermeture -->
                <button
                    @click="closeModal"
                    class="absolute top-4 right-4 text-gray-600 hover:text-gray-900"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h2 class="text-2xl font-bold mb-6 text-center">Ajouter une nouvelle photo</h2>

                <form @submit.prevent="submitPhoto" class="space-y-4">
                    <!-- Zone de drop/upload -->
                    <!-- Zone de drop/upload -->
                    <div
                        @dragover.prevent="dragOver"
                        @dragleave.prevent="dragLeave"
                        @drop.prevent="handleDrop"
                        @click="triggerFileInput"
                        class="border-2 border-dashed rounded-lg p-6 text-center cursor-pointer transition-colors"
                        :class="isDragging ? 'border-orange-500 bg-orange-50' : 'border-gray-300 hover:border-orange-500'"
                    >
                        <input
                            type="file"
                            ref="fileInput"
                            @change="handleFileSelect"
                            accept="image/*"
                            class="hidden"
                        />

                        <div v-if="!selectedFile" class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-600">Glissez et déposez une photo ou cliquez pour sélectionner</p>
                        </div>

                        <div v-else class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                <span class="text-gray-800">{{ selectedFile.name }}</span>
                            </div>
                            <button
                                type="button"
                                @click.stop="clearFile"
                                class="text-red-500 hover:text-red-700"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Champs de formulaire -->
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Légende</label>
                            <input
                                type="text"
                                v-model="form.legende"
                                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Décrivez votre photo..."
                            />
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Date de prise de vue</label>
                            <input
                                type="date"
                                v-model="form.date_prise_vue"
                                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                            />
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex justify-end space-x-4 mt-6">
                        <button
                            type="button"
                            @click="closeModal"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors"
                        >
                            Annuler
                        </button>
                        <button
                            type="submit"
                            :disabled="!isFormValid"
                            class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition-colors disabled:opacity-50"
                        >
                            Publier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

// Récupérer l'utilisateur connecté
const user = usePage().props.auth.user

// États du composant
const isModalOpen = ref(false)
const selectedFile = ref(null)
const isDragging = ref(false)
const fileInput = ref(null)

// Formulaire
const form = useForm({
    nom: null,
    legende: '',
    date_prise_vue: '',
    id_utilisateur: user.id
})

// Méthodes
const openModal = () => {
    isModalOpen.value = true
}

const closeModal = () => {
    isModalOpen.value = false
    resetForm()
}

const resetForm = () => {
    selectedFile.value = null
    form.reset()
    if (fileInput.value) {
        fileInput.value.value = null
    }
}
// Nouvelle méthode pour déclencher l'input de fichier
const triggerFileInput = () => {
    if (fileInput.value) {
        fileInput.value.click()
    }
}

const handleFileSelect = (event) => {
    const file = event.target.files[0]
    if (file && file.type.startsWith('image/')) {
        selectedFile.value = file
        form.nom = file
    } else {
        alert('Veuillez sélectionner un fichier image valide.')
    }
}

const handleDrop = (event) => {
    isDragging.value = false
    const file = event.dataTransfer.files[0]
    if (file && file.type.startsWith('image/')) {
        selectedFile.value = file
        form.nom = file
    } else {
        alert('Veuillez déposer un fichier image valide.')
    }
}

const dragOver = () => {
    isDragging.value = true
}

const dragLeave = () => {
    isDragging.value = false
}

const clearFile = () => {
    selectedFile.value = null
    form.nom = null
    if (fileInput.value) {
        fileInput.value.value = null
    }
}

const submitPhoto = () => {
    form.post(route('photo.create'), {
        forceFormData: true,
        onSuccess: () => {
            closeModal()
        },
        onError: (errors) => {
            console.error('Erreurs de validation :', errors)
        }
    })
}

// Validation du formulaire
const isFormValid = computed(() => {
    return selectedFile.value &&
        form.legende.trim() !== '' &&
        form.date_prise_vue !== ''
})
</script>
