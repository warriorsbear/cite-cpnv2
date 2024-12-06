<?php

namespace Database\Seeders;

use App\Models\CommentaireEvent;
use App\Models\CommentairePhoto;
use App\Models\CommentairePost;
use App\Models\Decrire;
use App\Models\Document;
use App\Models\Evenement;
use App\Models\Motcle;
use App\Models\Participation;
use App\Models\Photo;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Utilisateur;
use App\Models\Visionnage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(5)->create([
            'nom' => 'User',
        ]);

        User::factory()->create([
            'nom' => 'admin',
            'prenom'=>'admin',
            'pseudo' => 'admin',
            'email' => 'admin@admin.com',
            'password'=> Hash::make('admin')
        ]);

        Utilisateur::factory(10)->create([
            'photo_de_profile' => 'http://127.0.0.1:8000/storage/photo_profile/avatar.jpg'
        ]);
        Utilisateur::factory(2)->create(['role' => 'admin']);

        // Crée 10 posts avec un utilisateur aléatoire
        Post::factory()->count(10)->create([
            'id_utilisateur' => fn() => Utilisateur::all()->random()->id_utilisateur
        ]);

        // Crée 10 commentaires de post avec un utilisateur aléatoire et un post spécifique
        CommentairePost::factory()->count(10)->create([
            'id_utilisateur' => fn() => Utilisateur::all()->random()->id_utilisateur,
            'id_post' => fn() => Post::all()->random()->id_post
        ]);

        // Crée 10 photos avec un utilisateur aléatoire, un autre utilisateur aléatoire et un post aléatoire
        Photo::factory(10)->create([
            'id_utilisateur' => function () use (&$idUtilisateur) {
                $idUtilisateur = Utilisateur::all()->random()->id_utilisateur;
                return $idUtilisateur;
            },
            'id_utilisateur_1' => function () use (&$idUtilisateur) {
                return $idUtilisateur;
            },
            'id_post' => fn() => Post::all()->random()->id_post,
            'chemin' => 'http://127.0.0.1:8000/storage/photos/inoxtag.jpg'
        ]);

        // Crée 10 mots clés
        Motcle::factory(10)->create();

        // Crée 10 commentaires de photo avec un utilisateur aléatoire et une photo spécifique
        CommentairePhoto::factory(10)->create([
            'id_utilisateur' => fn() => Utilisateur::all()->random()->id_utilisateur,
            'id_photo' => fn() => Photo::all()->random()->id_photo
        ]);

        // Crée 10 événements
        Evenement::factory(10)->create([
            'id_utilisateur' => fn() => Utilisateur::all()->random()->id_utilisateur
        ]);

        // Crée 10 commentaires d'événement avec un utilisateur aléatoire et un événement spécifique
        CommentaireEvent::factory(10)->create([
            'id_utilisateur' => fn() => Utilisateur::all()->random()->id_utilisateur,
            'id_evenement' => fn() => Evenement::all()->random()->id_evenement
        ]);

        // Crée 10 documents
        Document::factory(10)->create([
            'id_utilisateur' => fn() => Utilisateur::all()->random()->id_utilisateur,
            'id_evenement' => fn() => Evenement::all()->random()->id_evenement,
            // 'chemin' => 'http://127.0.0.1:8000/storage/documents/inoxtag.pdf'
        ]);

        // Crée 10 visionnages avec un événement spécifique unique pour chaque visionnage
        $evenements = Evenement::all();
        foreach ($evenements as $evenement) {
            // Si l'évenement n'est pas un visionnage ou qu'un visionnage est déjà prévu pour cet évènement,
            // on passe à l'évènement suivant
            if (Visionnage::where('id_evenement', $evenement->id_evenement)->exists() || $evenement->type !== 'visionnage') {
                continue;
            }
            Visionnage::factory()->create([
                'id_evenement' => $evenement->id_evenement
            ]);
        }

        // Crée des participations avec un utilisateur aléatoire et un événement spécifique
        // Si l'utilisateur est déjà inscrit à l'événement, on passe à l'événement suivant
        // mais l'utilisateur ne doit pas être inscrit à tous les évènements
        $evenements = Evenement::all();
        $utilisateurs = Utilisateur::all();
        foreach ($evenements as $evenement) {
            $idEvenement = $evenement->id_evenement;
            $idUtilisateur = $utilisateurs->random()->id_utilisateur;
            if (Participation::where('id_evenement', $idEvenement)->where('id_utilisateur', $idUtilisateur)->exists()) {
                continue;
            }
            Participation::factory()->create([
                'id_evenement' => $idEvenement,
                'id_utilisateur' => $idUtilisateur,
                'presence' => true
            ]);
        }

        // Crée 10 descriptions avec un utilisateur aléatoire et un mot clé spécifique
        $photos = Photo::all();
        foreach ($photos as $photo) {
            $idMotcle = Motcle::all()->random()->id_mot_cle;
            if (Decrire::where('id_mot_cle', $idMotcle)->where('id_photo', $photo->id_photo)->exists()) {
                continue;
            }
            Decrire::factory()->create([
                'id_mot_cle' => $idMotcle,
                'id_photo' => $photo->id_photo
            ]);
        }
    }


}
