@props(['boxed' => true])

<section class="content">
    <button id="menuBtn" type="button">☰ Menu</button>
    @if ($boxed)
        <div class="box">{{ $slot }}</div>
    @else
        <div class="page">{{ $slot }}</div>
    @endif
</section>
