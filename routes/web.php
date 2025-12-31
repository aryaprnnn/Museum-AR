
<?php


use App\Http\Controllers\ExhibitionPaymentController;
use App\Http\Controllers\ArtClassPaymentController;
use App\Http\Controllers\EduClassPaymentController;

// Midtrans Snap Token untuk Exhibition
Route::post('/exhibitions/{id}/pay-token', [ExhibitionPaymentController::class, 'getSnapToken'])->name('exhibitions.pay.token');
// Midtrans Snap Token untuk ArtClass
Route::post('/artclass/{id}/pay-token', [ArtClassPaymentController::class, 'getSnapToken'])->name('artclass.pay.token');

// Midtrans notification handler
Route::post('/midtrans/notification', [ExhibitionPaymentController::class, 'handleNotification'])->name('midtrans.notification');
Route::post('/midtrans/artclass/notification', [ArtClassPaymentController::class, 'handleNotification'])->name('midtrans.artclass.notification');

// Midtrans redirect handlers for ArtClass
Route::get('/midtrans/artclass/finish', [ArtClassPaymentController::class, 'finish'])->name('midtrans.artclass.finish');
Route::get('/midtrans/artclass/unfinish', [ArtClassPaymentController::class, 'unfinish'])->name('midtrans.artclass.unfinish');
Route::get('/midtrans/artclass/error', [ArtClassPaymentController::class, 'error'])->name('midtrans.artclass.error');

// EduClass Payment
Route::post('/educlass/{id}/pay', [EduClassPaymentController::class, 'getSnapToken'])->name('educlass.pay');
Route::post('/midtrans/educlass/notification', [EduClassPaymentController::class, 'handleNotification']);
Route::get('/midtrans/educlass/finish', [EduClassPaymentController::class, 'finish']);
Route::get('/midtrans/educlass/unfinish', [EduClassPaymentController::class, 'unfinish']);
Route::get('/midtrans/educlass/error', [EduClassPaymentController::class, 'error']);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SearchController;
use App\Http\Controllers\Public\BlogsController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\InformationController;
use App\Http\Controllers\Public\ArtClassPageController;
use App\Http\Controllers\Public\EducationalProgramPageController;
use App\Http\Controllers\Public\ExhibitionPageController;
use App\Http\Controllers\Public\UserProfileController;
use App\Models\User;
use App\Models\ArtClass;
use App\Models\EducationalProgram;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search');

// Collections (alias of search)
Route::get('/collections', [SearchController::class, 'index'])->name('collections');
Route::get('/collections/{id}', [InformationController::class, 'index'])->name('collections.show');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/blogs', [BlogsController::class, 'index'])->name('blogs');
Route::get('/blogs/{id}', [BlogsController::class, 'show'])->name('blogs.show');

// Program pages
Route::get('/artclass', [ArtClassPageController::class, 'index'])->name('artclass');
Route::get('/educational-program', [EducationalProgramPageController::class, 'index'])->name('educational-program');
Route::get('/exhibitions', [ExhibitionPageController::class, 'index'])->name('exhibitions');

// --- Booking / Join forms (require login) - MUST be BEFORE detail routes ---
Route::get('/artclass/book', function(Request $request){
	if(!session('auth_user')){ return redirect()->route('login'); }
	$artClasses = ArtClass::where('is_active', true)->get();
	$selectedClassId = $request->query('class_id');
	return view('front.pages.programs.artclass.book', compact('artClasses', 'selectedClassId'));
})->name('artclass.book');

Route::post('/artclass/book/submit', function(Request $request){
    if(!session('auth_user')){ return redirect()->route('login'); }
    
    $validated = $request->validate([
        'artclass_id' => 'required|exists:art_classes,id',
        'participant_name' => 'required|string|max:255',
        'experience_level' => 'nullable|string',
        'payment_method' => 'required|in:midtrans,manual',
    ]);

    $user = User::find(session('auth_user')['id']);
    $artClass = ArtClass::find($validated['artclass_id']);

    $booking = Booking::create([
        'user_id' => $user->id,
        'bookable_type' => ArtClass::class,
        'bookable_id' => $artClass->id,
        'booking_code' => 'ART-' . strtoupper(Str::random(8)),
        'participant_name' => $validated['participant_name'],
        'experience_level' => $validated['experience_level'],
        'payment_method' => $validated['payment_method'],
        'payment_status' => 'pending',
        'status' => 'confirmed',
    ]);

    return redirect()->route('user.bookings')->with('success', 'Booking berhasil dibuat! Kode: ' . $booking->booking_code);
})->name('artclass.book.submit');

Route::get('/educational-program/join', function(Request $request){
    if(!session('auth_user')){ return redirect()->route('login'); }
    $programs = EducationalProgram::where('is_active', true)->get();
    $selectedProgramId = $request->query('program_id');
    return view('front.pages.programs.educational-program.join', compact('programs', 'selectedProgramId'));
})->name('educational-program.join');

Route::post('/educational-program/join/submit', function(Request $request){
    if(!session('auth_user')){ return redirect()->route('login'); }
    
    $validated = $request->validate([
        'program_id' => 'required|exists:educational_programs,id',
        'participant_name' => 'required|string|max:255',
        'institution' => 'nullable|string|max:255',
        'payment_method' => 'required|in:midtrans,manual',
    ]);

    $user = User::find(session('auth_user')['id']);
    $program = EducationalProgram::find($validated['program_id']);

    $booking = Booking::create([
        'user_id' => $user->id,
        'bookable_type' => EducationalProgram::class,
        'bookable_id' => $program->id,
        'booking_code' => 'EDU-' . strtoupper(Str::random(8)),
        'participant_name' => $validated['participant_name'],
        'institution' => $validated['institution'],
        'payment_method' => $validated['payment_method'],
        'payment_status' => 'pending',
        'status' => 'confirmed',
    ]);

    return redirect()->route('user.bookings')->with('success', 'Pendaftaran berhasil! Kode: ' . $booking->booking_code);
})->name('educational-program.join.submit');

// Program detail pages - MUST be AFTER booking routes
Route::get('/artclass/{slug}', [ArtClassPageController::class, 'show'])->name('artclass.show');
Route::get('/educational-program/{slug}', [EducationalProgramPageController::class, 'show'])->name('educational-program.show');
Route::get('/exhibitions/{slug}', [ExhibitionPageController::class, 'show'])->name('exhibitions.show');

Route::get('/information/{id?}', [InformationController::class, 'index'])->name('information');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// --- Simple session-based auth (demo) ---
Route::view('/login', 'front.pages.auth.login')->name('login');
Route::view('/register', 'front.pages.auth.register')->name('register');
Route::post('/auth/login', function(Request $request){
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $validated['email'])->first();

    if(!$user || !Hash::check($validated['password'], $user->password)){
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    session(['auth_user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'whatsapp' => $user->whatsapp,
        'role' => $user->role,
    ]]);

    return redirect()->route('home');
})->name('auth.login');
Route::post('/auth/register', function(Request $request){
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'whatsapp' => 'nullable|string|max:30',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'whatsapp' => $validated['whatsapp'] ?? null,
        'role' => 'user',
    ]);

    session(['auth_user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'whatsapp' => $user->whatsapp,
        'role' => $user->role,
    ]]);

    return redirect()->route('home');
})->name('auth.register');
Route::post('/logout', function(){
    session()->forget('auth_user');
	return redirect()->route('home');
})->name('logout');

// --- User pages ---
use App\Http\Controllers\Public\UserBookingController;
Route::get('/user/dashboard', [UserBookingController::class, 'dashboard'])->name('user.dashboard');
Route::get('/user/bookings', [UserBookingController::class, 'bookings'])->name('user.bookings');
Route::view('/user/settings', 'front.pages.user.settings')->name('user.settings');
Route::post('/user/settings/update', [UserProfileController::class, 'updateProfile'])->name('user.settings.update');
Route::get('/user/booking/{code}', function($code){
    return view('front.pages.user.booking-detail', compact('code'));
})->name('user.booking.detail');
Route::get('/user/educational/{code}', function($code){
    return view('front.pages.user.educational-detail', compact('code'));
})->name('user.educational.detail');

// --- Booking / Join forms (require login) ---
Route::get('/artclass/book', function(Request $request){
	if(!session('auth_user')){ return redirect()->route('login'); }
	$artClasses = ArtClass::where('is_active', true)->get();
	$selectedClassId = $request->query('class_id');
	return view('front.pages.programs.artclass.book', compact('artClasses', 'selectedClassId'));
})->name('artclass.book');

Route::post('/artclass/book/submit', function(Request $request){
    if(!session('auth_user')){ return redirect()->route('login'); }
    
    $validated = $request->validate([
        'artclass_id' => 'required|exists:art_classes,id',
        'participant_name' => 'required|string|max:255',
        'experience_level' => 'nullable|string',
        'payment_method' => 'required|in:midtrans,manual',
    ]);

    $user = User::find(session('auth_user')['id']);
    $artClass = ArtClass::find($validated['artclass_id']);

    $booking = Booking::create([
        'user_id' => $user->id,
        'bookable_type' => ArtClass::class,
        'bookable_id' => $artClass->id,
        'booking_code' => 'ART-' . strtoupper(Str::random(8)),
        'participant_name' => $validated['participant_name'],
        'experience_level' => $validated['experience_level'],
        'payment_method' => $validated['payment_method'],
        'payment_status' => 'pending',
        'status' => 'confirmed',
    ]);

    return redirect()->route('user.bookings')->with('success', 'Booking berhasil dibuat! Kode: ' . $booking->booking_code);
})->name('artclass.book.submit');

Route::get('/educational-program/join', function(Request $request){
    if(!session('auth_user')){ return redirect()->route('login'); }
    $programs = EducationalProgram::where('is_active', true)->get();
    $selectedProgramId = $request->query('program_id');
    return view('front.pages.programs.educational-program.join', compact('programs', 'selectedProgramId'));
})->name('educational-program.join');

Route::post('/educational-program/join/submit', function(Request $request){
    if(!session('auth_user')){ return redirect()->route('login'); }
    
    $validated = $request->validate([
        'program_id' => 'required|exists:educational_programs,id',
        'participant_name' => 'required|string|max:255',
        'institution' => 'nullable|string|max:255',
        'payment_method' => 'required|in:midtrans,manual',
    ]);

    $user = User::find(session('auth_user')['id']);
    $program = EducationalProgram::find($validated['program_id']);

    $booking = Booking::create([
        'user_id' => $user->id,
        'bookable_type' => EducationalProgram::class,
        'bookable_id' => $program->id,
        'booking_code' => 'EDU-' . strtoupper(Str::random(8)),
        'participant_name' => $validated['participant_name'],
        'institution' => $validated['institution'],
        'payment_method' => $validated['payment_method'],
        'payment_status' => 'pending',
        'status' => 'confirmed',
    ]);

    return redirect()->route('user.bookings')->with('success', 'Pendaftaran berhasil! Kode: ' . $booking->booking_code);
})->name('educational-program.join.submit');


// Language Switcher Route
Route::post('/setlocale/{locale}', function($locale) {
    if(in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('setlocale');
