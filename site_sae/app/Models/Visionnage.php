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
 * Class Visionnage
 *
 * @property int $id_visionnage
 * @property Carbon|null $date_visibilite
 * @property Carbon|null $date_diffusion
 * @property int $id_evenement
 *
 * @property Evenement $evenement
 * @property Collection|Photo[] $photos
 *
 * @package App\Models
 */
class Visionnage extends Model
{
	protected $table = 'visionnage';
	protected $primaryKey = 'id_visionnage';
	public $timestamps = false;

    use HasFactory;

	protected $casts = [
		'date_visibilite' => 'datetime',
		'date_diffusion' => 'datetime',
		'id_evenement' => 'int'
	];

	protected $fillable = [
		'date_visibilite',
		'date_diffusion',
        'id_evenement'
	];

    public static function
    create(array $data)
    {
        return self::query()->create($data);
    }

	public function evenement()
	{
		return $this->belongsTo(Evenement::class, 'id_evenement');
	}

	public function photos()
	{
		return $this->hasMany(Photo::class, 'id_visionnage');
	}
}
