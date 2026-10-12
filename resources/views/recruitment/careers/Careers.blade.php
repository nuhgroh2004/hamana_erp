<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Karier') }} — HAMANA WORKS INDONESIA</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="career-body">
    <header class="career-head">
        <div class="career-brand">HAMANA WORKS INDONESIA</div>
        <nav class="career-lang">
            <a href="{{ LaravelLocalization::getLocalizedURL('id') }}">ID</a>
            <a href="{{ LaravelLocalization::getLocalizedURL('en') }}">EN</a>
            <a href="{{ LaravelLocalization::getLocalizedURL('ja') }}">JA</a>
        </nav>
    </header>

    <main class="career-main">
        @if (session('rc_msg'))
            <div class="rc-flash">{{ session('rc_msg') }}</div>
        @endif

        <h1 class="career-title">{{ __('Lowongan Kerja') }}</h1>

        @forelse ($items as $p)
            <article class="career-item">
                <div>
                    <a class="career-item-title" href="{{ route('recruitment.careers.show', $p) }}">{{ $p->title }}</a>
                    <div class="rc-sub">
                        {{ $p->department?->name }} &middot; {{ $p->location }}
                        @if ($p->deadline)
                            &middot; {{ __('Tutup') }}: {{ $p->deadline->format('d/m/Y') }}
                        @endif
                    </div>
                </div>
                <a class="btn1 sm" href="{{ route('recruitment.careers.show', $p) }}">{{ __('Lamar') }}</a>
            </article>
        @empty
            <p class="rc-sub">{{ __('Belum ada lowongan aktif.') }}</p>
        @endforelse
    </main>
</body>
</html>
