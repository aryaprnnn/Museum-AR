<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;

class AboutController extends Controller
{
	public function index()
	{
		// Get about contents grouped by section, ordered
		$aboutContents = AboutContent::where('is_active', true)
			->orderBy('order')
			->get()
			->groupBy('section');

		return view('front.pages.about', compact('aboutContents'));
	}
}
