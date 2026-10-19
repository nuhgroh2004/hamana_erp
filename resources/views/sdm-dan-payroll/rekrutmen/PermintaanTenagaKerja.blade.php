<x-rekrutmen.layout :title="__('Permintaan Tenaga Kerja')" active="permintaan-tenaga-kerja">
    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Rekrutmen') }} / {{ __('Permintaan Tenaga Kerja') }}</div>
            <h1 class="rkm-title">{{ __('Permintaan Tenaga Kerja (MPP)') }}</h1>
        </div>
        <div>
            <button type="button" class="rkm-btn p" data-rkm-form="rkmFormMpp">+ {{ __('Permintaan Baru') }}</button>
        </div>
    </div>

    <div class="rkm-tw">
        <table>
            <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('Posisi') }}</th>
                <th>{{ __('Departemen') }}</th>
                <th>{{ __('Jumlah') }}</th>
                <th>{{ __('Alasan') }}</th>
                <th>{{ __('Status') }}</th>
                <th></th>
            </tr>
            @forelse ($rows as $r)
                @php
                    $cls = match ($r['statusRaw']) {
                        'approved' => 'g',
                        'pending' => 'y',
                        default => 'r',
                    };
                @endphp
                <tr>
                    <td><b>{{ $r['no'] }}</b></td>
                    <td>{{ $r['posisi'] }}</td>
                    <td>{{ $r['dept'] }}</td>
                    <td class="rkm-num">{{ $r['jumlah'] }}</td>
                    <td>{{ $r['alasan'] }}</td>
                    <td><span class="rkm-tag {{ $cls }}">{{ __($r['status']) }}</span></td>
                    <td class="rkm-rowact">
                        @if ($r['statusRaw'] === 'pending')
                            <button type="button" class="rkm-btn mini p" data-rkm-act
                                data-url="{{ route('rekrutmen.mpp.status', ['jobRequest' => $r['id'], 'status' => 'approved']) }}">{{ __('Setujui') }}</button>
                            <button type="button" class="rkm-btn mini d" data-rkm-act
                                data-confirm="{{ __('Tolak permintaan ini?') }}"
                                data-url="{{ route('rekrutmen.mpp.status', ['jobRequest' => $r['id'], 'status' => 'rejected']) }}">{{ __('Tolak') }}</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="rkm-empty">{{ __('Belum ada permintaan.') }}</td></tr>
            @endforelse
        </table>
    </div>

    <template id="rkmFormMpp">
        <form class="rkm-fm" data-url="{{ route('rekrutmen.mpp.store') }}">
            <div class="rkm-dh">
                <div><b>{{ __('Permintaan Tenaga Kerja Baru') }}</b><small>{{ __('Form MPP') }}</small></div>
                <button type="button" data-rkm-close>&times;</button>
            </div>
            <div class="rkm-fb">
                <label>{{ __('Departemen') }}
                    <select name="department_id" required data-filter-dept="rkmMppPos">
                        <option value="">{{ __('— pilih —') }}</option>
                        @foreach ($departments as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>{{ __('Posisi') }}
                    <select name="position_id" id="rkmMppPos" required>
                        <option value="">{{ __('— pilih —') }}</option>
                        @foreach ($positions as $p)
                            <option value="{{ $p->id }}" data-dept="{{ $p->department_id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>{{ __('Jumlah Karyawan') }}
                    <input type="number" name="quantity" min="1" max="999" value="1" required>
                </label>
                <label>{{ __('Alasan') }}
                    <textarea name="reason" rows="3" required></textarea>
                </label>
                <label>{{ __('Target Tanggal Mulai') }}
                    <input type="date" name="target_date" required>
                </label>
                <div class="rkm-act">
                    <button type="submit" class="rkm-btn p">{{ __('Simpan') }}</button>
                </div>
            </div>
        </form>
    </template>
</x-rekrutmen.layout>
