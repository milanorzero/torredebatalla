@extends('maindesign')

@section('title', 'Blog - Torre de Batalla')

@section('shop')
<div class="container mt-4">
    <h2 class="mb-4">Nuestro Blog</h2>

    <div class="row">
        @forelse($posts as $post)
            <div class="col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch">
                <div class="card h-100 shadow-sm w-100 d-flex flex-column">
                    @if($post->cover_image_url)
                        <img src="{{ $post->cover_image_url }}" class="card-img-top" alt="{{ $post->title }}" style="object-fit: cover; height: 180px; width: 100%;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        @if($post->excerpt)
                            <p class="card-text text-muted flex-grow-1">{{ $post->excerpt }}</p>
                        @endif
                        <a href="{{ route('blog.show', $post->slug, false) }}" class="btn btn-outline-primary btn-sm mt-auto">
                            Leer más
                        </a>
                    </div>
                    <div class="card-footer text-muted">
                        {{ $post->published_at?->format('d/m/Y') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">No hay posts publicados por el momento.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $posts->links() }}
    </div>
</div>
@endsection
