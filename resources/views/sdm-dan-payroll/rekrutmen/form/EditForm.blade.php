<x-rekrutmen.layout :title="__('Edit Form')" active="form-rekrutmen">
    @php
        $open = $form->isOpen();
        $stateTag = ! $form->is_active
            ? '<span class="rkm-tag r">' . __('Nonaktif') . '</span>'
            : ($open ? '<span class="rkm-tag g">' . __('Aktif') . '</span>' : '<span class="rkm-tag y">' . __('Ditutup') . '</span>');
        $nResp = $form->responses()->count();
    @endphp

    <div class="rkm-top">
        <div>
            <div class="rkm-crumb">{{ __('Form Rekrutmen') }} / {{ __('Editor') }}</div>
            <h1 class="rkm-title">{{ $form->title }}{!! $stateTag !!}</h1>
        </div>
        <div class="rf-hd-act">
            <button type="button" class="rf-sw {{ $form->is_active ? 'on' : '' }}" data-rf-toggle="{{ route('rekrutmen.form.toggle', $form) }}"><i></i>{{ $form->is_active ? __('Aktif') : __('Nonaktif') }}</button>
            <button type="button" class="rkm-btn p" id="rfeSave">{{ __('Simpan') }}</button>
        </div>
    </div>

    <div class="rf-tabs">
        <a href="{{ route('rekrutmen.form.edit', $form) }}" class="on">{{ __('Edit') }}</a>
        <a href="{{ route('rekrutmen.form.preview', $form) }}">{{ __('Preview') }}</a>
        <a href="{{ route('rekrutmen.form.respons', $form) }}">{{ __('Respons') }} ({{ $nResp }})</a>
        <a href="{{ route('rekrutmen.form.bagikan', $form) }}">{{ __('Bagikan') }}</a>
    </div>

    <div class="rkm-card">
        <h3>{{ __('Informasi Form') }}</h3>
        <label class="rf-lb" style="margin-top:0">{{ __('Judul form') }}</label>
        <input type="text" class="rf-in" id="rfeTitle" value="{{ $form->title }}" maxlength="255">
        <label class="rf-lb">{{ __('Deskripsi') }}</label>
        <textarea class="rf-in" id="rfeDesc" rows="2">{{ $form->description }}</textarea>
    </div>

    <div class="rf-add" id="rfeAdd">
        <span>{{ __('Tambah pertanyaan:') }}</span>
        @foreach (\App\Models\Recruitment\FormField::TYPES as $key => $label)
            <button type="button" class="rkm-btn mini" data-add="{{ $key }}">+ {{ $label }}</button>
        @endforeach
    </div>

    <div id="rfeList"></div>

    <script>
        window.RF = @json($payload);
    </script>
</x-rekrutmen.layout>
