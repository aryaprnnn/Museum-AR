<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\EducationalProgram;
use Illuminate\Http\Request;

class EducationalProgramPageController extends Controller
{
    public function index()
    {
        $programs = EducationalProgram::where('is_active', true)->latest()->get();
        return view('front.pages.programs.educational-program.index', compact('programs'));
    }

    public function show($slug)
    {
        $program = EducationalProgram::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedPrograms = EducationalProgram::where('is_active', true)
            ->where('id', '!=', $program->id)
            ->take(3)
            ->latest()
            ->get();
        
        return view('front.pages.programs.educational-program.show', compact('program', 'relatedPrograms'));
    }
}
