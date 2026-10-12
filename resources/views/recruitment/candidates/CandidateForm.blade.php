<x-layouts.app :title="$item ? __('Ubah Kandidat') : __('Tambah Kandidat')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            @if ($errors->any())
                <div class="rc-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="rc-card">
                <div class="rc-card-title">{{ $item ? __('Ubah Kandidat') : __('Tambah Kandidat') }}</div>
                <form method="POST" class="rc-form" action="{{ $item ? route('recruitment.candidates.update', $item) : route('recruitment.candidates.store') }}">
                    @csrf
                    @if ($item)
                        @method('PUT')
                    @endif
                    <div class="rc-f">
                        <label for="name">{{ __('Nama') }}</label>
                        <input id="name" type="text" name="name" maxlength="255" required value="{{ old('name', $item?->name) }}">
                    </div>
                    <div class="rc-f">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" maxlength="255" required value="{{ old('email', $item?->email) }}">
                    </div>
                    <div class="rc-f">
                        <label for="phone">{{ __('No. HP') }}</label>
                        <input id="phone" type="text" name="phone" maxlength="50" value="{{ old('phone', $item?->phone) }}">
                    </div>
                    <div class="rc-f">
                        <label for="national_id">{{ __('No. KTP') }}</label>
                        <input id="national_id" type="text" name="national_id" maxlength="50" value="{{ old('national_id', $item?->national_id) }}">
                    </div>
                    <div class="rc-f">
                        <label for="birth_date">{{ __('Tanggal Lahir') }}</label>
                        <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date', $item?->birth_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="rc-f">
                        <label for="city">{{ __('Kota') }}</label>
                        <input id="city" type="text" name="city" maxlength="255" value="{{ old('city', $item?->city) }}">
                    </div>
                    <div class="rc-f">
                        <label for="education">{{ __('Pendidikan') }}</label>
                        <input id="education" type="text" name="education" maxlength="255" value="{{ old('education', $item?->education) }}">
                    </div>
                    <div class="rc-f">
                        <label for="experience_years">{{ __('Pengalaman (tahun)') }}</label>
                        <input id="experience_years" type="number" name="experience_years" min="0" max="50" value="{{ old('experience_years', $item?->experience_years ?? 0) }}">
                    </div>
                    <div class="rc-f">
                        <label for="source_id">{{ __('Sumber kandidat') }}</label>
                        <select id="source_id" name="source_id">
                            <option value="">{{ __('Pilih sumber') }}</option>
                            @foreach ($sources as $s)
                                <option value="{{ $s->id }}"{{ (string) old('source_id', $item?->source_id) === (string) $s->id ? ' selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="rc-f rc-full">
                        <label for="notes">{{ __('Catatan') }}</label>
                        <textarea id="notes" name="notes" maxlength="5000">{{ old('notes', $item?->notes) }}</textarea>
                    </div>
                    <div class="rc-form-acts">
                        <button class="btn1 sm" type="submit"><span class="material-symbols-outlined">save</span>{{ __('Simpan') }}</button>
                        <a class="btn2 sm" href="{{ $item ? route('recruitment.candidates.show', $item) : route('recruitment.candidates') }}">{{ __('Batal') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </x-content>
</x-layouts.app>
