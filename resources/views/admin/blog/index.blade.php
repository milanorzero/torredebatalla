@extends('admin.maindesign')

@section('page_title', 'Blog')

@section('content')
<div class="container-fluid">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Posts</h3>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Nuevo post
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Slug</th>
                            <th>Estado</th>
                            <th>Publicado</th>
                            <th style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td><code>{{ $post->slug }}</code></td>
                                <td>
                                    @if($post->is_published)
                                        <span class="badge badge-success">Publicado</span>
                                    @elseif($post->published_at)
                                        <span class="badge badge-warning">Programado</span>
                                    @else
                                        <span class="badge badge-secondary">Borrador</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $post->published_at ? $post->published_at->format('Y-m-d H:i') : '-' }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-sm btn-info">
                                        Editar
                                    </a>

                                    <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No hay posts aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
