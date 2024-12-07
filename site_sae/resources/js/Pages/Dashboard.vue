<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ModalPhoto from '@/Components/MainApp/ModalPhoto.vue';
import MainApp from '@/Components/MainApp/MainApp.vue';
</script>

<template>
    <Head title="Fil d'actu" />

    <AuthenticatedLayout>

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Fil d'actu
            </h2>
        </template>

        <MainApp/>
        <ModalPhoto/>

    </AuthenticatedLayout>
</template>
