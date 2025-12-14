<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $items = [
            1 => ['nama' => 'Timun Bersejarah', 'gambar' => 'img/timun.png'],
            2 => ['nama' => 'Vas Kuno', 'gambar' => 'img/placeholder.png'],
            3 => ['nama' => 'Patung Batu', 'gambar' => 'img/placeholder.png'],
            4 => ['nama' => 'Topeng Klasik', 'gambar' => 'img/placeholder.png'],
            5 => ['nama' => 'Guci Emas', 'gambar' => 'img/placeholder.png'],
            6 => ['nama' => 'Pisau Batu', 'gambar' => 'img/placeholder.png'],
            7 => ['nama' => 'Placeholder', 'gambar' => 'img/placeholder.png'],
            8 => ['nama' => 'Placeholder', 'gambar' => 'img/placeholder.png'],
            9 => ['nama' => 'Placeholder', 'gambar' => 'img/placeholder.png'],
        ];

        return view('frontend.pages.collections.show', compact('items'));
    }
}
