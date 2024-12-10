<script lang="ts">
import { defineComponent, ref } from 'vue';

export default defineComponent({
  name: "box_even",
  setup() {
    const montrerPopup = ref(false);

    const path = ref('');

    const togglePopup = () => {
      montrerPopup.value = !montrerPopup.value;
    };

    return {
      montrerPopup,
      togglePopup,
        path
    };
  },
  props: {
    titre_even: {
      type: String,
      required: true
    },
    description_even: {
      type: String,
      required: true
    },
    Date_even: {
      type: String,
      required: true
    },
    Type_even: {
      type: String,
      required: true
    },
    Lieu_even: {
      type: String,
      required: true
    },
    Officiel_even: {
      type: Boolean,
      required: true
    }

  },

  methods: {
    returnimagePath(type: string): string {
      const basePath = 'http://[::1]:5173/resources/js/public/images/evenement/';
      switch (type.toLowerCase()) {
        case 'collaboration':
          return `${basePath}collaboration.jpeg`;
        case 'cours':
          return `${basePath}cours.PNG`;
        case 'exposition':
          return `${basePath}exposition.jpg`;
        case 'information':
          return `${basePath}information.jpg`;
        case 'reunion':
          return `${basePath}reunion.jpg`;
        case 'sortie_a_theme':
          return `${basePath}sortie_a_theme.jpg`;
        case 'visionnage':
          return `${basePath}Visionnage.jpg`;
        default:
          return `${basePath}cours.PNG`;
      }
    },
    formatDate(dateString: string): string {
      const date = new Date(dateString);
      return date.toLocaleDateString('fr-FR'); // Format de la date en français
    },
    formatTime(dateString: string): string {
      const date = new Date(dateString);
      return date.toLocaleTimeString('fr-FR'); // Format de l'heure en français
    }
  },
    mounted() {
      this.path = this.returnimagePath(this.Type_even);
    }
});
</script>

<template>
  <div class="main_box" @click="togglePopup">

    <img :src="path" alt="image" class="event_image">
    <div class="event_titre">
      <h4> {{titre_even}} </h4>
      <p>{{ formatDate(Date_even) }}</p>
      <p>{{ formatTime(Date_even) }}</p>
    </div>

  </div>

  <div v-if="montrerPopup" class="modal" @click.self="togglePopup">
    <div class="popup_content">
      <span class="close_button" @click="togglePopup">&times;</span>
      <h1 class="mid">{{titre_even}}</h1>
      <h3 >Type : {{Type_even}}</h3>
      <h3>Lieu : {{Lieu_even}}</h3>
      <p> Description : {{ description_even}}</p>
      <p>Officiel :{{Officiel_even}}</p>
      <button class="button_rejoindre">Rejoindre</button>
      <button class="button_rejoindre">Voir commentaire</button>
    </div>
  </div>

</template>



<style scoped>
.main_box{
  background-color: #ffffff;
  margin: 50px auto;
  max-width: 300px;
  min-height: 250px;
  color: rgba(0, 0, 0, 0.87);
  text-decoration: none;
  display: block;
  font-family: 'Poppins', sans-serif;
  border-radius: 10px;
  box-shadow: 0 8px 12px rgba(0, 0, 0, 0.87); /* Adding shadow effect */

}
.main_box:hover{
  cursor: grab;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.87);
  transform: scale(1.05); /* Slightly enlarge the box */
  transition: transform 0.3s ease;
  /* Adding a stronger shadow on hover */

}

.event_titre {
  padding: 15px;
}

.event_image {
  width: 300px; /* Définir une largeur fixe */
  height: 150px; /* Définir une hauteur fixe */
  object-fit: cover;
  display: block;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  font-family: 'Poppins', sans-serif;
}

.popup_content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  max-width: 900px;
  width: 80%;
  text-align: left;
  position: relative;
}

.close_button {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 24px;
  cursor: pointer;
}

.button_rejoindre {
  padding: 10px 15px;
  margin:5px;
  border-radius: 5px;
  font-size: 1em;
  cursor: pointer;
  transition: background-color 0.5s;
}

button:hover{
  background-color: #ff9900;
}


.mid {
  text-align: center;

}



</style>
