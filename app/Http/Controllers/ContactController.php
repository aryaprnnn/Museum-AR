<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
	public function index()
	{
		return view('contact');
	}

	public function send(Request $request)
	{
		$validated = $request->validate([
			'name' => 'sometimes|string|max:255',
			'email' => 'sometimes|email|max:255',
			'message' => 'sometimes|string',
		]);

		// In a real app you might mail or persist; here we just acknowledge the request.
		return back()->with('status', 'Pesan berhasil dikirim.');
	}
}
