<div>
    <h1>{{ $course->title }}</h1>
    <p>{{ $course->description }}</p>
    <p>Categoría: {{ $course->category->name }}</p>
    <p>Grupo de Edad: {{ $course->age_group }}</p>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if($isEnrolled)
        <a href="{{ route('user.courses') }}">Ir a Mis Cursos</a>
    @else
        <button wire:click="enroll">Inscribirse en el Curso</button>
    @endif
</div>
