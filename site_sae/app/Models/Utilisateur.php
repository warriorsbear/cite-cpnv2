<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Database\Factories\UtilisateurFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Utilisateur
 *
 * @property int $id_utilisateur
 * @property string|null $pseudo
 * @property string $nom
 * @property string $prenom
 * @property string|null $adresse
 * @property string|null $cp
 * @property string|null $ville
 * @property string|null $telephone
 * @property string $mail
 * @property string $mdp
 * @property string|null $role
 * @property bool|null $statut
 * @property bool|null $notif_mail
 * @property bool|null $statut_cotisation
 *
 * @property Collection|Participation[] $participations
 * @property Collection|CommentaireEvent[] $commentaire_events
 * @property Collection|CommentairePhoto[] $commentaire_photos
 * @property Collection|CommentairePost[] $commentaire_posts
 * @property Collection|Document[] $documents
 * @property Collection|Evenement[] $evenements
 * @property Collection|Photo[] $photos
 * @property Collection|Post[] $posts
 *
 * @package App\Models
 */
class Utilisateur extends Model
{
	protected $table = 'utilisateur';
	protected $primaryKey = 'id_utilisateur';
	public $timestamps = false;

    use HasFactory;

	protected $casts = [
		'statut' => 'bool',
		'notif_mail' => 'bool',
		'statut_cotisation' => 'bool'
	];

	protected $fillable = [
		'pseudo',
		'nom',
		'prenom',
		'adresse',
		'cp',
		'ville',
		'telephone',
		'mail',
		'mdp',
		'role',
		'statut',
		'notif_mail',
		'statut_cotisation',
        'photo_de_profile'
	];

    public function participations()
	{
		return $this->hasMany(Participation::class, 'id_utilisateur');
	}

	public function commentaire_events()
	{
		return $this->hasMany(CommentaireEvent::class, 'id_utilisateur');
	}

	public function commentaire_photos()
	{
		return $this->hasMany(CommentairePhoto::class, 'id_utilisateur');
	}

	public function commentaire_posts()
	{
		return $this->hasMany(CommentairePost::class, 'id_utilisateur');
	}

	public function documents()
	{
		return $this->hasMany(Document::class, 'id_utilisateur');
	}

	public function evenements()
	{
		return $this->hasMany(Evenement::class, 'id_utilisateur');
	}

	public function photos()
	{
		return $this->hasMany(Photo::class, 'id_utilisateur_1');
	}

	public function posts()
	{
		return $this->hasMany(Post::class, 'id_utilisateur');
	}
}
