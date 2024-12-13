<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Document
 *
 * @property int $id_document
 * @property string|null $nom
 * @property string|null $chemin
 * @property Carbon|null $date_depot
 * @property int|null $id_evenement
 * @property int $id_utilisateur
 *
 * @property Evenement|null $evenement
 * @property Utilisateur $utilisateur
 *
 * @package App\Models
 */
class Document extends Model
{
	protected $table = 'document';
	protected $primaryKey = 'id_document';
	public $timestamps = false;

    use HasFactory;

	protected $casts = [
		'date_depot' => 'datetime',
		'id_evenement' => 'int',
		'id_utilisateur' => 'int'
	];

	protected $fillable = [
		'nom',
		'chemin',
		'date_depot',
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
