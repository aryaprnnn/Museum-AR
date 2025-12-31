<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutContentController extends Controller
{
    public function index()
    {
        // Hanya tampilkan konten yang boleh dikelola admin (bukan hero, mission, vision)
        $contents = AboutContent::withInactive()
            ->whereNotIn('section', ['hero', 'mission', 'vision'])
            ->orderBy('section')
            ->orderBy('order')
            ->get();
        return view('admin.about-contents.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.about-contents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'content' => 'required|string',
            'content_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['section', 'title', 'title_en', 'content', 'content_en', 'order', 'is_active']);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('about-contents', 'public');
        }

        AboutContent::create($data);

        return redirect()->route('admin.about-contents.index')
            ->with('success', 'Content created successfully!');
    }

    public function edit(AboutContent $aboutContent)
    {
        return view('admin.about-contents.edit', compact('aboutContent'));
    }

    public function update(Request $request, AboutContent $aboutContent)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'content' => 'required|string',
            'content_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['section', 'title', 'title_en', 'content', 'content_en', 'order', 'is_active']);
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($aboutContent->image) {
                Storage::disk('public')->delete($aboutContent->image);
            }
            $data['image'] = $request->file('image')->store('about-contents', 'public');
        }

        $aboutContent->update($data);

        return redirect()->route('admin.about-contents.index')
            ->with('success', 'Content updated successfully!');
    }

    public function destroy(AboutContent $aboutContent)
    {
        if ($aboutContent->image) {
            Storage::disk('public')->delete($aboutContent->image);
        }
        
        $aboutContent->delete();

        return redirect()->route('admin.about-contents.index')
            ->with('success', 'Content deleted successfully!');
    }
}
