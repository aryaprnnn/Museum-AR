<?php
namespace App\Http\Controllers;

class InformationController extends Controller
{
    public function index(int $id = 1)
    {
        $items = $this->items();

        if (!isset($items[$id])) {
            $id = 1;
        }

        $currentItem = $items[$id];
        $otherItems = $items;
        unset($otherItems[$id]);

        return view('frontend.pages.collections.index', compact('currentItem', 'otherItems'));
    }

    private function items(): array
    {
        // Default model dari CDN untuk demo
        $defaultModel = 'https://modelviewer.dev/shared-assets/models/Astronaut.glb';
        $timanModel = 'https://modelviewer.dev/shared-assets/models/Astronaut.glb';

        return [
            1 => [
                'nama' => 'Timun Bersejarah', 
                'gambar' => 'img/timun.png', 
                'model' => $timanModel
            ],
            2 => [
                'nama' => 'Vas Kuno', 
                'gambar' => 'img/placeholder.png', 
                'model' => $defaultModel
            ],
            3 => [
                'nama' => 'Patung Batu', 
                'gambar' => 'img/placeholder.png', 
                'model' => $defaultModel
            ],
            4 => [
                'nama' => 'Topeng Klasik', 
                'gambar' => 'img/placeholder.png', 
                'model' => $defaultModel
            ],
            5 => [
                'nama' => 'Guci Emas', 
                'gambar' => 'img/placeholder.png', 
                'model' => $defaultModel
            ],
            6 => [
                'nama' => 'Pisau Batu', 
                'gambar' => 'img/placeholder.png', 
                'model' => $defaultModel
            ],
            7 => [
                'nama' => 'Placeholder', 
                'gambar' => 'img/placeholder.png', 
                'model' => $defaultModel
            ],
            8 => [
                'nama' => 'Placeholder', 
                'gambar' => 'img/placeholder.png', 
                'model' => $defaultModel
            ],
            9 => [
                'nama' => 'Placeholder', 
                'gambar' => 'img/placeholder.png', 
                'model' => $defaultModel
            ],
        ];
    }
}
