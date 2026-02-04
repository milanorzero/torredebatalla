@extends('admin.maindesign')

@section('page_title', 'Editar post')

@section('content')
<div class="container-fluid">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card w-100">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.blog.update', $post) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Título</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" class="form-control" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" class="form-control">
                    @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Extracto (opcional)</label>
                    <input type="text" name="excerpt" value="{{ old('excerpt', $post->excerpt) }}" class="form-control" maxlength="255">
                    @error('excerpt') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Contenido</label>
                    <textarea name="body" rows="10" class="form-control" required>{{ old('body', $post->body) }}</textarea>
                    @error('body') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Imagen de portada (opcional)</label>

                    @if($post->cover_image_url)
                        <div class="mb-2">
                            <img src="{{ $post->cover_image_url }}" alt="Portada" style="max-width: 260px;" class="img-thumbnail">
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="remove_cover" value="1" id="remove_cover">
                            <label class="form-check-label" for="remove_cover">Quitar portada</label>
                        </div>
                    @endif

                    <input type="file" name="cover_image" class="form-control">
                    @error('cover_image') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Fecha de publicación (opcional)</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}" class="form-control">
                    @error('published_at') <small class="text-danger">{{ $message }}</small> @enderror
                    <small class="text-muted">Vacío = borrador. Fecha futura = programado.</small>
                </div>

                <div class="d-flex">
                    <button class="btn btn-primary">Guardar</button>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-link">Volver</a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
