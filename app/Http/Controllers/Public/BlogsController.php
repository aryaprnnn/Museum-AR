<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'semua');

        $query = Blog::query()->where('is_published', true);

        if ($category !== 'semua') {
            $query->where('category', $category);
        }

        $posts = $query->latest()->paginate(12);

        return view('front.pages.blogs.index', [
            'posts' => $posts,
            'selectedCategory' => $category,
        ]);
    }

    public function show(int $id)
    {
        $post = Blog::where('is_published', true)->findOrFail($id);

        return view('front.pages.blogs.show', [
            'post' => $post,
            'id' => $id,
        ]);
    }
}
