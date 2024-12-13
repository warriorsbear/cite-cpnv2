<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Participation
 *
 * @property int $id_utilisateur
 * @property int $id_evenement
 * @property int $presence
 *
 * @property Utilisateur $utilisateur
 * @property Evenement $evenement
 *
 * @package App\Models
 */
class Participation extends Model
{
	protected $table = 'participation';
	public $incrementing = false;
	public $timestamps = false;

    use HasFactory;

	protected $casts = [
		'id_utilisateur' => 'int',
		'id_evenement' => 'int',
        'presence' => 'int'
    ];

	protected $fillable = [
		'presence'
	];

    public static function create(array $data)
    {
        return self::query()->create($data);
    }

	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
	}

	public function evenement()
	{
		return $this->belongsTo(Evenement::class, 'id_evenement');
	}
}
