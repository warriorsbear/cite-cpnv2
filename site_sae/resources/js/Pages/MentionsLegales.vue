<script setup >
import { Head, Link } from '@inertiajs/vue3';
import Footer from "@/Components/Footer.vue";
import guest from "@/Layouts/GuestLayout.vue";
import newheaderauthentifie from "@/Layouts/newheaderauthentifie.vue";
import NavLink from "@/Components/NavLink.vue";
import Header from "@/Components/Header.vue";
</script>

<template>
    <Head title="Mentions légales" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Mentions Légales
            </h2>
        </template>

        <div class="mentions-legales">
            <h1>Mentions légales</h1>

            <section>
                <h2>Qui sommes-nous ?</h2>
                <p>Page Facebook : <a href="https://www.facebook.com/clubphotonailloux/" target="_blank">Cliquez ici</a></p>
                <ul>
                    <li><strong>Responsable de la publication :</strong></li>
                    <li><strong>Webmaster :</strong> Hervé(exemple), <a href="mailto:adminsite@clubphoto-nailloux.fr">adminsite@clubphoto-nailloux.fr</a></li>
                    <li><strong>Hébergeur :</strong> o2switch - Chem. des Pardiaux, 63000 Clermont-Ferrand</li>
                    <li><strong>Délégué de la protection des données :</strong> Patrice(exemple), <a href="mailto:bureau@clubphoto-nailloux.fr">bureau@clubphoto-nailloux.fr</a></li>
                </ul>
                <p>Ce site est optimisé pour un fonctionnement avec Firefox.</p>
            </section>

            <section>
                <h2>Utilisation des données personnelles collectées</h2>
                <h3>Commentaires</h3>
                <p>
                    Quand vous laissez un commentaire sur notre site web, les données inscrites dans le formulaire de commentaire, ainsi que
                    votre adresse IP et l'agent utilisateur de votre navigateur, sont collectés pour nous aider à détecter les commentaires indésirables.
                </p>
                <p>
                    Une chaîne anonymisée créée à partir de votre adresse de messagerie (également appelée "hash") peut être envoyée au service
                    Gravatar pour vérifier si vous l'utilisez. Consultez les clauses de confidentialité du service Gravatar ici :
                    <a href="https://automattic.com/privacy/" target="_blank">https://automattic.com/privacy/</a>. Après validation de votre commentaire,
                    votre photo de profil sera visible publiquement à côté de votre commentaire.
                </p>

                <h3>Cookies</h3>
                <p>
                    Si vous déposez un commentaire sur notre site, il vous sera proposé d’enregistrer votre nom, adresse de messagerie et site web dans
                    des cookies. C’est uniquement pour votre confort afin de ne pas avoir à saisir ces informations si vous déposez un autre commentaire
                    plus tard. Ces cookies expirent au bout d’un an.
                </p>
                <p>
                    Si vous avez un compte et que vous vous connectez sur ce site, un cookie temporaire sera créé afin de déterminer si votre navigateur
                    accepte les cookies. Il ne contient pas de données personnelles et sera supprimé automatiquement à la fermeture de votre navigateur.
                </p>
                <p>
                    Lorsque vous vous connectez, nous mettons en place un certain nombre de cookies pour enregistrer vos informations de connexion et vos
                    préférences d’écran. La durée de vie d’un cookie de connexion est de deux jours, celle d’un cookie d’option d’écran est d’un an. Si
                    vous cochez « Se souvenir de moi », votre cookie de connexion sera conservé pendant deux semaines. Si vous vous déconnectez de votre
                    compte, le cookie de connexion sera effacé.
                </p>
                <p>
                    En modifiant ou en publiant une publication, un cookie supplémentaire sera enregistré dans votre navigateur. Ce cookie ne comprend
                    aucune donnée personnelle. Il indique simplement l’ID de la publication que vous venez de modifier. Il expire au bout d’un jour.
                </p>
            </section>

            <section>
                <h2>Contenu embarqué depuis d'autres sites</h2>
                <p>
                    Les articles de ce site peuvent inclure des contenus intégrés (par exemple des vidéos, images, articles…). Le contenu intégré
                    depuis d’autres sites se comporte de la même manière que si le visiteur se rendait sur cet autre site.
                </p>
                <p>
                    Ces sites web pourraient collecter des données sur vous, utiliser des cookies, embarquer des outils de suivis tiers, suivre vos
                    interactions avec ces contenus embarqués si vous disposez d’un compte connecté sur leur site web.
                </p>
            </section>

            <section>
                <h2>Durées de stockage de vos données</h2>
                <p>
                    Si vous laissez un commentaire, le commentaire et ses métadonnées sont conservés indéfiniment. Cela permet de reconnaître et
                    approuver automatiquement les commentaires suivants au lieu de les laisser dans la file de modération.
                </p>
                <p>
                    Pour les utilisateurs et utilisatrices qui s’enregistrent sur notre site (si cela est possible), nous stockons également les
                    données personnelles indiquées dans leur profil. Tous les utilisateurs et utilisatrices peuvent voir, modifier ou supprimer
                    leurs informations personnelles à tout moment (à l’exception de leur nom d’utilisateur·ice). Les gestionnaires du site peuvent
                    aussi voir et modifier ces informations.
                </p>
            </section>

            <section>
                <h2>Les droits que vous avez sur vos données</h2>
                <p>
                    Si vous avez un compte ou si vous avez laissé des commentaires sur le site, vous pouvez demander à recevoir un fichier contenant
                    toutes les données personnelles que nous possédons à votre sujet, incluant celles que vous nous avez fournies. Vous pouvez
                    également demander la suppression des données personnelles vous concernant. Cela ne prend pas en compte les données stockées
                    à des fins administratives, légales ou pour des raisons de sécurité.
                </p>
            </section>

            <section>
                <h2>Transmission de vos données personnelles</h2>
                <p>
                    Les commentaires des visiteurs peuvent être vérifiés à l’aide d’un service automatisé de détection des commentaires indésirables.
                </p>
            </section>
        </div>
        <Footer />
    </AuthenticatedLayout>

</template>

<script>
import Header from "@/Components/Header.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";

export default {
    components: {Footer, Head, AuthenticatedLayout, Header},
  head() {
    return {
      title: 'Mentions légales - Club Photo Nailloux',
    };
  },
};
</script>

<style scoped>
.mentions-legales {
  padding: 30px;
  background-color: #fff;
  color: #000;
  font-family: 'Helvetica', 'Arial', sans-serif;
  font-size: 14px; /* Réduction de la taille de police */
  line-height: 1.6;
}

h1 {
  font-size: 1.8em;
  margin-bottom: 20px;
  text-align: center;
}

h2 {
  font-size: 1.3em;
  margin-top: 30px;
  margin-bottom: 15px;
}

h3 {
  font-size: 1.1em;
  margin-top: 20px;
  margin-bottom: 10px;
}

p, ul {
  margin-bottom: 15px;
}

ul {
  list-style-type: disc;
  margin-left: 20px;
}

ul li {
  margin-bottom: 8px;
}

a {
  color: #007BFF;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}
</style>
