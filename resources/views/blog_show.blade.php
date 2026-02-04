@extends('maindesign')

@section('title', $post->title . ' - Blog')

@section('shop')
<div class="container" style="max-width: 900px;">

    <div class="mb-3">
        <a href="{{ route('blog', [], false) }}">&larr; Volver al blog</a>
    </div>

    <div class="card shadow-sm w-100">
        @if($post->cover_image_url)
            <img src="{{ $post->cover_image_url }}" class="card-img-top img-fluid w-100" alt="{{ $post->title }}">
        @endif

        <div class="card-body p-4">
            <h2 class="mb-1">{{ $post->title }}</h2>
            <p class="text-muted mb-3">
                Publicado: {{ $post->published_at?->format('d/m/Y H:i') }}
            </p>

            <div style="white-space: pre-wrap;">{{ $post->body }}</div>
        </div>
    </div>

</div>
@endsection
