<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";

const utilisateurs = ref([]); //variable réactive pour stocker les utilisateurs
const recherche = ref(''); //variable réactive qui stock la recherche
const entrainDeCharger = ref(true); //variable réactive pour savoir si on est en train de charger les utilisateurs
const UtilisateurConnecter = usePage().props.auth.user; //variable pour stocker les informations de l'utilisateur connecté
const RecuperationUtilisateurs = async () => {
  try {
    let response = await fetch('http://127.0.0.1:8000/api/utilisateurs');
    utilisateurs.value = await response.json(); // Lit le corps en tant que JSON et le stocke dans `users`
    console.log("Les utilisateurs ont été récupérés :", utilisateurs.value);
  } catch (error) {
    console.error('Erreur lors de la récupération des utilisateurs:', error);
  }finally{
    if(utilisateurs.value.length !== 0){
      entrainDeCharger.value = false;
    }

  }
};

// Calculer le nombre d'utilisateurs
const nombreUtilisateurs = computed(() => {
  return utilisateurs.value.length;
});

//filtrer les utilisateurs en fonction de la recherche
const UtilisateurFiltre = computed(() => {
  if(!recherche.value){
    return utilisateurs.value;
  }
  return utilisateurs.value.filter(utilisateur =>
      utilisateur.pseudo.toLowerCase().includes(recherche.value.toLowerCase()) ||
      utilisateur.nom.toLowerCase().includes(recherche.value.toLowerCase()) ||
      utilisateur.prenom.toLowerCase().includes(recherche.value.toLowerCase())
  );
});

const UtilisateurQuiOnPasPaye = computed(() => {
  return utilisateurs.value.filter(utilisateur => utilisateur.statut_cotisation == false);
});

// Appelle la fonction lorsque le composant est monté (complétement chargé dans le DOM)
onMounted(() => {
  RecuperationUtilisateurs();
});
</script>

<template>
    <Head title="Messagerie" />

    <AuthenticatedLayout>

        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Messagerie
            </h2>
        </template>
          <main>
            <h1>Bienvenue sur votre tableau de bord {{UtilisateurConnecter.nom}} !</h1>
            <!-- Afficher l'icône de chargement si les données sont en cours de chargement -->
            <div v-if="entrainDeCharger" class="loading-icon">
              <img src="\public\images\loading.gif" alt="Loading..." />
            </div>
              <div v-else id="pageCharger">
                <div id="avantStat">
                  <div id="zone1">
                    <div id="hautDeZone">
                      <h3 >Gérez vos membres :</h3>
                      <form class="search-bar" @submit.prevent>
                        <input type="search" v-model="recherche" placeholder="Rechercher..." />
                        <button type="submit">🔍</button>
                      </form>
                    </div>
                    <div id="zoneScroll">
                      <!--créer une balise div pour chaques utilisteurs filtrés-->
                      <div v-for="utilisateur in UtilisateurFiltre" :key="utilisateur.id_utilisateur" class="user">
                        <img v-if="utilisateur.photo_de_profile" :src="utilisateur.photo_de_profile" alt="logo" id="pp" width="100" height="100">
                        <div class="infoUtilisateur">
                          <p id="pseudo">{{utilisateur.pseudo}}</p>
                          <p>{{utilisateur.nom}} {{utilisateur.prenom}}</p>
                        </div>
                        <div id="boutons">
                          <button @click="handleClick(utilisateur)">Modifier</button>
                          <button @click="handleClick(utilisateur)">Supprimer</button>
                          <button @click="handleClick(utilisateur)">Profil</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <br><br>

                  <div id="zone2">
                    <div id="hautDeZone">
                      <h3>Utilisateurs qui n'ont pas payé leur cotisation :</h3>
                      <form class="search-bar" @submit.prevent>
                        <input type="search" v-model="recherche" placeholder="Rechercher..." />
                        <button type="submit">🔍</button>
                      </form>
                    </div>
                    <div id="zoneScroll">
                      <!--créer une balise div pour chaques utilisteurs filtrés-->
                      <div v-for="utilisateur in UtilisateurQuiOnPasPaye" :key="utilisateur.id_utilisateur" class="user">
                        <img v-if="utilisateur.photo_de_profile" :src="utilisateur.photo_de_profile" alt="logo" id="pp" width="100" height="100">
                        <div class="infoUtilisateur">
                          <p id="pseudo">{{utilisateur.pseudo}}</p>
                          <p>{{utilisateur.nom}} {{utilisateur.prenom}}</p>
                        </div>
                        <div id="boutons">
                          <button @click="handleClick(utilisateur)">Accepter</button>
                          <button @click="handleClick(utilisateur)">Refuser</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="stat">
                  <div id="stat1">
                    <h3>Il y a actuellement :</h3>
                    <h1 id="nombre">{{nombreUtilisateurs}}</h1>
                    <h3>utilisateurs inscrits</h3>
                  </div>
                  <div id="stat2">
                    <h3>Dont :</h3>
                    <h1 id="nombre">{{UtilisateurQuiOnPasPaye.length}}</h1>
                    <h3>utilisateurs qui n'ont pas payé leur cotisation</h3>
                  </div>
                  <div id="stat3">
                    <h3>Il y a actuellement :</h3>
                    <h1 id="nombre">{{nombreUtilisateurs}}</h1>
                    <h3>utilisateurs inscrits</h3>
                  </div>
                </div>
              </div>

          </main>
        </AuthenticatedLayout>
</template>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
main{
  flex-grow: 1;
  display: flex;
  flex-direction: column;

  font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif;
  color: #2a2828;
}
.loading-icon {
  display: flex;
  flex: 1;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100%;
}

h1{
  margin-top: 2%;
  padding-left: 4%;
  margin-bottom: 2%;
  justify-self: center;
  text-align: center;
  width: 100%;
}
h3{
  width: 100%;
  font-style: normal;
}
div#pageCharger{
  display: flex;
  flex-direction: column;
  flex: 1;
  align-items: center;
  height: 100%;
}
div#avantStat{
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  align-items: center;
  width: 90%;
  height: 50vh;
  margin-top: 2%;
  margin-bottom: 2%;
}
div#zone1, #zone2 {
  height: 28.5rem;
  width: 45%;
  background-color: #eae3e3;
  border-radius: 10px;
  border : 2px solid black;
}
div#zoneScroll{
  align-self: flex-end;
  height: 80%;
  width: 100%;
  overflow-y: scroll;

  border-top: 4px solid #8b8d8d;

}
/*Style scrollbar trouver sur le site : https://css-tricks.com/the-current-state-of-styling-scrollbars-in-css/ */
div#zoneScroll::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  border-radius: 10px;
  background-color: rgba(62, 62, 62, 0.71);
}
div#zoneScroll::-webkit-scrollbar {
  width: 12px;
  background-color: rgba(191, 190, 190, 0.71);
  border-radius: 10px;
}
div#zoneScroll::-webkit-scrollbar-thumb {
  border-radius: 10px;
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
  background-color: #8b8d8d;
}
#zoneScroll > :first-child{
  margin-top: 0;
  border-top : none;
}
div#hautDeZone{
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  padding: 10px;

}

.user{
  display: flex;
  flex-direction: row;
  justify-content: left;
  align-items: flex-start;
  max-height: 120px;
  min-width: 100%;

  flex-grow: 1;
  flex-shrink: 1;

  border-top: 3px solid #8b8d8d;
  border-left: none;
  border-right: none;
  margin-top : 1%;
  padding: 10px;
}
.user img{
  border:2px solid #8b8d8d;
  border-radius: 50%;
}
.user>.infoUtilisateur{
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;
  justify-content: center;
  margin-left: 10px;
  align-self: center;
  width: 20%;

font-family: 'Lucida Sans Unicode', 'Lucida Grande', sans-serif;
}
#pseudo{
  Font-size: 1.5em;
  font-weight: bold;
}
.user>#boutons{
  flex:1;
  min-width: 20%;
  height: 100%;
  align-self: flex-end;
  justify-content: flex-end;
  display: flex;
}
#boutons button{
  padding: 5px;
  margin: 5px;
  margin-right: 6%;
  border: none;
  border-radius: 5px;
  background-color: #8b8d8d;
  cursor: pointer;
  font-size: 15px;
  transition: background-color 0.3s ease;
}
#boutons button:hover{
  background-color: #8b8d8d;
  transform: scale(1.1);
}

div#stat{
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  align-items: center;
  width: 90%;
  height: 40vh;
  margin-top: 2%;
  margin-bottom: 2%;
}
div#stat1, div#stat2, div#stat3{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 30%;
  height: 70%;

  background-color: #eae3e3;
  border-radius: 20px;
}

h1#nombre{
  border: 4px solid #dda115;
  border-radius: 50%;
  padding: 20px;
  display: inline-block;
  text-align: center;
  width: 100px;
  height: 100px;
  background-color: #eae3e3;
    font-size: 2em;
}
#stat1 h3, #stat3 h3, #stat2 h3{
  width: 100%;
  font-style: normal;
  text-align: center;
}

/*Style barre de recherche*/
.search-bar {
  height: 10%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 10px;
}
.search-bar input {
  width: 200px;
  padding: 10px;
  border: 2px solid #8b8d8d;
  border-radius: 5px 0 0 5px;
  font-size: 16px;
  outline: none;
  transition: border 0.3s ease;
}
.search-bar input:focus {
  border-color: #8b8d8d;
}
.search-bar button {
  padding: 10px 20px;
  border: 2px solid #8b8d8d;
  background-color: #8b8d8d;
  color: white;
  border-radius: 0 5px 5px 0;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
}
.search-bar button:hover {
  background-color: #8b8d8d;
}
</style>
