@props(['crumb' => 'Beranda', 'title' => 'Pilih menu di sidebar'])

<section class="content">
    <button id="menuBtn" type="button">☰ Menu</button>
    <div class="crumb" id="crumb">{{ $crumb }}</div>
    <h1 id="title">{{ $title }}</h1>
    <div class="box">{{ $slot }}</div>
</section>
