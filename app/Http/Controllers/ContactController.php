<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
	public function index()
	{
		return view('frontend.contact');
	}

	public function send(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|email|max:255',
			'message' => 'required|string|min:10',
		]);

		Contact::create($validated);

		return back()->with('status', 'Pesan berhasil dikirim. Kami akan segera menghubungi Anda.');
	}
}
