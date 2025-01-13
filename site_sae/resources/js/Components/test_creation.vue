<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { defineEmits } from 'vue';

const emit = defineEmits(['submit', 'close']);

const user = usePage().props.auth.user;

const form = useForm({
    titre: '',
    date_heure: '',
    descriptif: '',
    lieu: '',
    type: '',
    officiel: user.role === 'admin', // Remplir automatiquement en fonction du rôle de l'utilisateur
    id_utilisateur: user.id,
});

const submit = () => {
    form.post(route('evenement.create'), {
        onSuccess: () => {
            form.reset();
            emit('submit');
            Swal.fire({
                title: 'Succès',
                text: 'Événement créé avec succès',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.reload();
            });
        }
    });
};
</script>

<template>
    <Head title="creation evenement" />

    <div class="form-container">
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="titre" value="Titre" />
                <TextInput
                    id="titre"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.titre"
                    required
                    autocomplete="nom"
                />
                <InputError class="mt-2" :message="form.errors.titre" />
            </div>

            <div class="mt-4">
                <InputLabel for="descriptif" value="Descriptif" />
                <TextInput
                    id="descriptif"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.descriptif"
                    required
                    autocomplete="prenom"
                />
                <InputError class="mt-2" :message="form.errors.descriptif" />
            </div>

            <div class="mt-4">
                <InputLabel for="lieu" value="Lieu" />
                <TextInput
                    id="lieu"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.lieu"
                    required
                    autocomplete="pseudo"
                />
                <InputError class="mt-2" :message="form.errors.lieu" />
            </div>

            <div class="mt-4">
                <InputLabel for="type" value="Type" />
                <select
                    id="type"
                    class="mt-1 block w-full"
                    v-model="form.type"
                    required
                >
                    <option value="" disabled selected>Choisissez un type d'évenement</option>
                    <option value="cours">Cours</option>
                    <option value="visionnage">Visionnage</option>
                    <option value="reunion">Réunion</option>
                    <option value="exposition">Exposition</option>
                    <option value="collaboration">Collaboration</option>
                    <option value="information">Information</option>
                    <option value="sortie_a_theme">Sortie à thème</option>
                </select>
            </div>

            <div class="mt-4">
                <InputLabel for="date_heure" value="Date et heure" />
                <TextInput
                    id="date_heure"
                    type="datetime-local"
                    class="mt-1 block w-full"
                    v-model="form.date_heure"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.date_heure" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    class="ms-4"
                    type="button"
                    @click="$emit('close')"
                >
                    Annuler
                </PrimaryButton>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Créer l'evenement
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>

<style scoped>
.form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    max-width: 600px;
    margin: 0 auto;
}
</style>
