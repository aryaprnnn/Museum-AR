<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArtClass;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ArtClassController extends Controller
{
    public function index()
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $artclasses = ArtClass::latest()->get();
        return view('admin.artclasses.index', compact('artclasses'));
    }

    public function create()
    {
        if(!session('admin')) return redirect()->route('admin.login');
        return view('admin.artclasses.create');
    }

    public function store(Request $request)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'level' => 'required|in:pemula,menengah,lanjutan',
            'instructor' => 'nullable',
            'schedule' => 'nullable',
            'quota' => 'required|integer',
            'available' => 'required|integer',
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['slug'] = $this->generateUniqueSlug($data['title'], 'art_classes');

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('artclasses', 'public');
        }

        ArtClass::create($data);
        return redirect()->route('admin.artclasses.index')->with('success', 'Art Class created successfully');
    }

    public function edit(ArtClass $artClass)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        return view('admin.artclasses.edit', compact('artClass'));
    }

    public function update(Request $request, ArtClass $artClass)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'level' => 'required|in:pemula,menengah,lanjutan',
            'instructor' => 'nullable',
            'schedule' => 'nullable',
            'quota' => 'required|integer',
            'available' => 'required|integer',
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['slug'] = $this->generateUniqueSlug($data['title'], 'art_classes', $artClass->id);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('artclasses', 'public');
        }

        $artClass->update($data);
        return redirect()->route('admin.artclasses.index')->with('success', 'Art Class updated successfully');
    }

    public function destroy(ArtClass $artClass)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $artClass->delete();
        return redirect()->route('admin.artclasses.index')->with('success', 'Art Class deleted successfully');
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
