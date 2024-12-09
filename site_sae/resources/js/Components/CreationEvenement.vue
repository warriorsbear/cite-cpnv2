<script>
import { defineComponent, ref } from 'vue';
export default defineComponent( {
  name: "CreationEvenement",
  props: {
    visible: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      event: {
        titre_even: '',
        date_even: '',
        description_even: '',
        Lieu_even: '',
        id_utilisateur: '',
        Officiel_even: true,
        Type_even: ''
      },
      Date_even: '',
      heure_even: ''
    };
  },
  methods: {
    async submitForm() {
      this.event.date_heure = `${this.Date_even}T${this.heure_even}`;
      try {
        const response = await fetch('http://127.0.0.1:8000/api/evenements', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(this.event),
        });
        if (!response.ok) {
          throw new Error('Erreur lors de l\'ajout de l\'événement');
        }
        const data = await response.json();
        console.log('Événement ajouté avec succès:', data);
        this.close();
      } catch (error) {
        console.error('Erreur lors de l\'ajout de l\'événement:', error);
      }
    },
    close() {
      this.$emit("close");
    }
  }
});
</script>

<template>
  <div v-if="visible" class="modal-overlay" @click.self="close">
    <div class="modal-content">
      <h1>Créer un Événement</h1>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="name">Titre de l'événement :</label>
          <input type="text" id="name" v-model="event.titre_even" required />
        </div>

        <div class="form-group">
          <label for="date">Date :</label>
          <input type="date" id="date" v-model="Date_even" required />
        </div>

        <div class="form-group">
          <label for="date">heure :</label>
          <input type="time" id="date" v-model="heure_even" required />
        </div>

        <div class="form-group">
          <label for="date">Description :</label>
          <input type="text" id="date" v-model="event.description_even" required />
        </div>

        <div class="form-group">
          <label for="location">Lieu :</label>
          <input type="text" id="location" v-model="event.Lieu_even" required />
        </div>

        <div class="form-group">
          <label for="type">Type d'événement :</label>
          <select id="type" v-model="event.Type_even" required>
            <option disabled value="">Sélectionner un type</option>
            <option>Cours</option>
            <option>Sortie à thème</option>
            <option>Exposition</option>
            <option>Réunion</option>
            <option>Info exterieur</option>
            <option>Collaboration extérieur</option>
            <option>Visionnage</option>
          </select>
        </div>

        <button class="buttons" type="submit" @click="submitForm">Créer l'événement</button>
        <button class="buttons" type="button" @click="close">Annuler</button>
      </form>
    </div>
  </div>
</template>


<style scoped>
.modal-overlay {
position: fixed;
top: 0;
left: 0;
right: 0;
bottom: 0;
background-color: rgba(0, 0, 0, 0.7);
display: flex;
align-items: center;
justify-content: center;
z-index: 1000;
}

.modal-content {
background-color: #ffffff;
padding: 30px;
border-radius: 10px;
width: 400px;
max-width: 90%;
color: rgba(0, 0, 0, 0.87);
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

h1 {
color: rgba(0, 0, 0, 0.87);
margin-bottom: 20px;
font-size: 1.5em;
text-align: center;
}

.form-group {
margin-bottom: 15px;
}

label {
display: block;
font-weight: bold;
margin-bottom: 5px;
color: rgba(0, 0, 0, 0.87);
}

input, select {
width: 100%;
padding: 10px;
border: 1px solid #444;
border-radius: 5px;
background-color: #ffffff;
color: rgba(0, 0, 0, 0.87);
}

input::placeholder, select option {
color: rgba(0, 0, 0, 0.87);
}

input:focus, select:focus {
outline: none;
border-color: #ff8800;
}

.buttons {
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



</style>
