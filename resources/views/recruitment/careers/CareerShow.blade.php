<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $posting->title }} — HAMANA WORKS INDONESIA</title>

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
        <p><a class="rc-link" href="{{ route('recruitment.careers') }}">&larr; {{ __('Kembali ke daftar lowongan') }}</a></p>

        <div class="rc-card">
            <div class="rc-card-title">{{ $posting->title }}</div>
            <div class="rc-sub">{{ $posting->department?->name }} &middot; {{ $posting->location }}</div>
            <div class="career-sec">
                <div class="rc-sub-title">{{ __('Deskripsi') }}</div>
                <div class="career-text">{!! nl2br(e($posting->description)) !!}</div>
            </div>
            <div class="career-sec">
                <div class="rc-sub-title">{{ __('Persyaratan') }}</div>
                <div class="career-text">{!! nl2br(e($posting->requirements)) !!}</div>
            </div>
            @if ($posting->requires_certificate)
                <div class="career-sec">
                    <span class="rc-chip rc-chip-amber">{{ __('Wajib memiliki sertifikat') }}</span>
                </div>
            @endif
        </div>

        <div class="rc-card">
            <div class="rc-card-title">{{ __('Formulir Lamaran') }}</div>

            @if ($errors->any())
                <div class="rc-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" class="rc-form" action="{{ route('recruitment.careers.apply', $posting) }}" enctype="multipart/form-data">
                @csrf
                <div class="rc-f">
                    <label for="name">{{ __('Nama') }} *</label>
                    <input id="name" type="text" name="name" maxlength="255" required value="{{ old('name') }}">
                </div>
                <div class="rc-f">
                    <label for="email">Email *</label>
                    <input id="email" type="email" name="email" maxlength="255" required value="{{ old('email') }}">
                </div>
                <div class="rc-f">
                    <label for="phone">{{ __('No. HP') }}</label>
                    <input id="phone" type="text" name="phone" maxlength="50" value="{{ old('phone') }}">
                </div>
                <div class="rc-f">
                    <label for="national_id">{{ __('No. KTP') }}</label>
                    <input id="national_id" type="text" name="national_id" maxlength="50" value="{{ old('national_id') }}">
                </div>
                <div class="rc-f">
                    <label for="birth_date">{{ __('Tanggal Lahir') }}</label>
                    <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}">
                </div>
                <div class="rc-f">
                    <label for="city">{{ __('Kota') }}</label>
                    <input id="city" type="text" name="city" maxlength="255" value="{{ old('city') }}">
                </div>
                <div class="rc-f">
                    <label for="education">{{ __('Pendidikan') }}</label>
                    <input id="education" type="text" name="education" maxlength="255" value="{{ old('education') }}">
                </div>
                <div class="rc-f">
                    <label for="experience_years">{{ __('Pengalaman (tahun)') }}</label>
                    <input id="experience_years" type="number" name="experience_years" min="0" max="50" value="{{ old('experience_years', 0) }}">
                </div>
                <div class="rc-f">
                    <label for="source_id">{{ __('Sumber kandidat') }}</label>
                    <select id="source_id" name="source_id">
                        <option value="">{{ __('Pilih sumber') }}</option>
                        @foreach ($sources as $s)
                            <option value="{{ $s->id }}"{{ (string) old('source_id') === (string) $s->id ? ' selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="rc-f">
                    <label for="cv">CV * {{ __('(PDF/DOC, maks 5 MB)') }}</label>
                    <input id="cv" type="file" name="cv" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                </div>
                <div class="rc-f">
                    <label for="ktp">KTP</label>
                    <input id="ktp" type="file" name="ktp" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div class="rc-f">
                    <label for="ijazah">{{ __('Ijazah') }}</label>
                    <input id="ijazah" type="file" name="ijazah" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div class="rc-f">
                    <label for="sertifikat">{{ __('Sertifikat') }}</label>
                    <input id="sertifikat" type="file" name="sertifikat" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div class="rc-f rc-full">
                    <label for="notes">{{ __('Motivasi') }}</label>
                    <textarea id="notes" name="notes" maxlength="5000">{{ old('notes') }}</textarea>
                </div>
                <div class="rc-form-acts">
                    <button class="btn1 sm" type="submit"><span class="material-symbols-outlined">send</span>{{ __('Kirim Lamaran') }}</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
