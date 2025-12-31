<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Collection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured blogs (latest 3, published)
        $blogs = Blog::where('is_published', true)
            ->latest()
            ->take(3)
            ->get()
            ->map(function($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'excerpt' => $blog->excerpt,
                    'image' => $blog->image,
                    'date' => $blog->created_at->format('d M Y'),
                ];
            })
            ->toArray();

        // Get featured collections (latest 12, published for smooth looping)
        $collections = Collection::where('is_published', true)
            ->latest()
            ->take(12)
            ->get()
            ->map(function($collection) {
                return [
                    'id' => $collection->id,
                    'nama' => $collection->name,
                    'gambar' => $collection->image,
                ];
            })
            ->toArray();

        $konten = [
            'pengalaman_judul' => "Pengalaman Museum di genggaman anda!",
            'pengalaman_deskripsi' => "Museum Virtual kami menghadirkan koleksi bersejarah dengan teknologi 3D terkini. Akses ribuan artefak dari mana saja, kapan saja.",
            'cara_judul_item' => "Timun Bersejarah",
            'cara_deskripsi' => "Jelajahi koleksi museum kami dengan teknologi augmented reality yang inovatif dan menarik.",
            'cta_judul' => "Sudah Siap untuk masuk ke Museum Virtualnya?"
        ];

        return view('front.home', compact('konten', 'blogs', 'collections'));
    }
}
