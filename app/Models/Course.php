<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'age_group',
        'category_id',
        'created_by',
    ];

    /**
     * Define la relación de muchos a muchos entre el curso y los usuarios inscritos,
     * utilizando la tabla pivote 'inscriptions'. Incluye campos adicionales en la
     * tabla pivote, como 'progress' y 'current_video_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usersEnrolled()
    {
        return $this->belongsToMany(User::class, 'inscriptions')
            ->withPivot('progress', 'current_video_id')
            ->withTimestamps();
    }

    /**
     * Define la relación de uno a muchos con los videos asociados al curso.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'course_id');
    }

    /**
     * Define la relación de uno a uno con la categoría del curso.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Accede a los comentarios de los videos del curso a través de una relación de "hasManyThrough".
     * Esto permite obtener todos los comentarios asociados a los videos de un curso.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Video::class, 'course_id', 'video_id');
    }

    /**
     * Accede a los "likes" de los videos del curso a través de una relación de "hasManyThrough".
     * Esto permite obtener todos los likes asociados a los videos de un curso.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function likes()
    {
        return $this->hasManyThrough(Like::class, Video::class, 'course_id', 'video_id');
    }
}
