<template>
    <div>
        <!-- Bouton d'ouverture du modal -->
        <BoutonPlus class="btn btn-primary" @click="openModal" />
<!--        <button-->
<!--            @click="openModal"-->
<!--            class="fixed bottom-6 right-6 bg-orange-500 text-white rounded-full p-4 shadow-lg hover:bg-orange-600 transition-colors"-->
<!--        >-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />-->
<!--            </svg>-->
<!--        </button>-->

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

                <h2 class="text-2xl font-bold mb-6 text-center">Ajouter un nouveau post</h2>

                <form @submit.prevent="submitPhoto" class="space-y-4">

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
                            multiple
                            @change="handleFileSelect"
                            accept="image/*"
                            class="hidden"
                        />

                        <div v-if="selectedFiles.length === 0" class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-600">Glissez et déposez jusqu'à 5 photos ou cliquez pour sélectionner</p>
                        </div>

                        <div v-else class="grid grid-cols-2 gap-4">
                            <div v-for="(file, index) in selectedFiles" :key="index" class="relative">
                                <img
                                    :src="fileUrls[index]"
                                    class="w-full h-32 object-cover rounded"
                                    alt="Preview"
                                />
                                <button
                                    @click.stop="removeFile(index)"
                                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Champs de formulaire -->
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Légende du post</label>
                            <text-input
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
                            @click="uploadPhoto"
                        >
                            Publier
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Loading screen -->
        <div v-if="isLoading" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 flex flex-col items-center">
                <img src="../../public/images/loading.gif" alt="Loading..." class="w-16 h-16 mb-4" />
                <p class="text-center text-gray-700">Publication en cours...</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import Swal from 'sweetalert2';
import TextInput from "@/Components/TextInput.vue";
import BoutonPlus from "@/Components/MainApp/BoutonPlus.vue";

// Récupérer l'utilisateur connecté
const user = usePage().props.auth.user

// États du composant
const isModalOpen = ref(false)
const selectedFiles = ref([])
const isDragging = ref(false)
const fileInput = ref(null)
const isLoading = ref(false) // New loading state

// Formulaire
const form = useForm({
    photos: [],
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

// Nouvelle méthode pour déclencher l'input de fichier
const triggerFileInput = () => {
    if (fileInput.value) {
        fileInput.value.click()
    }
}

const handleFileSelect = (event) => {
    const files = Array.from(event.target.files)
    addFiles(files)
}

const handleDrop = (event) => {
    isDragging.value = false
    const files = Array.from(event.dataTransfer.files)
    addFiles(files)
}

const addFiles = (files) => {
    const imageFiles = files.filter(file => file.type.startsWith('image/'))
    if (selectedFiles.value.length + imageFiles.length > 5) {
        showErrorNotification('Vous ne pouvez pas ajouter plus de 5 photos')
        return
    }
    selectedFiles.value = [...selectedFiles.value, ...imageFiles].slice(0, 5)
    form.photos = selectedFiles.value
}

const removeFile = (index) => {
    selectedFiles.value = selectedFiles.value.filter((_, i) => i !== index)
    form.photos = selectedFiles.value
}

const resetForm = () => {
    selectedFiles.value = []
    form.reset()
    if (fileInput.value) {
        fileInput.value.value = null
    }
}

const fileUrls = computed(() => {
    return selectedFiles.value.map(file => URL.createObjectURL(file))
})

const dragOver = () => {
    isDragging.value = true
}

const dragLeave = () => {
    isDragging.value = false
}

const submitPhoto = () => {
    isLoading.value = true // Set loading state to true
    const formData = new FormData()
    formData.append('legende', form.legende)
    formData.append('date_prise_vue', form.date_prise_vue)
    formData.append('id_utilisateur', form.id_utilisateur)

    selectedFiles.value.forEach((file, index) => {
        formData.append(`photos[${index}]`, file)
    })

    form.post(route('posts.create'), {
        forceFormData: true,
        onSuccess: () => {
            isLoading.value = false // Set loading state to false
            closeModal()
            showSuccessNotification()
            console.log('Post créé avec succès')
        },
        onError: (errors) => {
            isLoading.value = false // Set loading state to false
            showErrorNotification(errors.message)
            console.error('Erreurs de validation :', errors)
        }
    })
}

// Validation du formulaire
const isFormValid = computed(() => {
    return selectedFiles.value.length > 0 &&
        selectedFiles.value.length <= 5 &&
        form.legende.trim() !== '' &&
        form.date_prise_vue !== ''
})

//notification
const showSuccessNotification = () => {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Post crée avec succès',
    });
};

const showErrorNotification = (message) => {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
    });
};

const uploadPhoto = async () => {
    try {
        // Your photo upload logic
        // On success:
    } catch (error) {
        // On error:
        showErrorNotification(error.message);
    }
};
</script>

<style scoped>
.btn {
    cursor: pointer;
    background-color: #ffffff;
    color: black;
    border: none;
    padding: 10px 20px;
    border-radius: 50px;
    font-size: large;
}

.btn-primary {
    position: fixed;
    bottom: 20px;
    right: 20px;
}
</style>
