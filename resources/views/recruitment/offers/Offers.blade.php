<x-layouts.app :title="__('Penawaran')">
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
                    <div class="rc-card-title">{{ __('Daftar Penawaran') }}</div>
                    <div class="rc-scroll">
                        <table class="rc-tbl">
                            <thead>
                                <tr>
                                    <th>{{ __('Kandidat') }}</th>
                                    <th>{{ __('Posisi') }}</th>
                                    <th>{{ __('Gaji Pokok') }}</th>
                                    <th>{{ __('Tunjangan') }}</th>
                                    <th>{{ __('Mulai') }}</th>
                                    <th>{{ __('Berlaku s/d') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $o)
                                    <tr>
                                        <td><a class="rc-link" href="{{ route('recruitment.candidates.show', $o->application?->candidate) }}">{{ $o->application?->candidate?->name }}</a></td>
                                        <td>{{ $o->application?->jobPosting?->title }}</td>
                                        <td>{{ number_format((float) $o->base_salary, 0, ',', '.') }}</td>
                                        <td>{{ $o->allowance ? number_format((float) $o->allowance, 0, ',', '.') : '—' }}</td>
                                        <td>{{ $o->start_date?->format('d/m/Y') }}</td>
                                        <td>{{ $o->valid_until?->format('d/m/Y') }}</td>
                                        <td><span class="rc-chip {{ match ($o->status->value) { 'accepted' => 'rc-chip-teal', 'declined' => 'rc-chip-red', 'approved', 'sent' => 'rc-chip-purple', default => 'rc-chip-amber' } }}">{{ $o->status->label() }}</span></td>
                                        <td>
                                            <div class="rc-actions">
                                                @if ($o->status->value === 'pending_approval')
                                                    <form method="POST" action="{{ route('recruitment.offers.approve', $o) }}">
                                                        @csrf
                                                        <button class="btn1 sm" type="submit" data-confirm="{{ __('Setujui penawaran ini?') }}"><span class="material-symbols-outlined">check</span>{{ __('Setujui') }}</button>
                                                    </form>
                                                @endif
                                                @if (in_array($o->status->value, ['approved', 'sent'], true))
                                                    <form method="POST" action="{{ route('recruitment.offers.accept', $o) }}">
                                                        @csrf
                                                        <button class="btn1 sm" type="submit" data-confirm="{{ __('Terima penawaran ini? Onboarding dan draft karyawan akan dibuat.') }}"><span class="material-symbols-outlined">how_to_reg</span>{{ __('Diterima') }}</button>
                                                    </form>
                                                @endif
                                                @if (in_array($o->status->value, ['draft', 'pending_approval', 'approved', 'sent'], true))
                                                    <form method="POST" action="{{ route('recruitment.offers.decline', $o) }}">
                                                        @csrf
                                                        <button class="btn2 sm" type="submit" data-confirm="{{ __('Tolak penawaran ini?') }}"><span class="material-symbols-outlined">close</span>{{ __('Ditolak') }}</button>
                                                    </form>
                                                @endif
                                            </div>
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
                    <div class="rc-card-title">{{ __('Buat Penawaran') }}</div>
                    <form method="POST" class="rc-form" action="{{ route('recruitment.offers.store') }}">
                        @csrf
                        <div class="rc-f">
                            <label for="o_application_id">{{ __('Lamaran') }} *</label>
                            <select id="o_application_id" name="application_id" required>
                                <option value="">{{ __('Pilih kandidat') }}</option>
                                @foreach ($applications as $app)
                                    <option value="{{ $app->id }}">{{ $app->candidate?->name }} — {{ $app->jobPosting?->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="rc-f">
                            <label for="base_salary">{{ __('Gaji pokok') }} *</label>
                            <input id="base_salary" type="number" name="base_salary" min="0" step="1" required>
                        </div>
                        <div class="rc-f">
                            <label for="allowance">{{ __('Tunjangan') }}</label>
                            <input id="allowance" type="number" name="allowance" min="0" step="1">
                        </div>
                        <div class="rc-f">
                            <label for="start_date">{{ __('Tanggal mulai') }} *</label>
                            <input id="start_date" type="date" name="start_date" required>
                        </div>
                        <div class="rc-f">
                            <label for="valid_until">{{ __('Masa berlaku') }} *</label>
                            <input id="valid_until" type="date" name="valid_until" required>
                        </div>
                        <div class="rc-form-acts">
                            <button class="btn1 sm" type="submit"><span class="material-symbols-outlined">request_quote</span>{{ __('Buat Penawaran') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-content>
</x-layouts.app>
