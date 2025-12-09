<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\InformationController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/blogs', [BlogsController::class, 'index'])->name('blogs');
Route::get('/blogs/{id}', [BlogsController::class, 'show'])->name('blogs.show');

Route::get('/information/{id?}', [InformationController::class, 'index'])->name('information');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
