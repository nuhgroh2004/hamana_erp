<x-rekrutmen.layout :title="__('Preview Form')" active="form-rekrutmen">
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
        </div>
    </div>

    <div class="rf-tabs">
        <a href="{{ route('rekrutmen.form.edit', $form) }}">{{ __('Edit') }}</a>
        <a href="{{ route('rekrutmen.form.preview', $form) }}" class="on">{{ __('Preview') }}</a>
        <a href="{{ route('rekrutmen.form.respons', $form) }}">{{ __('Respons') }} ({{ $nResp }})</a>
        <a href="{{ route('rekrutmen.form.bagikan', $form) }}">{{ __('Bagikan') }}</a>
    </div>

    <div class="rf-ban">
        {{ __('Mode pratinjau — tampilan seperti yang dilihat pengisi.') }}
        @if (! $form->is_active)
            <span>{{ __('Form saat ini') }} <b>{{ __('nonaktif') }}</b>.</span>
        @endif
    </div>

    <div class="rf-pvw" id="pvbox"></div>

    <script>
        window.RF = @json($payload);
    </script>
</x-rekrutmen.layout>
