<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Seld\PharUtils\Timestamps;

/**
 * Class Post
 *
 * @property int $id_post
 * @property string|null $Légende
 * @property int $id_utilisateur
 * @property timestamps created_at
 *
 * @property User $utilisateur
 * @property Collection|CommentairePost[] $commentaire_posts
 * @property Collection|Photo[] $photos
 *
 * @package App\Models
 */
class Post extends Model
{
	protected $table = 'post';
	protected $primaryKey = 'id_post';
	public $timestamps = false;

    use HasFactory;

	protected $casts = [
		'id_utilisateur' => 'int'
	];

	protected $fillable = [
		'Légende',
		'id_utilisateur',
        'created_at'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'id_utilisateur');
	}

	public function commentaire_posts()
	{
		return $this->hasMany(CommentairePost::class, 'id_post');
	}

	public function photos()
	{
		return $this->hasMany(Photo::class, 'id_post');
	}
}
