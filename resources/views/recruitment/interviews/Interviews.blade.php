<x-layouts.app :title="__('Interview & Tes')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            @if (session('rc_msg'))
                <div class="rc-flash">{{ session('rc_msg') }}</div>
            @endif
            @if ($errors->any())
                <div class="rc-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="rc-grid3">
                <div class="rc-card rc-span2">
                    <div class="rc-bar">
                        <div class="rc-card-title">{{ __('Jadwal Interview') }}</div>
                        <form method="GET" class="rc-filter">
                            <select name="type" aria-label="{{ __('Jenis') }}">
                                <option value="">{{ __('Semua Jenis') }}</option>
                                <option value="hr"{{ $type === 'hr' ? ' selected' : '' }}>{{ __('Interview HR') }}</option>
                                <option value="user"{{ $type === 'user' ? ' selected' : '' }}>{{ __('Interview User') }}</option>
                            </select>
                            <button class="btn2 sm" type="submit">{{ __('Terapkan') }}</button>
                        </form>
                    </div>
                    <div class="rc-scroll">
                        <table class="rc-tbl">
                            <thead>
                                <tr>
                                    <th>{{ __('Waktu') }}</th>
                                    <th>{{ __('Kandidat') }}</th>
                                    <th>{{ __('Posisi') }}</th>
                                    <th>{{ __('Jenis') }}</th>
                                    <th>{{ __('Tempat') }}</th>
                                    <th>{{ __('Pewawancara') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $iv)
                                    <tr>
                                        <td>{{ $iv->scheduled_at?->format('d/m/Y H:i') }} ({{ $iv->duration_minutes }} {{ __('mnt') }})</td>
                                        <td><a class="rc-link" href="{{ route('recruitment.candidates.show', $iv->application?->candidate) }}">{{ $iv->application?->candidate?->name }}</a></td>
                                        <td>{{ $iv->application?->jobPosting?->title }}</td>
                                        <td>{{ \App\Modules\Recruitment\Enums\InterviewType::tryFrom($iv->type)?->label() ?? $iv->type }}</td>
                                        <td>{{ $iv->location }}</td>
                                        <td>{{ $iv->participants->pluck('user.name')->join(', ') }}</td>
                                        <td>
                                            @if ($iv->status === 'cancelled')
                                                <span class="rc-chip rc-chip-red">{{ __('Dibatalkan') }}</span>
                                            @elseif ($iv->status === 'done')
                                                <span class="rc-chip rc-chip-purple">{{ __('Selesai') }}</span>
                                            @else
                                                <span class="rc-chip rc-chip-teal">{{ __('Terjadwal') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($iv->status !== 'cancelled' && $iv->status !== 'done')
                                                <form method="POST" action="{{ route('recruitment.interviews.cancel', $iv) }}">
                                                    @csrf
                                                    <button class="btn2 sm" type="submit" data-confirm="{{ __('Batalkan interview ini?') }}"><span class="material-symbols-outlined">close</span>{{ __('Batal') }}</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8">{{ __('Belum ada data') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $items->links() }}
                </div>

                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Jadwalkan Interview') }}</div>
                    <form method="POST" class="rc-form" action="{{ route('recruitment.interviews.store') }}">
                        @csrf
                        <div class="rc-f">
                            <label for="application_id">{{ __('Lamaran') }} *</label>
                            <select id="application_id" name="application_id" required>
                                <option value="">{{ __('Pilih kandidat') }}</option>
                                @foreach ($applications as $app)
                                    <option value="{{ $app->id }}">{{ $app->candidate?->name }} — {{ $app->jobPosting?->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="rc-f">
                            <label for="type">{{ __('Jenis') }} *</label>
                            <select id="type" name="type" required>
                                @foreach ($interviewTypes as $t)
                                    <option value="{{ $t->value }}">{{ $t->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="rc-f">
                            <label for="scheduled_at">{{ __('Waktu') }} *</label>
                            <input id="scheduled_at" type="datetime-local" name="scheduled_at" required>
                        </div>
                        <div class="rc-f">
                            <label for="duration_minutes">{{ __('Durasi (menit)') }} *</label>
                            <input id="duration_minutes" type="number" name="duration_minutes" min="5" max="480" value="60" required>
                        </div>
                        <div class="rc-f">
                            <label for="location">{{ __('Tempat') }}</label>
                            <input id="location" type="text" name="location" maxlength="255">
                        </div>
                        <div class="rc-f">
                            <label for="participants">{{ __('Pewawancara') }}</label>
                            <select id="participants" name="participants[]" multiple size="5">
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="rc-form-acts">
                            <button class="btn1 sm" type="submit"><span class="material-symbols-outlined">event</span>{{ __('Jadwalkan') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="rc-grid3">
                <div class="rc-card rc-span3">
                    <div class="rc-card-title">{{ __('Catat Hasil Tes') }}</div>
                    <form method="POST" class="rc-form rc-form-inline" action="{{ route('recruitment.assessments.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="rc-f">
                            <label for="a_application_id">{{ __('Lamaran') }} *</label>
                            <select id="a_application_id" name="application_id" required>
                                <option value="">{{ __('Pilih kandidat') }}</option>
                                @foreach ($applications as $app)
                                    <option value="{{ $app->id }}">{{ $app->candidate?->name }} — {{ $app->jobPosting?->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="rc-f">
                            <label for="a_type">{{ __('Jenis tes') }} *</label>
                            <input id="a_type" type="text" name="type" maxlength="255" required placeholder="{{ __('Mis. Coding test') }}">
                        </div>
                        <div class="rc-f">
                            <label for="score">{{ __('Skor (0-100)') }}</label>
                            <input id="score" type="number" name="score" min="0" max="100" step="0.01">
                        </div>
                        <div class="rc-f rc-check">
                            <label><input type="checkbox" name="passed" value="1" checked> {{ __('Lulus') }}</label>
                        </div>
                        <div class="rc-f">
                            <label for="attachment">{{ __('Lampiran') }}</label>
                            <input id="attachment" type="file" name="attachment" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        </div>
                        <div class="rc-f rc-full">
                            <label for="a_notes">{{ __('Catatan') }}</label>
                            <textarea id="a_notes" name="notes" maxlength="5000"></textarea>
                        </div>
                        <div class="rc-form-acts">
                            <button class="btn1 sm" type="submit"><span class="material-symbols-outlined">save</span>{{ __('Simpan Hasil') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-content>
</x-layouts.app>
