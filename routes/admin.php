<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\ArtClassController;
use App\Http\Controllers\Admin\EducationalProgramController;
use App\Http\Controllers\Admin\ExhibitionController;
use App\Http\Controllers\Admin\AboutContentController;
use App\Http\Controllers\Admin\UserController;

// Dashboard Chart Data
Route::get('/admin/dashboard/bookingdata', function() {
    $year = request('year', date('Y'));
    $labels = [];
    $tiket = [];
    $artclass = [];
    $educlass = [];
    for ($m = 1; $m <= 12; $m++) {
        $labels[] = DateTime::createFromFormat('!m', $m)->format('F');
        $tiket[] = \App\Models\Ticket::whereYear('created_at', $year)->whereMonth('created_at', $m)->count();
        $artclass[] = \App\Models\Booking::where('bookable_type', 'App\\Models\\ArtClass')->whereYear('created_at', $year)->whereMonth('created_at', $m)->count();
        $educlass[] = \App\Models\Booking::where('bookable_type', 'App\\Models\\EducationalProgram')->whereYear('created_at', $year)->whereMonth('created_at', $m)->count();
    }
    return response()->json([
        'labels' => $labels,
        'tiket' => $tiket,
        'artclass' => $artclass,
        'educlass' => $educlass,
    ]);
})->name('admin.dashboard.bookingdata');

// Admin login
Route::get('/admin/login', function(){ 
    if(session('admin')) return redirect()->route('admin.dashboard');
    return view('admin.login'); 
})->name('admin.login');

Route::post('/admin/login', function(){
    $user = \App\Models\User::where('email', request('email'))->first();
    if($user && Hash::check(request('password'), $user->password) && $user->isAdmin()){
        session(['admin' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email]]);
        return redirect()->route('admin.dashboard');
    }
    return back()->with('error', 'Invalid credentials or not an admin');
})->name('admin.login.submit');

Route::post('/admin/logout', function(){
    session()->forget('admin');
    return redirect()->route('admin.login');
})->name('admin.logout');

// Dashboard
Route::get('/admin/dashboard', function(){
    if(!session('admin')) return redirect()->route('admin.login');
    return view('admin.dashboard');
})->name('admin.dashboard');

// Blogs
Route::get('/admin/blogs', [BlogController::class, 'index'])->name('admin.blogs.index');
Route::get('/admin/blogs/create', [BlogController::class, 'create'])->name('admin.blogs.create');
Route::post('/admin/blogs', [BlogController::class, 'store'])->name('admin.blogs.store');
Route::get('/admin/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('admin.blogs.edit');
Route::put('/admin/blogs/{blog}', [BlogController::class, 'update'])->name('admin.blogs.update');
Route::delete('/admin/blogs/{blog}', [BlogController::class, 'destroy'])->name('admin.blogs.destroy');

// Collections
Route::get('/admin/collections', [CollectionController::class, 'index'])->name('admin.collections.index');
Route::get('/admin/collections/create', [CollectionController::class, 'create'])->name('admin.collections.create');
Route::post('/admin/collections', [CollectionController::class, 'store'])->name('admin.collections.store');
Route::get('/admin/collections/{collection}/edit', [CollectionController::class, 'edit'])->name('admin.collections.edit');
Route::put('/admin/collections/{collection}', [CollectionController::class, 'update'])->name('admin.collections.update');
Route::delete('/admin/collections/{collection}', [CollectionController::class, 'destroy'])->name('admin.collections.destroy');

// Art Classes
Route::get('/admin/artclasses', [ArtClassController::class, 'index'])->name('admin.artclasses.index');
Route::get('/admin/artclasses/create', [ArtClassController::class, 'create'])->name('admin.artclasses.create');
Route::post('/admin/artclasses', [ArtClassController::class, 'store'])->name('admin.artclasses.store');
Route::get('/admin/artclasses/{artClass}/edit', [ArtClassController::class, 'edit'])->name('admin.artclasses.edit');
Route::put('/admin/artclasses/{artClass}', [ArtClassController::class, 'update'])->name('admin.artclasses.update');
Route::delete('/admin/artclasses/{artClass}', [ArtClassController::class, 'destroy'])->name('admin.artclasses.destroy');

// Educational Programs
Route::get('/admin/educational', [EducationalProgramController::class, 'index'])->name('admin.educational.index');
Route::get('/admin/educational/create', [EducationalProgramController::class, 'create'])->name('admin.educational.create');
Route::post('/admin/educational', [EducationalProgramController::class, 'store'])->name('admin.educational.store');
Route::get('/admin/educational/{educationalProgram}/edit', [EducationalProgramController::class, 'edit'])->name('admin.educational.edit');
Route::put('/admin/educational/{educationalProgram}', [EducationalProgramController::class, 'update'])->name('admin.educational.update');
Route::delete('/admin/educational/{educationalProgram}', [EducationalProgramController::class, 'destroy'])->name('admin.educational.destroy');

// Exhibitions
Route::get('/admin/exhibitions', [ExhibitionController::class, 'index'])->name('admin.exhibitions.index');
Route::get('/admin/exhibitions/create', [ExhibitionController::class, 'create'])->name('admin.exhibitions.create');
Route::post('/admin/exhibitions', [ExhibitionController::class, 'store'])->name('admin.exhibitions.store');
Route::get('/admin/exhibitions/{exhibition}/edit', [ExhibitionController::class, 'edit'])->name('admin.exhibitions.edit');
Route::put('/admin/exhibitions/{exhibition}', [ExhibitionController::class, 'update'])->name('admin.exhibitions.update');
Route::delete('/admin/exhibitions/{exhibition}', [ExhibitionController::class, 'destroy'])->name('admin.exhibitions.destroy');

// About Contents
Route::get('/admin/about-contents', [AboutContentController::class, 'index'])->name('admin.about-contents.index');
Route::get('/admin/about-contents/create', [AboutContentController::class, 'create'])->name('admin.about-contents.create');
Route::post('/admin/about-contents', [AboutContentController::class, 'store'])->name('admin.about-contents.store');
Route::get('/admin/about-contents/{aboutContent}/edit', [AboutContentController::class, 'edit'])->name('admin.about-contents.edit');
Route::put('/admin/about-contents/{aboutContent}', [AboutContentController::class, 'update'])->name('admin.about-contents.update');
Route::delete('/admin/about-contents/{aboutContent}', [AboutContentController::class, 'destroy'])->name('admin.about-contents.destroy');

// Users
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');

// Tickets
Route::get('/admin/tickets', [\App\Http\Controllers\Admin\TicketController::class, 'index'])->name('admin.tickets.index');
