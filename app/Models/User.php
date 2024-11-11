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

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relación uno a muchos: Un usuario (administrador) puede crear muchos cursos.
     */
    public function coursesCreated()
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    /**
     * Relación uno a muchos: Un usuario puede tener muchas inscripciones.
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    /**
     * Relación muchos a muchos a través de Inscription:
     * Obtener los cursos en los que el usuario está inscrito.
     */
    public function coursesEnrolled()
    {
        return $this->hasManyThrough(Course::class, Inscription::class, 'user_id', 'id', 'id', 'course_id');
    }

    public function videos()
    {
    return $this->belongsToMany(Video::class, 'video_user')
                ->withPivot('completed')
                ->withTimestamps();
    }
}
