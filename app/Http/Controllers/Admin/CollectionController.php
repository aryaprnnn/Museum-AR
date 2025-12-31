<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    public function index()
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $collections = Collection::latest()->get();
        return view('admin.collections.index', compact('collections'));
    }

    public function create()
    {
        if(!session('admin')) return redirect()->route('admin.login');
        return view('admin.collections.create');
    }

    public function store(Request $request)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category' => 'nullable',
            'era' => 'nullable',
            'origin' => 'nullable',
            'image' => 'nullable|image',
            'model_3d' => 'nullable|file'
        ]);

        $data['is_published'] = $request->has('is_published');
        $data['slug'] = $this->generateUniqueSlug($data['name'], 'collections');

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('collections', 'public');
        }
        if($request->hasFile('model_3d')){
            $data['model_3d'] = $request->file('model_3d')->store('models', 'public');
        }

        Collection::create($data);
        return redirect()->route('admin.collections.index')->with('success', 'Collection created successfully');
    }

    public function edit(Collection $collection)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        return view('admin.collections.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category' => 'nullable',
            'era' => 'nullable',
            'origin' => 'nullable',
            'image' => 'nullable|image',
            'model_3d' => 'nullable|file'
        ]);

        $data['is_published'] = $request->has('is_published');
        $data['slug'] = $this->generateUniqueSlug($data['name'], 'collections', $collection->id);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('collections', 'public');
        }
        if($request->hasFile('model_3d')){
            $data['model_3d'] = $request->file('model_3d')->store('models', 'public');
        }

        $collection->update($data);
        return redirect()->route('admin.collections.index')->with('success', 'Collection updated successfully');
    }

    public function destroy(Collection $collection)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $collection->delete();
        return redirect()->route('admin.collections.index')->with('success', 'Collection deleted successfully');
    }

    private function generateUniqueSlug($name, $table, $ignoreId = null)
    {
        $slug = Str::slug($name);
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
