<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'age_group',
        'category_id',
        'created_by',
    ];

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

    public function videos()
    {
        return $this->hasMany(Video::class, 'course_id');

    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
