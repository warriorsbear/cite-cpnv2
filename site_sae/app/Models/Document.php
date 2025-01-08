<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 * Class Document
 *
 * @property int $id_document
 * @property string|null $nom
 * @property string|null $chemin
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

    use HasFactory;

	protected $casts = [
		'id_evenement' => 'int',
		'id_utilisateur' => 'int'
	];

	protected $fillable = [
		'nom',
		'chemin',
		'id_evenement',
		'id_utilisateur'
	];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

	public function event()
	{
		return $this->belongsTo(Evenement::class, 'id_evenement');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_utilisateur');
	}

    public function getDownloadUrlAttribute()
    {
        return route('documents.download', $this->id_document);
    }
}
