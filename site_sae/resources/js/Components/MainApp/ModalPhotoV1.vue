<template>
  <div>
    <!-- Modal trigger button -->
    <BoutonPlus class="btn-primary" @click="showModal = true" />

    <!-- Modal structure for uploading a photo -->
    <div v-if="showModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="uploadPhotoModalLabel"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploadPhotoModalLabel">Publier une photo</h5>
            <button type="button" class="close" @click="showModal = false" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="modal-scroll">
              <form @submit.prevent="uploadPhoto">
                <!-- Dropzone pour l'upload de photo -->
                <div class="form-group dropzone" @drop.prevent="handleDrop" @dragover.prevent @click="triggerFileInput">
                  <p v-if="!photoFile" class="dropzone-placeholder">
                    Cliquez pour ajouter des photos<br>ou faites glisser-déposer
                  </p>
                  <p v-else class="dropzone-file">
                    {{ photoFile.name }}
                  </p>
                  <input type="file" class="form-control-file" @change="handleFileUpload" ref="fileInput"
                         accept="image/*" hidden>
                </div>

                <!-- Author name -->
                <div class="form-group">
                  <label for="authorName">Nom de l'auteur</label>
                  <input type="text" class="form-control" v-model="authorName" placeholder="Entrez votre nom" required>
                </div>

                <!-- Photo title -->
                <div class="form-group">
                  <label for="photoTitle">Titre de la photo</label>
                  <input type="text" class="form-control" v-model="photoTitle" placeholder="Entrez le nom de la photo" required>
                </div>

                <!-- Capture date -->
                <div class="form-group">
                  <label for="captureDate">Date de la prise de vue</label>
                  <input type="date" class="form-control" v-model="captureDate" required>
                </div>

                <!-- Keywords -->
                <div class="form-group">
                  <label for="keywords">Mots-clé (séparés par , )</label>
                  <input type="text" class="form-control" v-model="keywords" placeholder="e.g. montagne, sunset"
                         required>
                </div>

                <!-- Description -->
                <div class="form-group">
                  <label for="photoDescription">Description</label>
                  <br>
                  <textarea class="form-control" v-model="photoDescription" rows="3"
                            placeholder="Décrivez votre photo..."
                            required></textarea>
                </div>

                <!-- Visibility options -->
                <div class="form-group">
                  <label for="visibility">Visibilité</label>
                  <select class="form-control" v-model="visibility" required>
                    <option value="public">Privée</option>
                    <option value="private">Publique</option>
                    <option value="visionnage">Visionnage</option>
                  </select>
                </div>

                <!-- Watermark option -->
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" v-model="addWatermark">
                  <label class="form-check-label" for="addWatermark">Ajouter un watermak sur la photo</label>
                </div>

              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="showModal = false">Annuler</button>
            <button type="submit" class="btn btn-upload" @click="uploadPhoto">Publier</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import BoutonPlus from "@/Components/MainApp/BoutonPlus.vue";

export default {
  components: {BoutonPlus},
  data() {
    return {
      showModal: false,
      photoFile: null,
      authorName: '',
      photoTitle: '',
      captureDate: '',
      keywords: '',
      photoDescription: '',
      visibility: 'public',
      addWatermark: false
    };
  },
  methods: {
    handleFileUpload(event) {
      this.photoFile = event.target.files[0];
    },
    handleDrop(event) {
      this.photoFile = event.dataTransfer.files[0];
    },
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    uploadPhoto() {
      // Handle photo upload logic here
      console.log({
        photoFile: this.photoFile,
        authorName: this.authorName,
        photoTitle: this.photoTitle,
        captureDate: this.captureDate,
        keywords: this.keywords,
        photoDescription: this.photoDescription,
        visibility: this.visibility,
        addWatermark: this.addWatermark
      });
      this.showModal = false;
    }
  }
};
</script>

<style scoped>
.modal {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1050;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  border-bottom: 1px solid #dee2e6;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.modal-header span {
  font-size: 1rem;
  cursor: pointer;
  padding: 0 0.3rem;
}

.close {
  background: none;
  border: none;
  cursor: pointer;
}

.close span {
  font-size: 1.5rem;
}

.modal-scroll {
  max-height: 65vh;
  overflow-y: auto;
  padding: 1rem;
  scrollbar-width: none;
}

.modal-scroll:hover {
  scrollbar-width: thin;
}


.modal-dialog {
  max-width: 32rem;
  margin: auto;
  padding: 1rem;
  border-radius: 10px;
  background-color: white;
}

.modal-footer {
  display: flex;
  justify-content: space-between;
  padding: 1rem 1rem 0.5rem 1rem;
  border-top: 1px solid #dee2e6;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
}

.btn {
  cursor: pointer;
  background-color: #bbb;
  color: black;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  font-size: large;
}

.btn-primary {
  position: fixed;
  bottom: 20px;
  right: 20px;
}

.btn-upload {
  background-color: #d79026;
  color: white;

}

.btn-primary img {
  width: 4rem;
  height: 4rem;
}

.form-group {
  margin-bottom: 1rem;
}

label {
  font-weight: 500;
  padding-right: 0.5rem;
}

input, select, textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  color: #000;
  resize: none;
}

input:focus, select:focus, textarea:focus {
  border-color: #d79026;
  outline: none;
}

.dropzone {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 150px;
  border: 2px dashed #ccc;
  border-radius: 10px;
  margin-bottom: 20px;
  background-color: #f9f9f9;
  cursor: pointer;
}

.dropzone:hover {
  background-color: #f1f1f1;
}

.dropzone-placeholder {
  text-align: center;
  color: #888;
}

.dropzone-file {
  text-align: center;
  color: #444;
}

.form-check {
  display: flex;
  font-size: small;
  input {
    width: auto;
    margin-right: 0.5rem;
  }
}
</style>
