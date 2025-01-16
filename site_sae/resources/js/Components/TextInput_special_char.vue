<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

const filterSpecialCharacters = (event) => {
    const regex = /[^a-zA-Z0-9\s@&!#^*]/g;
    event.target.value = event.target.value.replace(regex, '');
    model.value = event.target.value;
};

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        v-model="model"
        ref="input"
        @input="filterSpecialCharacters"
    />
</template>
