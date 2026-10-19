<x-rekrutmen.layout :title="__('Lowongan')" active="lowongan">
    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Rekrutmen') }} / {{ __('Lowongan') }}</div>
            <h1 class="rkm-title">{{ __('Lowongan Kerja') }}</h1>
        </div>
        <div>
            <button type="button" class="rkm-btn p" data-rkm-form="rkmFormLowongan">+ {{ __('Buat Lowongan') }}</button>
        </div>
    </div>

    <div class="rkm-tw">
        <table>
            <tr>
                <th>{{ __('Posisi') }}</th>
                <th>{{ __('Departemen') }}</th>
                <th>{{ __('Lokasi') }}</th>
                <th>{{ __('Kuota') }}</th>
                <th>{{ __('Pelamar') }}</th>
                <th>Hired</th>
                <th>{{ __('Batas Daftar') }}</th>
                <th>{{ __('Prioritas') }}</th>
                <th>{{ __('Status') }}</th>
                <th></th>
            </tr>
            @forelse ($jobs as $j)
                <tr>
                    <td><b>{{ $j['posisi'] }}</b></td>
                    <td>{{ $j['dept'] }}</td>
                    <td>{{ $j['lokasi'] }}</td>
                    <td>{{ $j['kuota'] }}</td>
                    <td>{{ $j['pelamar'] }}</td>
                    <td class="rkm-hire"><b>{{ $j['hired'] }}</b>/{{ $j['kuota'] }}</td>
                    <td>{{ $j['batas'] }}</td>
                    <td>
                        @if ($j['prioritas'] === 'Tinggi')
                            <span class="rkm-tag y">{{ __('Tinggi') }}</span>
                        @else
                            {{ __('Normal') }}
                        @endif
                    </td>
                    <td>{!! $rkmJobTag($j['status']) !!}</td>
                    <td class="rkm-rowact">
                        @if ($j['statusRaw'] === 'draft')
                            <button type="button" class="rkm-btn mini p" data-rkm-act
                                data-url="{{ route('rekrutmen.lowongan.status', ['jobPosting' => $j['id'], 'status' => 'active']) }}">{{ __('Publikasikan') }}</button>
                        @elseif ($j['statusRaw'] === 'active')
                            <button type="button" class="rkm-btn mini d" data-rkm-act
                                data-confirm="{{ __('Tutup lowongan ini?') }}"
                                data-url="{{ route('rekrutmen.lowongan.status', ['jobPosting' => $j['id'], 'status' => 'closed']) }}">{{ __('Tutup') }}</button>
                        @else
                            <button type="button" class="rkm-btn mini" data-rkm-act
                                data-url="{{ route('rekrutmen.lowongan.status', ['jobPosting' => $j['id'], 'status' => 'active']) }}">{{ __('Buka Lagi') }}</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="10" class="rkm-empty">{{ __('Belum ada lowongan.') }}</td></tr>
            @endforelse
        </table>
    </div>

    <template id="rkmFormLowongan">
        <form class="rkm-fm" data-url="{{ route('rekrutmen.lowongan.store') }}">
            <div class="rkm-dh">
                <div><b>{{ __('Buat Lowongan Baru') }}</b><small>{{ __('Lowongan Kerja') }}</small></div>
                <button type="button" data-rkm-close>&times;</button>
            </div>
            <div class="rkm-fb">
                <label>{{ __('Nama Posisi') }}
                    <input type="text" name="title" required placeholder="mis. Welder 6G (Pengelasan)">
                </label>
                <label>{{ __('Departemen') }}
                    <select name="department_id">
                        <option value="">{{ __('— pilih —') }}</option>
                        @foreach ($departments as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>{{ __('Lokasi') }}
                    <input type="text" name="location" value="Pemalang">
                </label>
                <label>{{ __('Kuota') }}
                    <input type="number" name="quota" min="1" max="999" value="1" required>
                </label>
                <label>{{ __('Batas Daftar') }}
                    <input type="date" name="deadline">
                </label>
                <label>{{ __('Prioritas') }}
                    <select name="priority">
                        <option value="normal">{{ __('Normal') }}</option>
                        <option value="tinggi">{{ __('Tinggi') }}</option>
                    </select>
                </label>
                <label>{{ __('Status Awal') }}
                    <select name="status">
                        <option value="draft">{{ __('Draft') }}</option>
                        <option value="active">{{ __('Aktif') }}</option>
                    </select>
                </label>
                <div class="rkm-act">
                    <button type="submit" class="rkm-btn p">{{ __('Simpan') }}</button>
                </div>
            </div>
        </form>
    </template>
</x-rekrutmen.layout>
