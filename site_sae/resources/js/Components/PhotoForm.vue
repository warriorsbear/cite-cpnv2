<template>
    <div>
        <form @submit.prevent="uploadImage">
            <input type="file" @change="onFileChange" />
            <button type="submit">Upload Image</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedFile: null,
        };
    },
    methods: {
        onFileChange(event) {
            this.selectedFile = event.target.files[0];
        },
        async uploadImage() {
            if (!this.selectedFile) {
                alert("Please select a file first.");
                return;
            }

            const formData = new FormData();
            formData.append("image", this.selectedFile);

            try {
                const response = await fetch("http://127.0.0.1:8000/api/photos", {
                    method: "POST",
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error("Erreur lors de l'upload de l'image");
                }

                const data = await response.json();
                console.log("Image uploaded successfully:", data);
            } catch (error) {
                console.error("Error uploading image:", error);
            }
        },
    },
};
</script>
