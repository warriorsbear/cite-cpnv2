<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommentairePhoto
 *
 * @property int $id_commentaire_p
 * @property string|null $texte
 * @property Carbon|null $date_heure
 * @property int $id_utilisateur
 * @property int $id_photo
 *
 * @property Utilisateur $utilisateur
 * @property Photo $photo
 *
 * @package App\Models
 */
class CommentairePhoto extends Model
{
	protected $table = 'commentaire_photo';
	protected $primaryKey = 'id_commentaire_p';
	public $timestamps = false;

    use HasFactory;

	protected $casts = [
		'date_heure' => 'datetime',
		'id_utilisateur' => 'int',
		'id_photo' => 'int'
	];

	protected $fillable = [
		'texte',
		'date_heure',
		'id_utilisateur',
		'id_photo'
	];

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
	}

	public function photo()
	{
		return $this->belongsTo(Photo::class, 'id_photo');
	}
}
