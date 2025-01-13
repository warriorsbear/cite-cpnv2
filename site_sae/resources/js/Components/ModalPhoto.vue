<template>
    <div>
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

                <h2 class="text-2xl font-bold mb-6 text-center">Ajouter des nouvelles photos</h2>

                <!-- Afficher les photos existantes -->
                <div v-if="existingPhotos.length > 0" class="mb-4">
                    <h3 class="text-lg font-semibold mb-2">Photos existantes :</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div v-for="(photo, index) in existingPhotos" :key="index" class="relative">
                            <img :src="photo.chemin" :alt="photo.legende" class="w-full h-40 object-cover rounded-lg"/>
                            <p class="text-sm text-gray-600 mt-1">{{ photo.legende || 'Sans légende' }}</p>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="submitPhotos" class="space-y-4">
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
                            multiple
                            class="hidden"
                        />

                        <div v-if="selectedFiles.length === 0" class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-600">Glissez et déposez des photos ou cliquez pour sélectionner</p>
                        </div>

                        <div v-else>
                            <!-- Affichage des fichiers sélectionnés et champs de légende -->
                            <div v-for="(file, index) in selectedFiles" :key="index" class="mb-4 p-4 border rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-gray-800">{{ file.name }}</span>
                                    <button
                                        type="button"
                                        @click="removeFile(index)"
                                        class="text-red-500 hover:text-red-700"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <input
                                    type="text"
                                    v-model="photosData[index].legende"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                    placeholder="Ajouter une légende (optionnel)"
                                />
                            </div>
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
import { ref, computed, watch } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import { defineProps, defineEmits } from 'vue'
import axios from 'axios'

// Props et Emits
const props = defineProps({
    id_visionnage: {
        type: Number,
        required: true
    },
    isModalOpen: {
        type: Boolean,
        required: true
    }
})

const emit = defineEmits(['close'])

// Récupérer l'utilisateur connecté
const user = usePage().props.auth.user

// États du composant
const selectedFiles = ref([])
const isDragging = ref(false)
const fileInput = ref(null)
const existingPhotos = ref([])
const photosData = ref([])

// Méthodes
const closeModal = () => {
    emit('close')
    resetForm()
}

const resetForm = () => {
    selectedFiles.value = []
    photosData.value = []
    if (fileInput.value) {
        fileInput.value.value = null
    }
}

const triggerFileInput = () => {
    fileInput.value?.click()
}

const handleFileSelect = (event) => {
    const files = Array.from(event.target.files || [])
    selectedFiles.value = files.filter(file => file.type.startsWith('image/'))
}

const handleDrop = (event) => {
    isDragging.value = false
    const files = Array.from(event.dataTransfer.files || [])
    selectedFiles.value = files.filter(file => file.type.startsWith('image/'))
}

const dragOver = () => {
    isDragging.value = true
}

const dragLeave = () => {
    isDragging.value = false
}

const removeFile = (index) => {
    selectedFiles.value.splice(index, 1)
    photosData.value.splice(index, 1)
}

// Watch pour initialiser photosData
watch(selectedFiles, (newFiles) => {
    photosData.value = newFiles.map(file => ({
        file,
        legende: '',
        date_prise_vue: new Date().toISOString().split('T')[0]
    }))
})

const submitPhotos = async () => {

    try {
        console.log('ID Visionnage:', props.id_visionnage, typeof props.id_visionnage);
        const promises = selectedFiles.value.map(async (file, index) => {
            const formData = new FormData()
            formData.append('nom', file)
            formData.append('legende', photosData.value[index]?.legende || 'Sans légende')
            formData.append('date_prise_vue', photosData.value[index]?.date_prise_vue)
            formData.append('id_utilisateur', user.id)
            formData.append('id_visionnage', props.id_visionnage)

            return axios.post('/api/photos', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
        })

        await Promise.all(promises)
        await fetchExistingPhotos()
        showSuccessNotification()
        closeModal()
    } catch (error) {
        console.error('Erreur lors de l\'upload:', error)
        showErrorNotification(error.response?.data?.message || 'Erreur lors de l\'upload des photos')
    }
}

const fetchExistingPhotos = async () => {
    try {
        const response = await axios.get(`/api/photos/user/${user.id}/visionnage/${props.id_visionnage}`)
        existingPhotos.value = response.data.data || []
    } catch (error) {
        console.error('Erreur lors de la récupération des photos:', error)
        existingPhotos.value = []
    }
}

// Computed
const isFormValid = computed(() => {
    return selectedFiles.value.length > 0
})

// Watch for modal open state
watch(() => props.isModalOpen, (newVal) => {
    if (newVal) {
        fetchExistingPhotos()
    }
})

// Notifications
const showSuccessNotification = () => {
    Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: 'Photos uploadées avec succès !',
    })
}

const showErrorNotification = (message) => {
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: message,
    })
}
</script>
