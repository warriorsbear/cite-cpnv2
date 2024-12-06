<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Decrire
 *
 * @property int $id_photo
 * @property int $id_mot_cle
 *
 * @property Photo $photo
 * @property Motcle $motcle
 *
 * @package App\Models
 */
class Decrire extends Model
{
	protected $table = 'decrire';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_photo' => 'int',
		'id_mot_cle' => 'int'
	];

    use HasFactory;

	public function photo()
	{
		return $this->belongsTo(Photo::class, 'id_photo');
	}

	public function motcle()
	{
		return $this->belongsTo(Motcle::class, 'id_mot_cle');
	}
}
