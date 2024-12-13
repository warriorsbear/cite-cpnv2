<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommentaireEvent
 *
 * @property int $id_commentaire_e
 * @property string|null $texte
 * @property Carbon|null $date_heure
 * @property int $id_evenement
 * @property int $id_utilisateur
 *
 * @property Evenement $evenement
 * @property Utilisateur $utilisateur
 *
 * @package App\Models
 */
class CommentaireEvent extends Model
{
	protected $table = 'commentaire_event';
	protected $primaryKey = 'id_commentaire_e';
	public $timestamps = false;

    use HasFactory;

	protected $casts = [
		'date_heure' => 'datetime',
		'id_evenement' => 'int',
		'id_utilisateur' => 'int'
	];

	protected $fillable = [
		'texte',
		'date_heure',
		'id_evenement',
		'id_utilisateur'
	];

	public function evenement()
	{
		return $this->belongsTo(Evenement::class, 'id_evenement');
	}

	public function utilisateur()
	{
		return $this->belongsTo(User::class, 'id_utilisateur');
	}
}
