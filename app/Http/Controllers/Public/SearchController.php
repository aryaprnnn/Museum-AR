<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Collection;
use App\Models\ArtClass;
use App\Models\EducationalProgram;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q', '');
        
        // If no search query, show all collections with pagination
        if (empty($query)) {
            $items = Collection::query()
                ->where('is_published', true)
                ->latest()
                ->paginate(12);
            
            return view('front.pages.collections.index', compact('items'));
        }

        // Search across multiple models with pagination
        $searchTerm = '%' . $query . '%';

        $blogs = Blog::where('is_published', true)
            ->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('content', 'LIKE', $searchTerm)
                  ->orWhere('excerpt', 'LIKE', $searchTerm);
            })
            ->latest()
            ->paginate(12, ['*'], 'blogs_page');

        $collections = Collection::where('is_published', true)
            ->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                  ->orWhere('description', 'LIKE', $searchTerm)
                  ->orWhere('category', 'LIKE', $searchTerm);
            })
            ->latest()
            ->paginate(12, ['*'], 'collections_page');

        $artClasses = ArtClass::where('is_active', true)
            ->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('description', 'LIKE', $searchTerm);
            })
            ->latest()
            ->paginate(12, ['*'], 'artclasses_page');

        $programs = EducationalProgram::where('is_active', true)
            ->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('description', 'LIKE', $searchTerm);
            })
            ->latest()
            ->paginate(12, ['*'], 'programs_page');

        return view('front.pages.search-results', compact('blogs', 'collections', 'artClasses', 'programs', 'query'));
    }
}
