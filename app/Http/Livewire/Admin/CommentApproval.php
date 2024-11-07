<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Comment;

class CommentApproval extends Component
{
    public $comments;

    /**
     * Método de ciclo de vida que se ejecuta al montar el componente.
     * Carga los comentarios pendientes de aprobación.
     *
     * @return void
     */
    public function mount()
    {
        $this->loadComments();
    }

    /**
     * Carga los comentarios que aún no han sido aprobados.
     *
     * @return void
     */
    public function loadComments()
    {
        $this->comments = Comment::with('user', 'video')
            ->where('approved', false)
            ->get();
    }

    /**
     * Aprueba un comentario específico.
     *
     * @param int $id Identificador del comentario a aprobar.
     * @return void
     */
    public function approveComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->approved = true;
        $comment->save();

        $this->loadComments();
        session()->flash('message', 'Comentario aprobado exitosamente.');
    }

    /**
     * Elimina un comentario específico.
     *
     * @param int $id Identificador del comentario a eliminar.
     * @return void
     */
    public function deleteComment($id)
    {
        Comment::findOrFail($id)->delete();
        $this->loadComments();
        session()->flash('message', 'Comentario eliminado exitosamente.');
    }

    /**
     * Renderiza la vista del componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.admin.comment-approval');
    }
}
