<script setup >
import { Head, Link } from '@inertiajs/vue3';
import Footer from "@/Components/Footer.vue";
import guest from "@/Layouts/GuestLayout.vue";
import newheaderauthentifie from "@/Layouts/newheaderauthentifie.vue";
import NavLink from "@/Components/NavLink.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Bienvenue" />

    <header
        class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3"
    >
        <div class="flex lg:col-start-2 lg:justify-center">
            <img src="../public/logo-CPN-Noir.png" alt="Application Logo" class="w-1/2 lg:w-1/4" />
        </div>
        <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] "
            >
                Dashboard
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] "
                >
                    Log in
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] "
                >
                    Register
                </Link>
            </template>
        </nav>
    </header>

  <main>
    <!-- Section principale avec image et introduction -->
    <section class="main-section">
      <div class="container">
        <div class="main-content">
          <!-- Image principale (alignée à gauche) -->
          <div class="main-image">
            <img src="../public/images/image1.jpg" alt="Présentation du club photo" />
          </div>

          <!-- Texte d'introduction (aligné à droite) -->
          <div class="main-text">
            <h2>Bienvenue au Club Photo Nailloux</h2>
            <p>
              Partageons notre passion pour la photographie et capturons des moments
              inoubliables ensemble. Rejoignez-nous pour explorer la magie de
              l'art photographique.
            </p>

          </div>
        </div>
      </div>
    </section>

    <!-- Section Galerie avec trois photos alignées -->
    <section class="gallery-section">
      <div class="container">
        <h3>Nos Activités en Images</h3>
        <div class="gallery-grid">
          <div class="gallery-item">
            <img src="../public/images/image1.jpg" alt="Sortie photo nature" />
            <p>Sortie Photo Nature</p>
          </div>
          <div class="gallery-item">
            <img src="../public/images/image1.jpg" alt="Atelier studio photo" />
            <p>Atelier Studio</p>
          </div>
          <div class="gallery-item">
            <img src="../public/images/image1.jpg" alt="Évènement photo de groupe" />
            <p>Événements</p>
          </div>
        </div>
      </div>
    </section>
  </main>
    <Footer />
</template>

<style scoped>
/* Section principale avec image et texte */
.main-section {
  padding: 60px 0;
  background-color: #fff;
}

.main-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
}

.main-image img {
  max-width: 100%;
  border-radius: 10px;
  box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}

.main-text {
  max-width: 50%;
}

.main-text h2 {
  font-size: 2.5rem;
  color: #333;
  margin-bottom: 20px;
}

.main-text p {
  font-size: 1.2rem;
  color: #666;
  margin-bottom: 30px;
}



/* Section Galerie */
.gallery-section {
  padding: 60px 0;
  background-color: #f9f9f9;
  text-align: center;
}

.gallery-section h3 {
  font-size: 2rem;
  color: #333;
  margin-bottom: 40px;
}

.gallery-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.gallery-item img {
  width: 100%;
  border-radius: 10px;
  box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}

.gallery-item p {
  margin-top: 10px;
  font-size: 1rem;
  color: #333;
  text-align: center;
}
</style>
