<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ModalPhoto from '@/Components/MainApp/ModalPhoto.vue';
import MainApp from '@/Components/MainApp/MainApp.vue';
import Footer from "@/Components/Footer.vue";
import ModalPost from "@/Components/MainApp/ModalPost.vue";
import ModalPhotoV1 from "@/Components/MainApp/ModalPhotoV1.vue";
</script>

<template>
    <Head title="Fil d'actu" />

    <AuthenticatedLayout>

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Fil d'actualité
            </h2>
        </template>

        <MainApp/>
        <ModalPost/>
<!--        <modal-photo-v1/> // This line is commented out because it is not used in the Dashboard.vue file-->
        <Footer />
    </AuthenticatedLayout>
</template>
