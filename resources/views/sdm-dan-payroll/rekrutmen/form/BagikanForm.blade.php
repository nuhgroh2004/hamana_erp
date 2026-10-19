<x-rekrutmen.layout :title="__('Bagikan Form')" active="form-rekrutmen">
    @php
        $open = $form->isOpen();
        $stateTag = ! $form->is_active
            ? '<span class="rkm-tag r">' . __('Nonaktif') . '</span>'
            : ($open ? '<span class="rkm-tag g">' . __('Aktif') . '</span>' : '<span class="rkm-tag y">' . __('Ditutup') . '</span>');
        $url = $form->publicUrl();
        $nResp = $form->responses()->count();
    @endphp

    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Form Rekrutmen') }} / {{ __('Editor') }}</div>
            <h1 class="rkm-title">{{ $form->title }}{!! $stateTag !!}</h1>
        </div>
        <div class="rf-hd-act">
            <button type="button" class="rf-sw {{ $form->is_active ? 'on' : '' }}" data-rf-toggle="{{ route('rekrutmen.form.toggle', $form) }}"><i></i>{{ $form->is_active ? __('Aktif') : __('Nonaktif') }}</button>
        </div>
    </div>

    <div class="rf-tabs">
        <a href="{{ route('rekrutmen.form.edit', $form) }}">{{ __('Edit') }}</a>
        <a href="{{ route('rekrutmen.form.preview', $form) }}">{{ __('Preview') }}</a>
        <a href="{{ route('rekrutmen.form.respons', $form) }}">{{ __('Respons') }} ({{ $nResp }})</a>
        <a href="{{ route('rekrutmen.form.bagikan', $form) }}" class="on">{{ __('Bagikan') }}</a>
    </div>

    <div class="rkm-card">
        <h3>{{ __('Status Form') }}</h3>
        <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap">
            <button type="button" class="rf-sw {{ $form->is_active ? 'on' : '' }}" data-rf-toggle="{{ route('rekrutmen.form.toggle', $form) }}"><i></i>{{ $form->is_active ? __('Aktif') : __('Nonaktif') }}</button>
            <span style="color:var(--mut)">{{ $form->is_active ? __('Form menerima respons.') : __('Pengunjung melihat pesan "Form tidak menerima respons".') }}</span>
        </div>
    </div>

    <div class="rkm-card">
        <h3>{{ __('Tautan Publik') }}</h3>
        <div class="rf-lk">
            <input type="text" class="rf-in" id="rfbUrl" readonly value="{{ $url }}">
            <button type="button" class="rkm-btn p" id="rfbCopy" data-url="{{ $url }}">{{ __('Salin') }}</button>
            <a href="{{ $url }}" target="_blank" rel="noopener" class="rkm-btn">{{ __('Buka Halaman Publik') }}</a>
        </div>
        <label class="rf-lb">{{ __('Kode sematan (embed)') }}</label>
        <textarea class="rf-in rfb-embed" id="rfbEmbed" readonly>{{ $embed }}</textarea>
        <div style="margin-top:10px">
            <button type="button" class="rkm-btn mini" id="rfbRegen" data-url="{{ route('rekrutmen.form.regenerate', $form) }}">{{ __('Buat tautan baru') }}</button>
            <small style="color:var(--mut)">{{ __('Tautan lama otomatis tidak berlaku.') }}</small>
        </div>
    </div>

    <div class="rkm-card">
        <h3>{{ __('Pengaturan Pengiriman') }}</h3>
        <form id="rfbForm" data-url="{{ $saveUrl }}">
            <div class="rf-row">
                <div>
                    <label class="rf-lb" style="margin-top:0">{{ __('Batas jumlah respons (0 = tanpa batas)') }}</label>
                    <input type="number" class="rf-in" name="response_limit" min="0" value="{{ $form->response_limit }}">
                </div>
                <div>
                    <label class="rf-lb" style="margin-top:0">{{ __('Tutup otomatis pada tanggal') }}</label>
                    <input type="date" class="rf-in" name="close_at" value="{{ $form->close_at?->format('Y-m-d') }}">
                </div>
            </div>
            <label class="rf-lb">{{ __('Pesan setelah form dikirim') }}</label>
            <textarea class="rf-in" name="success_msg" rows="2">{{ $form->success_msg }}</textarea>
            <div class="rfb-act">
                <button type="submit" class="rkm-btn p">{{ __('Simpan Pengaturan') }}</button>
            </div>
        </form>
    </div>
</x-rekrutmen.layout>
