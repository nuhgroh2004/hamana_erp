<x-layouts.app :title="__('Pengaturan Umum')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="set">
            <div class="set-body">
                <div class="set-card">
                    <div class="set-row">
                        <div>
                            <div class="set-label"><span class="material-symbols-outlined">language</span>{{ __('Bahasa Aplikasi') }}</div>
                            <div class="set-desc">{{ __('Bahasa tampilan untuk seluruh halaman aplikasi.') }}</div>
                        </div>
                        <form method="POST" action="{{ route('pengaturan.umum.locale') }}">
                            @csrf
                            <select class="set-sel" id="setLang" name="locale" aria-label="{{ __('Bahasa Aplikasi') }}">
                                <option value="id"{{ LaravelLocalization::getCurrentLocale() === 'id' ? ' selected' : '' }}>Bahasa Indonesia</option>
                                <option value="en"{{ LaravelLocalization::getCurrentLocale() === 'en' ? ' selected' : '' }}>English</option>
                                <option value="ja"{{ LaravelLocalization::getCurrentLocale() === 'ja' ? ' selected' : '' }}>日本語</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-content>
</x-layouts.app>
