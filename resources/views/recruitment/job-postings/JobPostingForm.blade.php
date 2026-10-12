<x-layouts.app :title="$item ? __('Ubah Lowongan') : __('Buat Lowongan')">
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
                <div class="rc-card-title">{{ $item ? __('Ubah Lowongan') : __('Buat Lowongan') }}</div>
                <form method="POST" class="rc-form" action="{{ $item ? route('recruitment.job-postings.update', $item) : route('recruitment.job-postings.store') }}">
                    @csrf
                    @if ($item)
                        @method('PUT')
                    @endif
                    <div class="rc-f rc-full">
                        <label for="job_request_id">{{ __('Permintaan tenaga kerja') }}</label>
                        <select id="job_request_id" name="job_request_id" required>
                            <option value="">{{ __('Pilih MPP yang disetujui') }}</option>
                            @foreach ($jobRequests as $jr)
                                <option value="{{ $jr->id }}"{{ (string) old('job_request_id', $item?->job_request_id) === (string) $jr->id ? ' selected' : '' }}>
                                    {{ $jr->code }} — {{ $jr->department?->name }} ({{ __('Jumlah') }}: {{ $jr->quantity }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="rc-f rc-full">
                        <label for="title">{{ __('Judul lowongan') }}</label>
                        <input id="title" type="text" name="title" maxlength="255" required value="{{ old('title', $item?->title) }}">
                    </div>
                    <div class="rc-f">
                        <label for="department_id">{{ __('Departemen') }}</label>
                        <select id="department_id" name="department_id">
                            <option value="">{{ __('Pilih departemen') }}</option>
                            @foreach ($departments as $d)
                                <option value="{{ $d->id }}"{{ (string) old('department_id', $item?->department_id) === (string) $d->id ? ' selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="rc-f">
                        <label for="location">{{ __('Lokasi') }}</label>
                        <input id="location" type="text" name="location" maxlength="255" value="{{ old('location', $item?->location) }}">
                    </div>
                    <div class="rc-f">
                        <label for="quota">{{ __('Kuota') }}</label>
                        <input id="quota" type="number" name="quota" min="1" max="999" required value="{{ old('quota', $item?->quota ?? 1) }}">
                    </div>
                    <div class="rc-f">
                        <label for="deadline">{{ __('Batas daftar') }}</label>
                        <input id="deadline" type="date" name="deadline" value="{{ old('deadline', $item?->deadline?->format('Y-m-d')) }}">
                    </div>
                    <div class="rc-f">
                        <label for="priority">{{ __('Prioritas') }}</label>
                        <select id="priority" name="priority" required>
                            <option value="low"{{ old('priority', $item?->priority ?? 'normal') === 'low' ? ' selected' : '' }}>{{ __('Rendah') }}</option>
                            <option value="normal"{{ old('priority', $item?->priority ?? 'normal') === 'normal' ? ' selected' : '' }}>{{ __('Sedang') }}</option>
                            <option value="high"{{ old('priority', $item?->priority ?? 'normal') === 'high' ? ' selected' : '' }}>{{ __('Tinggi') }}</option>
                        </select>
                    </div>
                    <div class="rc-f rc-check">
                        <label>
                            <input type="checkbox" name="requires_certificate" value="1"{{ $item?->requires_certificate ? ' checked' : '' }}>
                            {{ __('Wajib sertifikat') }}
                        </label>
                    </div>
                    <div class="rc-f rc-full">
                        <label for="description">{{ __('Deskripsi') }}</label>
                        <textarea id="description" name="description" maxlength="5000">{{ old('description', $item?->description) }}</textarea>
                    </div>
                    <div class="rc-f rc-full">
                        <label for="requirements">{{ __('Kualifikasi') }}</label>
                        <textarea id="requirements" name="requirements" maxlength="5000">{{ old('requirements', $item?->requirements) }}</textarea>
                    </div>
                    <div class="rc-form-acts">
                        <button class="btn1 sm" type="submit"><span class="material-symbols-outlined">save</span>{{ __('Simpan') }}</button>
                        <a class="btn2 sm" href="{{ route('recruitment.job-postings') }}">{{ __('Batal') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </x-content>
</x-layouts.app>
