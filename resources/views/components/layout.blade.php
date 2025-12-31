<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Museum' }}</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="{{ isset($mainClass) && str_contains($mainClass, 'light-bg') ? 'light-body' : '' }}">

    {{-- INCLUDE NAVBAR COMPONENT --}}
    @if(!isset($mainClass) || !str_contains($mainClass, 'hide-navbar'))
        @include('front.partials.navbar')
    @endif

    {{-- PAGE CONTENT --}}
    <main class="main-content {{ $mainClass ?? '' }}">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer>
        <p>&copy; {{ date('Y') }} Museum Site. All Rights Reserved.</p>
    </footer>

</body>
</html>
