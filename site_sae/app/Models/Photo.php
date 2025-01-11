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
 * Class Photo
 *
 * @property int $id_photo
 * @property string $nom
 * @property string|null $nom_min
 * @property Carbon|null $date_prise_vue
 * @property Carbon|null $created_at
 * @property string|null $legende
 * @property string|null $exif1
 * @property string|null $exif2
 * @property string|null $exif3
 * @property string|null $exif4
 * @property string|null $exif5
 * @property string|null $exif6
 * @property int|null $id_evenement
 * @property int|null $id_post
 * @property int $id_utilisateur
 * @property int $id_utilisateur_1
 * @property int|null $id_visionnage
 *
 * @property Evenement|null $evenement
 * @property Post|null $post
 * @property Utilisateur $utilisateur
 * @property Visionnage|null $visionnage
 * @property Collection|CommentairePhoto[] $commentaire_photos
 * @property Collection|Decrire[] $decrires
 *
 * @package App\Models
 */
class Photo extends Model
{
	protected $table = 'photo';
	protected $primaryKey = 'id_photo';
	public $timestamps = false;

    use HasFactory;

	protected $casts = [
		'date_prise_vue' => 'datetime',
		'created_at' => 'datetime',
		'id_evenement' => 'int',
		'id_post' => 'int',
		'id_utilisateur' => 'int',
		'id_utilisateur_1' => 'int',
		'id_visionnage' => 'int'
	];

	protected $fillable = [
		'nom',
		'nom_min',
		'date_prise_vue',
		'created_at',
		'legende',
        'chemin',
		'exif1',
		'exif2',
		'exif3',
		'exif4',
		'exif5',
		'exif6',
		'id_evenement',
		'id_post',
		'id_utilisateur',
		'id_utilisateur_1',
		'id_visionnage'
	];

    public function setDatePriseVueAttribute($value)
    {
        $this->attributes['date_prise_vue'] = \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

    public function evenement()
	{
		return $this->belongsTo(Evenement::class, 'id_evenement');
	}

	public function post()
	{
		return $this->belongsTo(Post::class, 'id_post');
	}

	public function utilisateur()
	{
		return $this->belongsTo(User::class, 'id_utilisateur_1');
	}

	public function visionnage()
	{
		return $this->belongsTo(Visionnage::class, 'id_visionnage');
	}

	public function commentaire_photos()
	{
		return $this->hasMany(CommentairePhoto::class, 'id_photo');
	}

	public function decrires()
	{
		return $this->hasMany(Decrire::class, 'id_photo');
	}
}
