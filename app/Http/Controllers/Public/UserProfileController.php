<?php

namespace App\Http\Controllers\Public;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserProfileController
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . session('auth_user')['id'],
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::find(session('auth_user')['id']);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        // Update session
        session(['auth_user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? $user->whatsapp ?? null,
            'role' => $user->role,
        ]]);

        return redirect('/user/settings')->with('success', 'Profil berhasil diperbarui');
    }
}
