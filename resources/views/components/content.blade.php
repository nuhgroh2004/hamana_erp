@props(['boxed' => true])

<section class="content">
    <button id="menuBtn" type="button">{{ __('☰ Menu') }}</button>
    @if ($boxed)
        <div class="box">{{ $slot }}</div>
    @else
        <div class="page">{{ $slot }}</div>
    @endif
</section>
