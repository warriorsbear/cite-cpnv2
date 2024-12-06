<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Motcle
 *
 * @property int $id_mot_cle
 * @property string|null $texte
 * @property bool|null $statut
 *
 * @property Collection|Decrire[] $decrires
 *
 * @package App\Models
 */
class Motcle extends Model
{
	protected $table = 'motcle';
	protected $primaryKey = 'id_mot_cle';
	public $timestamps = false;

    use HasFactory;

	protected $casts = [
		'statut' => 'bool'
	];

	protected $fillable = [
		'texte',
		'statut'
	];

	public function decrires()
	{
		return $this->hasMany(Decrire::class, 'id_mot_cle');
	}
}
