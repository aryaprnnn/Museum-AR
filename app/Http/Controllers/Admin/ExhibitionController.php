<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{
    public function index()
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $exhibitions = Exhibition::latest()->get();
        return view('admin.exhibitions.index', compact('exhibitions'));
    }

    public function create()
    {
        if(!session('admin')) return redirect()->route('admin.login');
        return view('admin.exhibitions.create');
    }

    public function store(Request $request)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:exhibitions',
            'description' => 'required',
            'curator' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'time' => 'nullable',
            'location' => 'nullable',
            'status' => 'required|in:ongoing,upcoming,past',
            'image' => 'nullable|image'
        ]);

        $data['is_active'] = $request->has('is_active');

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('exhibitions', 'public');
        }

        Exhibition::create($data);
        return redirect()->route('admin.exhibitions.index')->with('success', 'Exhibition created successfully');
    }

    public function edit(Exhibition $exhibition)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        return view('admin.exhibitions.edit', compact('exhibition'));
    }

    public function update(Request $request, Exhibition $exhibition)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:exhibitions,slug,'.$exhibition->id,
            'description' => 'required',
            'curator' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'time' => 'nullable',
            'location' => 'nullable',
            'status' => 'required|in:ongoing,upcoming,past',
            'image' => 'nullable|image'
        ]);

        $data['is_active'] = $request->has('is_active');

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('exhibitions', 'public');
        }

        $exhibition->update($data);
        return redirect()->route('admin.exhibitions.index')->with('success', 'Exhibition updated successfully');
    }

    public function destroy(Exhibition $exhibition)
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $exhibition->delete();
        return redirect()->route('admin.exhibitions.index')->with('success', 'Exhibition deleted successfully');
    }
}
