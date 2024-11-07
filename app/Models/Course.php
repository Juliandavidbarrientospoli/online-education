<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // ...

    /**
     * Relación muchos a muchos: Un curso tiene muchos usuarios inscritos.
     * Gestionado a través de la tabla intermedia 'inscriptions'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usersEnrolled()
    {
        return $this->belongsToMany(User::class, 'inscriptions')
                    ->withPivot('progress', 'current_video_id')
                    ->withTimestamps();
    }

}
