<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'email',
        'password',
        'prenom',
        'pseudo',
        'role',
        'adresse',
        'cp',
        'telephone',
        'statut_cotisation',
        'notif_mail',
        'photo_de_profil',
    ];

    protected $attributes = [
        'statut' => 0,
        'statut_cotisation' => 0,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'id_utilisateur');
    }

    /**
     * Gestion de la "suppression' d'un utilisateur
     */
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Update related data to null or "utilisateur supprimé"
            //$user->posts()->update(['id_utilisateur' => null]);
            //$user->comments()->update(['user_id' => null, 'content' => 'utilisateur supprimé']);
            // Update user attributes to "Supprimer"
            $user->update([
                'nom' => 'Supprimer',
                'cp' => 'Suppr',
                'pseudo' => 'Supprimer',
                'prenom' => 'Supprimer',
                'password' => 'Supprimer',
                'role' => 'Supprimer',
                'photo_de_profil' => null,
                'adresse' => 'Supprimer',
                'telephone' => 'Supprimer',
                'statut' => 0,
            ]);
        });
    }
}
