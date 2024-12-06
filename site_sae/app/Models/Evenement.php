<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Evenement
 *
 * @property int $id_evenement
 * @property Carbon|null $date_heure
 * @property string|null $titre
 * @property string|null $descriptif
 * @property string|null $lieu
 * @property string|null $type
 * @property bool|null $officiel
 * @property int|null $id_utilisateur
 *
 * @property Utilisateur|null $utilisateur
 * @property Collection|Participation[] $participations
 * @property Collection|CommentaireEvent[] $commentaire_events
 * @property Collection|Document[] $documents
 * @property Collection|Photo[] $photos
 * @property Visionnage $visionnage
 *
 * @package App\Models
 */
class Evenement extends Model
{
	protected $table = 'evenement';
	protected $primaryKey = 'id_evenement';
	public $timestamps = false;

    use HasFactory;

	protected $casts = [
		'date_heure' => 'datetime',
		'officiel' => 'bool',
		'id_utilisateur' => 'int'
	];

	protected $fillable = [
		'date_heure',
		'titre',
		'descriptif',
		'lieu',
		'type',
		'officiel',
		'id_utilisateur'
	];

    public static function create(array $data)
    {
        return self::query()->create($data);
    }

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
	}

	public function participations()
	{
		return $this->hasMany(Participation::class, 'id_evenement');
	}

	public function commentaire_events()
	{
		return $this->hasMany(CommentaireEvent::class, 'id_evenement');
	}

	public function documents()
	{
		return $this->hasMany(Document::class, 'id_evenement');
	}

	public function photos()
	{
		return $this->hasMany(Photo::class, 'id_evenement');
	}

	public function visionnage()
	{
		return $this->hasOne(Visionnage::class, 'id_evenement');
	}
}
