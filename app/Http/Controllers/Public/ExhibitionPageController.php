<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionPageController extends Controller
{
    public function index()
    {
        $exhibitions = Exhibition::where('is_active', true)->latest()->get();
        return view('front.pages.programs.exhibitions.index', compact('exhibitions'));
    }

    public function show($slug)
    {
        $exhibition = Exhibition::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedExhibitions = Exhibition::where('is_active', true)
            ->where('id', '!=', $exhibition->id)
            ->take(3)
            ->latest()
            ->get();
        
        return view('front.pages.programs.exhibitions.show', compact('exhibition', 'relatedExhibitions'));
    }
}
