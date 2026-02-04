@extends('admin.maindesign')

@section('page_title', 'Nuevo post')

@section('content')
<div class="container-fluid">

    <div class="card w-100">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Título</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Slug (opcional)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="form-control" placeholder="se-genera-solo-si-lo-dejas-vacio">
                    @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Extracto (opcional)</label>
                    <input type="text" name="excerpt" value="{{ old('excerpt') }}" class="form-control" maxlength="255">
                    @error('excerpt') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Contenido</label>
                    <textarea name="body" rows="10" class="form-control" required>{{ old('body') }}</textarea>
                    @error('body') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Imagen de portada (opcional)</label>
                    <input type="file" name="cover_image" class="form-control">
                    @error('cover_image') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Fecha de publicación (opcional)</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="form-control">
                    @error('published_at') <small class="text-danger">{{ $message }}</small> @enderror
                    <small class="text-muted">Si lo dejas vacío, queda como borrador.</small>
                </div>

                <div class="d-flex">
                    <button class="btn btn-primary">Crear</button>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-link">Cancelar</a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
