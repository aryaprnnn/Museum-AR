<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ArtClass;
use Illuminate\Http\Request;

class ArtClassPageController extends Controller
{
    public function index()
    {
        $classes = ArtClass::where('is_active', true)->latest()->get();
        return view('front.pages.programs.artclass.index', compact('classes'));
    }

    public function show($slug)
    {
        $artClass = ArtClass::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedClasses = ArtClass::where('is_active', true)
            ->where('id', '!=', $artClass->id)
            ->take(3)
            ->latest()
            ->get();
        
        return view('front.pages.programs.artclass.show', compact('artClass', 'relatedClasses'));
    }
}
