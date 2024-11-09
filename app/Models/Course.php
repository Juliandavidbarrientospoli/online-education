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

    // Relación con usuarios inscritos
    public function usersEnrolled()
    {
        return $this->belongsToMany(User::class, 'inscriptions')
            ->withPivot('progress', 'current_video_id')
            ->withTimestamps();
    }

    // Relación con videos
    public function videos()
    {
        return $this->hasMany(Video::class, 'course_id');
    }

    // Relación con categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Acceso a comentarios a través de los videos del curso
    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Video::class, 'course_id', 'video_id');
    }

    // Acceso a likes a través de los videos del curso
    public function likes()
    {
        return $this->hasManyThrough(Like::class, Video::class, 'course_id', 'video_id');
    }
}
