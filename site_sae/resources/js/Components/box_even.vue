<script lang="ts">
import { defineComponent, ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import ModalPhoto from "@/Components/ModalPhoto.vue";

export default defineComponent({
    name: "box_even",
    components: {ModalPhoto},
    setup(props) {
        const montrerPopup = ref(false);
        const showUpload = ref(false);
        const path = ref('');

        const togglePopup = () => {
            montrerPopup.value = !montrerPopup.value;
        };

        const showUploadPopup = () => {
            showUpload.value = true;
        };

        const isAdmin = computed(() => {
            const user = usePage().props.auth.user;
            return user && user.role === 'admin';
        });
        const isCreateur = computed(() => {
            const user = usePage().props.auth.user;
            return user && user.id === props.id_createur_even;
        });
        const officielStatus = computed(() => {
            return props.Officiel_even ? 'Officiel (créé par un administrateur)' : 'Non officiel';
        });

        return {
            montrerPopup,
            togglePopup,
            showUpload,
            showUploadPopup,
            path,
            isAdmin,
            isCreateur,
            officielStatus
        };
    },
  props: {
      id: {
          type: Number,
          required: true
      },
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
    },
      participe_deja: {
          type: Boolean,
          required: true,
          default: false
      },
      id_createur_even:{
            type: Number,
            required: true
      },
      id_visionnage: {
          type: Number,
          required: false
      }

  },

  methods: {
      showSuccessNotification () {
          Swal.fire({
              icon: 'success',
              title: 'Événement rejoint',
              text: 'Tu as bien rejoint l\'événement'
          });
      },

      showErrorNotification (message) {
          Swal.fire({
              icon: 'error',
              title: 'Tu participes déjà à cet événement !',
              text: message,
          });
      },
    returnimagePath(type: string): string {
      const basePath = '../public/images/evenement/';
      switch (type.toLowerCase()) {
        case 'collaboration':
          return `../public/images/evenement/collaboration.jpeg`;
        case 'cours':
          return `../public/images/evenement/cours.PNG`;
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
    },
      async joinEvent() {
          const user = usePage().props.auth.user;
          const eventId = this.$props.id;
          console.log('id utilisateur :',user );
          console.log('id evenement:', eventId);
          // Assurez-vous que l'ID de l'événement est passé en tant que prop
          try {
              const response = await fetch('http://127.0.0.1:8000/api/participations', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: JSON.stringify({
                      id_utilisateur: user.id,
                      id_evenement: eventId
                  })
              });

              if (!response.ok) {
                  if (response.status === 409) {
                      const errorData = await response.json();
                      console.error('Error response data:', errorData);
                      this.showErrorNotification(errorData.message);
                      this.togglePopup();
                  } else {
                      throw new Error('Network response was not ok');
                  }
              } else {
                  const data = await response.json();
                  console.log('Join event response:', data);
                  this.showSuccessNotification();
                    this.togglePopup();
              }
          } catch (error) {
              console.error('Error joining event:', error.message);
          }
      },
      async SupprEvent() {
          const eventId = this.$props.id;
          try {
              const response = await fetch('http://127.0.0.1:8000/api/evenements', {
                  method: 'DELETE',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: JSON.stringify({
                  id_evenement: eventId
                  })
              });

              if (!response.ok) {
                  throw new Error('Network response was not ok');
              } else {
                  Swal.fire({
                      icon: 'success',
                      title: 'Événement supprimé',
                      text: 'L\'événement a été supprimé avec succès'
                  }).then(() => {
                      window.location.reload();
                  });
              }
          } catch (error) {
              console.error('Error deleting event:', error.message);
          }
      },


      async leaveEvent() {
          const user = usePage().props.auth.user;
          const eventId = this.$props.id;
          try {
              const response = await fetch('http://127.0.0.1:8000/api/participations', {
                  method: 'DELETE',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: JSON.stringify({
                      id_utilisateur: user.id,
                      id_evenement: eventId
                  })
              });

              if (!response.ok) {
                  throw new Error('Network response was not ok');
              } else {
                  Swal.fire({
                      icon: 'success',
                      title: 'Événement quitté',
                      text: 'Tu as bien quitté l\'événement'
                  }).then(() => {
                      window.location.reload();
                  });
              }
          } catch (error) {
                console.error('Error leaving event:', error.message);
          }
      }
      },

    mounted() {
      this.path = this.returnimagePath(this.Type_even);
    }
});

</script>

<template>
  <div class="main_box" @click="togglePopup">
    <img v-if="Type_even=='collaboration'" src="../public/images/evenement/collaboration.jpeg" alt="image" class="event_image">

      <img v-if="Type_even=='cours'" src="../public/images/evenement/cours.PNG" alt="image" class="event_image">

        <img v-if="Type_even=='exposition'" src="../public/images/evenement/exposition.jpg" alt="image" class="event_image">

            <img v-if="Type_even=='information'" src="../public/images/evenement/information.jpg" alt="image" class="event_image">

                <img v-if="Type_even=='reunion'" src="../public/images/evenement/reunion.jpg" alt="image" class="event_image">

                <img v-if="Type_even=='sortie_a_theme'" src="../public/images/evenement/sortie_a_theme.jpg" alt="image" class="event_image">

                    <img v-if="Type_even=='visionnage'" src="../public/images/evenement/Visionnage.jpg" alt="image" class="event_image">



    <div class="event_titre">
      <h4> {{titre_even}} </h4>
        <span v-if="Type_even=='visionnage'" class="badge">Visionnage</span>
    </div>

      <div class="event_details">
          <p class="event_date">{{ formatDate(Date_even) }}</p>
          <p class="event_time">{{ formatTime(Date_even) }}</p>
      </div>
  </div>

    <div v-if="montrerPopup" class="modal" @click.self="togglePopup">
        <div class="popup_content">
            <span class="close_button" @click="togglePopup">&times;</span>
            <div class="popup_image">
                <img v-if="Type_even=='collaboration'" src="../public/images/evenement/collaboration.jpeg" alt="image" class="event_image_popup">

                <img v-if="Type_even=='cours'" src="../public/images/evenement/cours.PNG" alt="image" class="event_image_popup">

                <img v-if="Type_even=='exposition'" src="../public/images/evenement/exposition.jpg" alt="image" class="event_image_popup">

                <img v-if="Type_even=='information'" src="../public/images/evenement/information.jpg" alt="image" class="event_image_popup">

                <img v-if="Type_even=='reunion'" src="../public/images/evenement/reunion.jpg" alt="image" class="event_image_popup">

                <img v-if="Type_even=='sortie_a_theme'" src="../public/images/evenement/sortie_a_theme.jpg" alt="image" class="event_image_popup">

                <img v-if="Type_even=='visionnage'" src="../public/images/evenement/Visionnage.jpg" alt="image" class="event_image_popup">
            </div>
            <div class="popup_details">
                <h1 class="mid">{{ titre_even }}</h1>
                <h3>Type : {{ Type_even }}</h3>
                <h3>Lieu : {{ Lieu_even }}</h3>
                <p>Description : {{ description_even }}</p>
                <p>Officiel : {{ officielStatus }}</p>
                <button v-if="!participe_deja" class="button_rejoindre" @click="joinEvent">Rejoindre</button>
                <button v-if="participe_deja" class="button_quitter" @click="leaveEvent">Quitter</button>
                <button v-if="isAdmin || isCreateur" class="button_quitter" @click="SupprEvent">Supprimer</button>
                <button v-if="Type_even=='visionnage'" class="button_upload" @click="showUploadPopup">Déposer des photos {{id_visionnage}}</button>

                <ModalPhoto v-if="showUpload" :id_visionnage="id_visionnage" :isModalOpen="showUpload" @close="showUpload = false" />
            </div>
        </div>
    </div>


</template>



<style scoped>
.main_box {
    background-color: #ffffff;
    margin: 50px auto;
    width: 300px;
    height: 310px;
    color: rgb(73, 65, 59);
    text-decoration: none;
    display: block;
    font-family: 'Poppins', sans-serif;
    border-radius: 10px;
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.main_box:hover {
    cursor: pointer;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    transform: scale(1.05);
}

.event_image {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.button_quitter {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px;
    border-radius: 5px;
    font-size: 1em;
    cursor: pointer;
    background-color: #d9534f; /* Red background */
    color: white;
    border: none;
    transition: background-color 0.3s ease;
}

.button_quitter:hover {
    background-color: #c9302c; /* Darker red on hover */
}
.badge {
    background-color: #ff9900;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.8em;
    margin-left: 10px;
}

.event_titre {
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
    font-size: 1.2em;
}

.event_titre h4 {
    margin: 0;
    font-size: 1.2em;
    color: #333;
}

.event_titre p {
    margin: 5px 0;
    color: #777;
}

.event_details {
    display: flex;
    justify-content: space-between;
    padding: 15px;
    border-top: 1px solid #e0e0e0;
}

.event_date {
    font-weight: normal;
    color: #000;
}

.event_time {
    font-size: small;
    color: #777;
}

.button_commentaire {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px;
    border-radius: 5px;
    font-size: 1em;
    cursor: pointer;
    background-color: #000000; /* Black background */
    color: white;
    border: none;
    transition: background-color 0.3s ease;
}

.button_commentaire:hover {
    background-color: #333333; /* Darker black on hover */
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
    padding: 30px;
    border-radius: 12px;
    max-width: 800px;
    width: 90%;
    display: flex;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.popup_image {
    flex: 1;
    margin-right: 20px;
    width: 50%; /* Ensure the image takes up the left side */
}

.event_image_popup {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

.popup_details {
    flex: 2;
}

.popup_details h1 {
    font-size: 1.5em;
    margin-bottom: 20px;
    color: #333;
}

.popup_details h3 {
    font-size: 1.2em;
    margin-bottom: 10px;
    color: #555;
}

.popup_details p {
    font-size: 1em;
    margin-bottom: 10px;
    color: #777;
}

.close_button {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
}

.button_rejoindre {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px;
    border-radius: 5px;
    font-size: 1em;
    cursor: pointer;
    background-color: #d68f26;
    color: white;
    border: none;
    transition: background-color 0.3s ease;
}

.button_rejoindre:hover {
    background-color: #b55519;
}

.mid {
    text-align: center;
}
</style>
