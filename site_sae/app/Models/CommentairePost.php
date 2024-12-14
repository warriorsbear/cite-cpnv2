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
 * @property Carbon|null $created_at
 * @property int $id_utilisateur
 * @property int $id_post
 *
 * @property User $utilisateur
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
		'id_utilisateur' => 'int',
		'id_post' => 'int',
        'created_at' => 'timestamp'
	];

	protected $fillable = [
		'texte',
		'created_at',
		'id_utilisateur',
		'id_post'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'id_utilisateur');
	}

	public function post()
	{
		return $this->belongsTo(Post::class, 'id_post');
	}
}
