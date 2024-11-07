<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    // ...

    /**
     * Relación uno a muchos: Un usuario (administrador) puede crear muchos cursos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coursesCreated()
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    /**
     * Relación muchos a muchos: Un usuario puede estar inscrito en muchos cursos.
     * Gestionado a través de la tabla intermedia 'inscriptions'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coursesEnrolled()
    {
        return $this->belongsToMany(Course::class, 'inscriptions')
                    ->withPivot('progress', 'current_video_id')
                    ->withTimestamps();
    }
}
