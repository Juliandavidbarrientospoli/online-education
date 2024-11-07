<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Video;
use App\Models\Category;
use App\Models\Course;

class VideoManager extends Component
{
    public $course;
    public $videos;
    public $categories;
    public $title, $url, $category_id;
    public $video_id;
    public $isEditing = false;

    /**
     * Reglas de validación para el formulario.
     *
     * @var array<string, mixed>
     */
    protected $rules = [
        'title' => 'required|string|max:255',
        'url' => 'required|url',
        'category_id' => 'required|exists:categories,id',
    ];

    /**
     * Método de ciclo de vida que se ejecuta al montar el componente.
     * Carga el curso, las categorías y los videos asociados.
     *
     * @param int $courseId Identificador del curso.
     * @return void
     */
    public function mount($courseId)
    {
        $this->course = Course::findOrFail($courseId);
        $this->categories = Category::all();
        $this->loadVideos();
    }

    /**
     * Carga los videos del curso actual.
     *
     * @return void
     */
    public function loadVideos()
    {
        $this->videos = $this->course->videos;
    }

    /**
     * Crea un nuevo video para el curso actual.
     *
     * @return void
     */
    public function createVideo()
    {
        $this->validate();

        Video::create([
            'course_id' => $this->course->id,
            'title' => $this->title,
            'url' => $this->url,
            'category_id' => $this->category_id,
        ]);

        $this->resetForm();
        $this->loadVideos();
        session()->flash('message', 'Video agregado exitosamente.');
    }

    /**
     * Prepara el formulario para editar un video existente.
     *
     * @param int $id Identificador del video a editar.
     * @return void
     */
    public function editVideo($id)
    {
        $video = Video::findOrFail($id);
        $this->video_id = $id;
        $this->title = $video->title;
        $this->url = $video->url;
        $this->category_id = $video->category_id;
        $this->isEditing = true;
    }

    /**
     * Actualiza el video con los datos del formulario.
     *
     * @return void
     */
    public function updateVideo()
    {
        $this->validate();

        $video = Video::findOrFail($this->video_id);
        $video->update([
            'title' => $this->title,
            'url' => $this->url,
            'category_id' => $this->category_id,
        ]);

        $this->resetForm();
        $this->loadVideos();
        session()->flash('message', 'Video actualizado exitosamente.');
    }

    /**
     * Elimina un video existente.
     *
     * @param int $id Identificador del video a eliminar.
     * @return void
     */
    public function deleteVideo($id)
    {
        Video::findOrFail($id)->delete();
        $this->loadVideos();
        session()->flash('message', 'Video eliminado exitosamente.');
    }

    /**
     * Resetea los campos del formulario.
     *
     * @return void
     */
    public function resetForm()
    {
        $this->title = '';
        $this->url = '';
        $this->category_id = '';
        $this->video_id = null;
        $this->isEditing = false;
    }

    /**
     * Renderiza la vista del componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.admin.video-manager');
    }
}
