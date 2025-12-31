<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Collection;

class InformationController extends Controller
{
    public function index(int $id = 1)
    {
        $currentItem = Collection::where('is_published', true)->findOrFail($id);

        $otherItems = Collection::where('is_published', true)
            ->where('id', '!=', $id)
            ->latest()
            ->take(6)
            ->get();

        return view('front.pages.collections.show', compact('currentItem', 'otherItems'));
    }
}
