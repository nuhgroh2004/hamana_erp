<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $payload['title'] }} — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/form-public.js'])
</head>
<body>
    <div class="rfpub">
        <div class="rf-ob">
            <span>{{ __('Halaman Publik') }} · /f/{{ $payload['slug'] }}</span>
        </div>
        <div class="rf-pvw" id="pvbox"></div>
    </div>
    <script>
        window.RF = @json($payload);
    </script>
</body>
</html>
