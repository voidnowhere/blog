<?php

namespace App\Http\Controllers;

use App\Models\Post;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Str;

class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::latest()->simplePaginate(6),
        ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store()
    {
        $attributes = $this->validatePost();

        $attributes['slug'] = Str::slug($attributes['title']);
        $attributes['thumbnail'] = $this->storeThumbnail(request()->file('thumbnail')->getRealPath());
        $attributes['user_id'] = auth()->id();

        $post = Post::create($attributes);

        return redirect(route('admin.posts.edit', ['post' => $post->slug]))->with('success', 'Post Published!');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(Post $post)
    {
        $attributes = $this->validatePost($post);

        $attributes['slug'] = Str::slug($attributes['title']);
        if ($attributes['thumbnail'] ?? false) {
            $this->destroyThumbnail($post->thumbnail);
            $attributes['thumbnail'] = $this->storeThumbnail(request()->file('thumbnail')->getRealPath());
        }

        $post->update($attributes);

        return redirect(route('admin.posts.edit', ['post' => $post->slug]))->with('success', 'Post Updated!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post Deleted!');
    }

    /**
     * @param Post|null $post
     * @return array
     */
    private function validatePost(?Post $post = null): array
    {
        $post ??= new Post();

        return request()->validate([
            'title' => ['required', Rule::unique('posts')->ignore($post->title, 'title')],
            'thumbnail' => $post->exists() ? 'image' : 'required|image',
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
    }

    /**
     * @param string $path
     * @return string
     */
    private function storeThumbnail(string $path): string
    {
        if (App::environment('production')) {
            return Cloudinary::upload($path, ['folder' => 'thumbnails'])->getSecurePath();
        }
        // local
        return request()->file('thumbnail')->store('thumbnails');
    }

    /**
     * @param string $thumbnail
     * @return void
     */
    private function destroyThumbnail(string $thumbnail): void
    {
        if (App::environment('production')) {
            $explodedThumbnailURL = explode('/', $thumbnail);
            $thumbnailNoExt = 'thumbnails/' . explode('.', end($explodedThumbnailURL))[0];
            Cloudinary::destroy($thumbnailNoExt);
        }
        // local
        Storage::delete($thumbnail);
    }
}
