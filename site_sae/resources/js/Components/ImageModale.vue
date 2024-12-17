<!-- ImageModale.vue -->
<template>
    <div v-if="visible" class="modal-overlay" @click.self="close">
        <div class="modal-content">
            <img :src="imageSrc" :alt="description" />
            <p class="description">{{ description }}</p>
            <button @click="close" class="close-btn">Fermer</button>
        </div>
    </div>
</template>

<script setup>
defineProps({
    visible: Boolean,
    imageSrc: String,
    description: String,
});
const emit = defineEmits(["close"]);

const close = () => {
    emit("close");
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    position: relative;
    background: #fff;
    border-radius: 10px;
    max-width: 90%;
    text-align: center;
    padding: 20px;
}

.modal-content img {
    max-width: 100%;
    border-radius: 10px;
}

.description {
    margin-top: 10px;
    font-size: 1.2rem;
    color: #333;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ff6600;
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 5px;
}

.close-btn:hover {
    background: #333;
}
</style>
