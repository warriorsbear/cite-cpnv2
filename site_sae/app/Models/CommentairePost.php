<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommentairePost
 *
 * @property int $id_commentaire_p
 * @property string|null $texte
 * @property Carbon|null $date_heure
 * @property int $id_utilisateur
 * @property int $id_post
 *
 * @property Utilisateur $utilisateur
 * @property Post $post
 *
 * @package App\Models
 */
class CommentairePost extends Model
{
	protected $table = 'commentaire_post';
	protected $primaryKey = 'id_commentaire_p';
	public $timestamps = false;

    use HasFactory;

	protected $casts = [
		'date_heure' => 'datetime',
		'id_utilisateur' => 'int',
		'id_post' => 'int'
	];

	protected $fillable = [
		'texte',
		'date_heure',
		'id_utilisateur',
		'id_post'
	];

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
	}

	public function post()
	{
		return $this->belongsTo(Post::class, 'id_post');
	}
}
