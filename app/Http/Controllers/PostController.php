<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Str;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' =>
                Post::latest()
                    ->filter(request()->only('search', 'category', 'author'))
                    ->simplePaginate(3)
                    ->withQueryString(),
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
