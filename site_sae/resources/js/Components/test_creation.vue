<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const user = usePage().props.auth.user;

const form = useForm({
    titre: '',
    date_heure: '',
    descriptif: '',
    lieu: '',
    type: '',
    officiel: '',
    id_utilisateur: user.id,
});

const submit = () => {
    form.post(route('evenement.create'), {
        onSuccess: () => {
            form.reset();
            emit('submit');
        }
    });
};
</script>

<template>
        <Head title="creation evenement" />

    <div class="form-container">

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="titre" value="titre" />

                <TextInput
                    id="titre"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.titre"
                    required
                    autofocus
                    autocomplete="nom"
                />

                <InputError class="mt-2" :message="form.errors.titre" />
            </div>

            <div class="mt-4">
                <InputLabel for="descriptif" value="descriptif" />

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
                <InputLabel for="lieu" value="lieu" />

                <TextInput
                    id="pseudo"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.lieu"
                    required
                    autocomplete="pseudo"
                />

                <InputError class="mt-2" :message="form.errors.lieu" />
            </div>

            <div class="mt-4">
                <InputLabel for="type" value="type" />

                <TextInput
                    id="type"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.type"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.type" />
            </div>

            <div class="mt-4">
                <InputLabel for="officiel" value="Officiel" />

                <input
                    id="officiel"
                    type="checkbox"
                    class="mt-1 block"
                    v-model="form.officiel"
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.officiel" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="date_heure"
                    value="date_heure"
                />

                <TextInput
                    id="password_confirmation"
                    type="datetime-local"
                    class="mt-1 block w-full"
                    v-model="form.date_heure"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.date_heure"
                />
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
    max-width: 600px; /* Adjust the max-width as needed */
    margin: 0 auto; /* Center the container horizontally */
}
</style>
