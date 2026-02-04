<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::query()->orderByDesc('created_at')->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\-\s_]+$/'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'published_at' => ['nullable', 'date'],
        ]);

        $post = new BlogPost();
        $post->title = $validated['title'];
        $post->slug = $validated['slug'] ?? '';
        $post->excerpt = $validated['excerpt'] ?? null;
        $post->body = $validated['body'];
        $post->published_at = $validated['published_at'] ?? null;

        if ($request->hasFile('cover_image')) {
            if (!is_dir(public_path('blog'))) {
                mkdir(public_path('blog'), 0775, true);
            }

            $image = $request->file('cover_image');
            $name = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('blog'), $name);
            $post->cover_image = $name;
        }

        $post->save();

        return redirect()->route('admin.blog.index')->with('success', 'Post creado.');
    }

    public function edit(BlogPost $post)
    {
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\-\s_]+$/'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'published_at' => ['nullable', 'date'],
            'remove_cover' => ['nullable', 'boolean'],
        ]);

        $post->title = $validated['title'];
        $post->slug = $validated['slug'] ?? $post->slug;
        $post->excerpt = $validated['excerpt'] ?? null;
        $post->body = $validated['body'];
        $post->published_at = $validated['published_at'] ?? null;

        if ($request->boolean('remove_cover') && $post->cover_image) {
            $old = public_path('blog/' . $post->cover_image);
            if (file_exists($old)) {
                unlink($old);
            }
            $post->cover_image = null;
        }

        if ($request->hasFile('cover_image')) {
            if (!is_dir(public_path('blog'))) {
                mkdir(public_path('blog'), 0775, true);
            }

            if ($post->cover_image) {
                $old = public_path('blog/' . $post->cover_image);
                if (file_exists($old)) {
                    unlink($old);
                }
            }

            $image = $request->file('cover_image');
            $name = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('blog'), $name);
            $post->cover_image = $name;
        }

        $post->save();

        return redirect()->route('admin.blog.index')->with('success', 'Post actualizado.');
    }

    public function destroy(BlogPost $post)
    {
        if ($post->cover_image) {
            $old = public_path('blog/' . $post->cover_image);
            if (file_exists($old)) {
                unlink($old);
            }
        }

        $post->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Post eliminado.');
    }
}
