<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $konten = [
            'pengalaman_judul' => "Pengalaman Museum di genggaman anda!",
            'pengalaman_deskripsi' => "Ini adalah deskripsi yang ditarik dari array PHP.",
            'cara_judul_item' => "Timun Bersejarah",
            'cara_deskripsi' => "Deskripsi cara penggunaan ini juga diambil dari PHP.",
            'cta_judul' => "Sudah Siap untuk masuk ke Museum Virtualnya?"
        ];

        return view('homepage', compact('konten'));
    }
}
