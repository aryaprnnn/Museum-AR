<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ARtifact Museum' }}</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    {{-- INCLUDE NAVBAR COMPONENT --}}
    @include('backend.partials.header')

    {{-- PAGE CONTENT --}}
    <main class="main-content">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer>
        <p>&copy; {{ date('Y') }} Museum Site. All Rights Reserved.</p>
    </footer>

</body>
</html>
