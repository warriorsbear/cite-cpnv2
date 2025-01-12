<script setup>
import { ref, defineEmits } from 'vue';

const emit = defineEmits(['close']);
const fileInput = ref(null);

const handleFileUpload = () => {
    const files = fileInput.value.files;
    if (files.length > 0) {
        // Handle file upload logic here
        console.log('Files to upload:', files);
    }
};

const closePopup = () => {
    emit('close');
};
</script>

<template>
    <div class="modal" @click.self="closePopup">
        <div class="popup_content">
            <span class="close_button" @click="closePopup">&times;</span>
            <h2>Déposer des photos</h2>
            <input type="file" ref="fileInput" multiple />
            <button @click="handleFileUpload">Upload</button>
        </div>
    </div>
</template>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.popup_content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    max-width: 600px;
    width: 90%;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.close_button {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
    background-color: transparent;
    border: none;
    color: #333;
}

h2 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

input[type="file"] {
    display: block;
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-top: 10px;
}

button {
    background-color: #ff9900;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #e68a00;
}
</style>
