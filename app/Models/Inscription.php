<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'user_id',
        'progress',
        'current_video_id',
    ];

    /**
     * Relación inversa: Una inscripción pertenece a un curso.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relación inversa: Una inscripción pertenece a un usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación opcional: Una inscripción puede tener un video actual.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentVideo()
    {
        return $this->belongsTo(Video::class, 'current_video_id');
    }
}
