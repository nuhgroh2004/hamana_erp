@php
    $u = auth()->user();
    $roleLabel = $u ? ($u->role === 'superadmin' ? __('Super Admin') : __('User')) : __('Admin');
@endphp
<div class="foot">
    <span>{{ $version ?? 'v1.0' }} · {{ $u ? $u->name . ' · ' . $roleLabel : __('Admin') }}</span>
    <span class="foot-btns">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">{{ __('Keluar') }}</button>
        </form>
        <button id="theme" type="button">{{ __('Tema') }}</button>
    </span>
</div>
