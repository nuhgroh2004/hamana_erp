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
                        <select class="set-sel" id="setLang" aria-label="{{ __('Bahasa Aplikasi') }}">
                            <option value="{{ LaravelLocalization::getLocalizedURL('id') }}"{{ LaravelLocalization::getCurrentLocale() === 'id' ? ' selected' : '' }}>Bahasa Indonesia</option>
                            <option value="{{ LaravelLocalization::getLocalizedURL('en') }}"{{ LaravelLocalization::getCurrentLocale() === 'en' ? ' selected' : '' }}>English</option>
                            <option value="{{ LaravelLocalization::getLocalizedURL('ja') }}"{{ LaravelLocalization::getCurrentLocale() === 'ja' ? ' selected' : '' }}>日本語</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </x-content>
</x-layouts.app>
