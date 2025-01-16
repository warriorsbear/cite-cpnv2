<template>
    <Head title="Nous contacter"/>
    <authenticated-layout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Nous contacter
            </h2>
        </template>

        <div class="contact-page">
            <div class="contact-form">
                <h2>Contactez-nous par email</h2>
                <form @submit.prevent="submitContactForm">
                    <div class="form-group">
                        <label>Prénom - Nom *</label>
                        <input type="text" v-model="contactForm.fullName" required/>
                    </div>
                    <div class="form-group">
                        <label>Adresse e-mail *</label>
                        <input type="email" v-model="contactForm.email" required/>
                    </div>
                    <div class="form-group">
                        <label>Votre message *</label>
                        <textarea
                            v-model="contactForm.message"
                            rows="5"
                            required
                            placeholder="Votre message ici..."
                        ></textarea>
                    </div>
                    <div class="consent-group">
                        <input id="ok" type="checkbox" v-model="contactForm.consent"/>
                        <label for="consent-checkbox">
                            En cochant cette case et en soumettant ce formulaire, j'accepte que mes données
                            personnelles soient utilisées pour me recontacter.
                        </label>
                    </div>
                    <button type="submit">Envoyez !</button>
                </form>
            </div>

            <div class="contact-cord">
                <h2>Nous rencontrer</h2>
                <p>Adresse : 1 Rue de la République, 31560 Nailloux</p>
                <p>Téléphone : 05 59 57 43 03</p>
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2886.513123456789!2d1.123456789!3d43.123456789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1234567890abcdef%3A0xabcdef1234567890!2s1%20Rue%20de%20la%20R%C3%A9publique%2C%2031560%20Nailloux%2C%20France!5e0!3m2!1sen!2sfr!4v1234567890123!5m2!1sen!2sfr"
                        width="100%"
                        height="300"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </div>
        </div>
        <Footer/>
    </authenticated-layout>

</template>

<script>
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Footer from "@/Components/Footer.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

export default {
    components: {GuestLayout, Footer, AuthenticatedLayout, Head},
    data() {
        return {
            contactForm: {
                fullName: '',
                email: '',
                message: '',
                consent: false
            }
        };
    },
    methods: {
        async submitContactForm() {
            if (this.contactForm.consent) {
                try {
                    await this.$axios.post('/api/contact', this.contactForm);
                    alert('Message envoyé avec succès');
                } catch (error) {
                    alert('Erreur lors de l\'envoi du message');
                }
            } else {
                alert('Vous devez accepter les conditions');
            }
        }
    }
};
</script>

<style scoped>
/* Structure principale */
.contact-page {
    display: flex;
    justify-content: space-between;
    align-items: stretch;
    gap: 20px;
    background-color: #ffffff;
    padding: 20px;
    font-family: 'Poppins', sans-serif;
}

/* Zone "Contactez-nous par email" */
.contact-form, .contact-cord {
    width: 48%;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
}

.contact-form h2, .contact-cord h2 {
    margin-bottom: 20px;
    font-size: 1.5rem;
    color: #333;
}

/* Champs du formulaire */
.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

input, textarea {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f9f9f9;
}

textarea {
    resize: vertical;
    min-height: 80px;
    max-height: 300px;
}

input:focus, textarea:focus {
    border-color: #d68f26;
    box-shadow: 0 0 5px rgba(214, 143, 38, 0.5);
    outline: none;
}

/* Checkbox */
.consent-group {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 5px;
    margin: 10px 0;
}

.consent-group input {
    width: fit-content;
    margin-right: 5px;
}

.consent-group label {
    font-size: 14px;
    font-weight: normal;
    color: #333;
    line-height: 1.5;
}

/* Bouton */
button {
    background-color: #d68f26;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    align-self: flex-start;
}

button:hover {
    background-color: #af7824;
}

/* Zone "Nous rencontrer" */
.contact-cord p {
    margin: 5px 0;
    font-size: 14px;
    color: #333;
}

/* Carte Google Maps */
.map-container {
    margin-top: 20px;
    width: 100%;
}

/* MEDIA QUERIES POUR RESPONSIVE */
@media (max-width: 768px) {
    .contact-page {
        flex-direction: column;
        align-items: center;
    }

    .contact-form, .contact-cord {
        width: 90%;
        margin-bottom: 20px;
    }

    .contact-form h2, .contact-cord h2 {
        font-size: 1.2rem;
    }

    label {
        font-size: 14px;
    }

    button {
        width: 100%;
        padding: 12px;
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .contact-form, .contact-cord {
        width: 100%;
        margin-bottom: 10px;
    }

    .contact-form h2, .contact-cord h2 {
        font-size: 1.1rem;
    }

    label {
        font-size: 13px;
    }

    button {
        font-size: 14px;
    }
}
</style>
