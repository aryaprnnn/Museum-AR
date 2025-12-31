$user = \App\Models\User::first();
$artClass = \App\Models\ArtClass::first();

if ($user && $artClass) {
    $booking = \App\Models\Booking::create([
        'user_id' => $user->id,
        'bookable_type' => \App\Models\ArtClass::class,
        'bookable_id' => $artClass->id,
        'booking_code' => 'TEST-' . strtoupper(substr(md5(time()), 0, 8)),
        'participant_name' => $user->name,
        'institution' => 'Testing Institution',
        'experience_level' => 'beginner',
        'payment_method' => 'midtrans',
        'payment_status' => 'paid',
        'status' => 'confirmed',
        'event_date' => now()->addDay(),
        'reminder_enabled' => true
    ]);
    
    echo "✓ Booking created: " . $booking->booking_code . "\n";
    echo "✓ Event date: " . $booking->event_date . "\n";
    echo "✓ User email: " . $user->email . "\n";
} else {
    echo "✗ Error: User atau ArtClass tidak ditemukan\n";
}
