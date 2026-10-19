<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $form->title }} — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="rfpub">
        <div class="rf-ob">
            <span>{{ __('Halaman Publik') }} · /f/{{ $form->slug }}</span>
        </div>
        <div class="rf-pvw">
            <div class="rf-fm">
                <h2>{{ $form->title }}</h2>
                @if ($reason === 'inactive')
                    <p>{{ __('Form ini sedang tidak menerima respons.') }}</p>
                @else
                    <p>{{ __('Form ini sudah ditutup (batas respons atau tanggal tutup tercapai).') }}</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
