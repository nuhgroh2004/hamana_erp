<x-rekrutmen.layout :title="__('Form Rekrutmen')" active="form-rekrutmen">
    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Form Rekrutmen') }} / {{ __('Daftar Form') }}</div>
            <h1 class="rkm-title">{{ __('Daftar Form') }}</h1>
        </div>
        <div>
            <button type="button" class="rkm-btn p" id="rfNew">{{ __('+ Form Baru') }}</button>
        </div>
    </div>

    <div class="rkm-tw">
        <table>
            <tr>
                <th>{{ __('Judul') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Tautan') }}</th>
                <th>{{ __('Pertanyaan') }}</th>
                <th>{{ __('Respons') }}</th>
                <th>{{ __('Diubah') }}</th>
                <th>{{ __('Aksi') }}</th>
            </tr>
            @forelse ($rows as $r)
                <tr data-rf="{{ $r['id'] }}">
                    <td>
                        <a href="{{ $r['editUrl'] }}" style="color:var(--acc);cursor:pointer"><b>{{ $r['title'] }}</b></a>
                    </td>
                    <td>
                        <button type="button" class="rf-sw {{ $r['active'] ? 'on' : '' }}" data-rf-toggle="{{ $r['toggleUrl'] }}"><i></i>{{ $r['active'] ? __('Aktif') : __('Nonaktif') }}</button>
                        <br>
                        @if (! $r['active'])
                            <span class="rkm-tag r">{{ __('Nonaktif') }}</span>
                        @elseif ($r['open'])
                            <span class="rkm-tag g">{{ __('Aktif') }}</span>
                        @else
                            <span class="rkm-tag y">{{ __('Ditutup') }}</span>
                        @endif
                    </td>
                    <td>
                        <small style="color:var(--mut)">/f/{{ $r['slug'] }}</small><br>
                        <button type="button" class="rkm-btn mini" data-rf-copy="{{ $r['url'] }}">{{ __('Salin') }}</button>
                    </td>
                    <td>{{ $r['n'] }}</td>
                    <td>
                        <span class="rf-rc {{ $r['rc'] ? '' : 'zero' }}">
                            <a href="{{ $r['responsUrl'] }}">{{ $r['rc'] }}</a>
                        </span>
                    </td>
                    <td style="white-space:nowrap">{{ $r['edited'] }}</td>
                    <td class="rkm-rowact">
                        <a href="{{ $r['editUrl'] }}" class="rkm-btn mini">{{ __('Edit') }}</a>
                        <button type="button" class="rkm-btn mini d" data-rf-del="{{ $r['destroyUrl'] }}" data-title="{{ $r['title'] }}">{{ __('Hapus') }}</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="rkm-empty">{{ __('Belum ada form. Klik "+ Form Baru" untuk memulai.') }}</div>
                    </td>
                </tr>
            @endforelse
        </table>
    </div>

    <script>
        window.RF = {
            storeUrl: @json(route('rekrutmen.form.store')),
        };
    </script>
</x-rekrutmen.layout>
