<template>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section address">
                    <h3>ADRESSE</h3>
                    <p>1 Rue de la République,<br />31560 Nailloux</p>
                </div>
                <div class="footer-section contact">
                    <h3>CONTACT</h3>
                    <p>05 59 57 43 03<br />clubphotonailloux@gmail.com</p>
                </div>
                <div class="footer-section follow-us">
                    <h3>SUIVEZ-NOUS</h3>
                    <div class="social-media">
                        <a href="https://www.facebook.com/clubphotonailoux" target="_blank">
                            <img src="../public/images/images/Facebook_Logo_Secondary.png" alt="logo Facebook">
                        </a>
                    </div>
                </div>
            </div>
            <p class="footer-legal">
                Toutes les photographies des membres du ClubPhoto publiées sur ce site sont soumises aux droits de publications de leurs auteurs.
            </p>
            <p class="footer-legal">
                <a href="{{ route('mentionslegales') }}" class="legal-link">
                    Mentions Légales et Politique de Confidentialité
                </a>
            </p>
            <p class="footer-copyright">
                © 2024 Club Photo Nailloux. Tous droits réservés.
            </p>
        </div>
    </footer>
</template>

<style scoped>
.footer {
    background-color: #2b3033; /* Dark background color */
    color: #ffffff; /* Complementary text color */
    padding: 20px 0;
    text-align: center;
    font-size: 0.9rem;
    font-family: 'Poppins', sans-serif;
    margin-top: auto;
}

.footer .container {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    gap: 20px;
}

.footer-content {
    display: flex;
    justify-content: center;
    gap: 50px;
    flex-wrap: wrap;
}

.footer-section {
    flex: 1;
    text-align: center;
    margin-bottom: 20px; /* Add space between sections */
}

h3 {
    font-size: 1rem;
    margin-bottom: 10px;
    color: #d79026; /* Complementary heading color */
}

.footer-legal, .footer-copyright {
    font-size: 0.8rem;
    margin: 0;
}

.social-media {
    display: flex;
    justify-content: center;
    align-items: center;
}

.social-media a {
    color: #d79026; /* Complementary icon color */
    margin: 0 10px;
    font-size: 1.5rem;
    transition: color 0.3s;
}

.social-media a:hover {
    color: #ff6600; /* Accent color on hover */
}

.social-media img {
    width: 30px; /* Adjust the width as needed */
    height: auto; /* Maintain aspect ratio */
    transition: transform 0.3s;
}

.social-media img:hover {
    transform: scale(1.1); /* Slightly enlarge on hover */
}

.legal-link {
    color: #d79026; /* Complementary link color */
    text-decoration: none;
}

.legal-link:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        gap: 20px;
    }

    .footer-section {
        text-align: left;
        padding: 0 20px;
    }

    h3 {
        font-size: 0.9rem;
    }

    .footer-legal, .footer-copyright {
        font-size: 0.7rem;
    }

    .social-media a {
        font-size: 1.2rem;
    }
}
</style>
<script setup lang="ts">
</script>
