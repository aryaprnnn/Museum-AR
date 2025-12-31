<?php

namespace App\Http\Controllers\Public;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class UserBookingController
{
    public function dashboard()
    {
        $sessionUser = session('auth_user');
        if (!$sessionUser || !isset($sessionUser['id'])) {
            return redirect()->route('login');
        }
        $user = User::find($sessionUser['id']);
        if (!$user) {
            return redirect()->route('login');
        }
        $bookings = Booking::where('user_id', $user->id)
            ->with('bookable')
            ->orderByDesc('created_at')
            ->get();
        $artclassBookings = $bookings->where('bookable_type', 'App\\Models\\ArtClass');
        $educlassBookings = $bookings->where('bookable_type', 'App\\Models\\EducationalProgram');
        return view('front.pages.user.dashboard', compact('user', 'artclassBookings', 'educlassBookings'));
    }

    public function bookings()
    {
        $sessionUser = session('auth_user');
        if (!$sessionUser || !isset($sessionUser['id'])) {
            return redirect()->route('login');
        }
        $user = User::find($sessionUser['id']);
        if (!$user) {
            return redirect()->route('login');
        }
        $bookings = Booking::where('user_id', $user->id)
            ->with('bookable')
            ->orderByDesc('created_at')
            ->get();
        $artclassBookings = $bookings->where('bookable_type', 'App\\Models\\ArtClass');
        $educlassBookings = $bookings->where('bookable_type', 'App\\Models\\EducationalProgram');
        return view('front.pages.user.bookings', compact('user', 'artclassBookings', 'educlassBookings'));
    }
}
