<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request)
    {
        $locale = $request->input('locale', 'en');
        
        // Validate locale
        if (!in_array($locale, ['en', 'id'])) {
            $locale = 'en';
        }
        
        // Set application locale
        App::setLocale($locale);
        
        // Store in session
        Session::put('locale', $locale);
        
        // Redirect back
        return redirect()->back();
    }
}
