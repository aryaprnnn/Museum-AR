<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationalProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EducationalProgramController extends Controller
{
    public function index()
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $programs = EducationalProgram::latest()->get();
        return view('admin.educational-program.index', compact('programs'));
    }

    public function create()
    {
        if(!session('admin')) return redirect()->route('admin.login');
        return view('admin.educational-program.create');
    }

    public function store(Request $request)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required|in:workshop,seminar',
            'facilitator' => 'nullable',
            'schedule' => 'nullable',
            'location' => 'nullable',
            'target_audience' => 'nullable',
            'benefits' => 'nullable',
            'image' => 'nullable|image'
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['slug'] = $this->generateUniqueSlug($data['title'], 'educational_programs');

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('educational', 'public');
        }

        EducationalProgram::create($data);
        return redirect()->route('admin.educational.index')->with('success', 'Educational Program created successfully');
    }

    public function edit(EducationalProgram $educationalProgram)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        return view('admin.educational-program.edit', compact('educationalProgram'));
    }

    public function update(Request $request, EducationalProgram $educationalProgram)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required|in:workshop,seminar',
            'facilitator' => 'nullable',
            'schedule' => 'nullable',
            'location' => 'nullable',
            'target_audience' => 'nullable',
            'benefits' => 'nullable',
            'image' => 'nullable|image'
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['slug'] = $this->generateUniqueSlug($data['title'], 'educational_programs', $educationalProgram->id);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('educational', 'public');
        }

        $educationalProgram->update($data);
        return redirect()->route('admin.educational.index')->with('success', 'Educational Program updated successfully');
    }

    public function destroy(EducationalProgram $educationalProgram)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $educationalProgram->delete();
        return redirect()->route('admin.educational.index')->with('success', 'Educational Program deleted successfully');
    }

    private function generateUniqueSlug($title, $table, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (DB::table($table)->where('slug', $slug)->when($ignoreId, function($q) use ($ignoreId) {
            return $q->where('id', '!=', $ignoreId);
        })->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
