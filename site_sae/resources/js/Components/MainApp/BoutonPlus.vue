<template>
  <button class="plus-button" @click="showModal = true">
    <span class="plus-icon">+</span>
  </button>
</template>

<script>
export default {
  name: "BoutonPlus",
};
</script>

<style scoped>
.plus-button {
  display: flex;
  position: relative;
  justify-content: center;
  align-items: center;
  width: 3.2rem;
  height: 3.2rem;
  background-color: white;
  border: none;
  border-radius: 100%;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.35);
  cursor: pointer;
  transition: box-shadow 0.2s ease, transform 0.2s ease;
}

.plus-button:hover {
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
  transform: scale(1.1);
}

.plus-button:active {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  transform: scale(0.95);
}

.plus-icon {
  color: #d79026;
  font-size: 3rem;
  font-weight: bold;
}
</style>
