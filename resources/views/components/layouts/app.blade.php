<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'PowerLift' }}</title>

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="{{ asset('assets/onscan/onscan.min.js') }}"></script>
</head>
<body class="antialiased">

    {{ $slot }}

</body>
</html>
