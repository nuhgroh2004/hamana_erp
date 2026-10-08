<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Masuk') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="login-body">
    <form class="login-card" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="login-brand">HAMANA WORKS INDONESIA</div>
        <div class="login-sub">{{ __('Payroll & ERP') }}</div>

        @if ($errors->any())
            <div class="login-err">{{ $errors->first() }}</div>
        @endif

        <label class="fld"><span>{{ __('Email') }}</span><input type="email" name="email" value="{{ old('email') }}" autocomplete="username" autofocus></label>
        <label class="fld"><span>{{ __('Password') }}</span><input type="password" name="password" autocomplete="current-password"></label>

        <button type="submit" class="btn1 login-btn">{{ __('Masuk') }}</button>
    </form>
</body>
</html>
