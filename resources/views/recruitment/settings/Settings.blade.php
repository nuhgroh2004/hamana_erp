<x-layouts.app :title="__('Pengaturan Rekrutmen')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            @if (session('rc_msg'))
                <div class="rc-flash">{{ session('rc_msg') }}</div>
            @endif
            @if (session('rc_errors'))
                <div class="rc-errors">
                    <ul>
                        <li>{{ session('rc_errors') }}</li>
                    </ul>
                </div>
            @endif

            <div class="rc-grid3">
                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Tahapan') }}</div>
                    <form method="POST" class="rc-filter" action="{{ route('recruitment.settings.stages.store') }}">
                        @csrf
                        <input type="text" name="name" maxlength="255" required placeholder="{{ __('Nama tahap baru') }}" aria-label="{{ __('Nama tahap') }}">
                        <button class="btn1 sm" type="submit">{{ __('Tambah') }}</button>
                    </form>
                    <table class="rc-tbl">
                        <thead>
                            <tr><th>#</th><th>{{ __('Nama') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($stages as $s)
                                <tr>
                                    <td>{{ $s->order }}</td>
                                    <td>{{ $s->name }}@if ($s->is_final) <span class="rc-chip rc-chip-purple">{{ __('Final') }}</span> @endif</td>
                                    <td>
                                        <span class="rc-chip {{ $s->is_active ? 'rc-chip-teal' : 'rc-chip-mut' }}">{{ $s->is_active ? __('Aktif') : __('Nonaktif') }}</span>
                                    </td>
                                    <td>
                                        <div class="rc-actions">
                                            <form method="POST" action="{{ route('recruitment.settings.stages.toggle', $s) }}">
                                                @csrf
                                                <button class="btn2 sm" type="submit">{{ $s->is_active ? __('Nonaktifkan') : __('Aktifkan') }}</button>
                                            </form>
                                            <form method="POST" action="{{ route('recruitment.settings.stages.destroy', $s) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn2 sm" type="submit" data-confirm="{{ __('Hapus tahap :name?', ['name' => $s->name]) }}"><span class="material-symbols-outlined">delete</span></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Alasan Penolakan') }}</div>
                    <form method="POST" class="rc-filter" action="{{ route('recruitment.settings.reasons.store') }}">
                        @csrf
                        <input type="text" name="name" maxlength="255" required placeholder="{{ __('Alasan baru') }}" aria-label="{{ __('Alasan') }}">
                        <button class="btn1 sm" type="submit">{{ __('Tambah') }}</button>
                    </form>
                    <table class="rc-tbl">
                        <thead>
                            <tr><th>{{ __('Nama') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($reasons as $r)
                                <tr>
                                    <td>{{ $r->name }}</td>
                                    <td><span class="rc-chip {{ $r->is_active ? 'rc-chip-teal' : 'rc-chip-mut' }}">{{ $r->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
                                    <td>
                                        <div class="rc-actions">
                                            <form method="POST" action="{{ route('recruitment.settings.reasons.toggle', $r) }}">
                                                @csrf
                                                <button class="btn2 sm" type="submit">{{ $r->is_active ? __('Nonaktifkan') : __('Aktifkan') }}</button>
                                            </form>
                                            <form method="POST" action="{{ route('recruitment.settings.reasons.destroy', $r) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn2 sm" type="submit" data-confirm="{{ __('Hapus alasan :name?', ['name' => $r->name]) }}"><span class="material-symbols-outlined">delete</span></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Sumber Kandidat') }}</div>
                    <form method="POST" class="rc-filter" action="{{ route('recruitment.settings.sources.store') }}">
                        @csrf
                        <input type="text" name="name" maxlength="255" required placeholder="{{ __('Sumber baru') }}" aria-label="{{ __('Sumber') }}">
                        <button class="btn1 sm" type="submit">{{ __('Tambah') }}</button>
                    </form>
                    <table class="rc-tbl">
                        <thead>
                            <tr><th>{{ __('Nama') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($sources as $s)
                                <tr>
                                    <td>{{ $s->name }}</td>
                                    <td><span class="rc-chip {{ $s->is_active ? 'rc-chip-teal' : 'rc-chip-mut' }}">{{ $s->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
                                    <td>
                                        <div class="rc-actions">
                                            <form method="POST" action="{{ route('recruitment.settings.sources.toggle', $s) }}">
                                                @csrf
                                                <button class="btn2 sm" type="submit">{{ $s->is_active ? __('Nonaktifkan') : __('Aktifkan') }}</button>
                                            </form>
                                            <form method="POST" action="{{ route('recruitment.settings.sources.destroy', $s) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn2 sm" type="submit" data-confirm="{{ __('Hapus sumber :name?', ['name' => $s->name]) }}"><span class="material-symbols-outlined">delete</span></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rc-grid3">
                <div class="rc-card">
                    <div class="rc-card-title">{{ __('Template Onboarding') }}</div>
                    <form method="POST" class="rc-filter" action="{{ route('recruitment.settings.onboarding-templates.store') }}">
                        @csrf
                        <input type="text" name="title" maxlength="255" required placeholder="{{ __('Judul tugas baru') }}" aria-label="{{ __('Judul tugas') }}">
                        <button class="btn1 sm" type="submit">{{ __('Tambah') }}</button>
                    </form>
                    <table class="rc-tbl">
                        <thead>
                            <tr><th>#</th><th>{{ __('Tugas') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($onboardingTemplates as $t)
                                <tr>
                                    <td>{{ $t->order }}</td>
                                    <td>{{ $t->title }}</td>
                                    <td><span class="rc-chip {{ $t->is_active ? 'rc-chip-teal' : 'rc-chip-mut' }}">{{ $t->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('recruitment.settings.onboarding-templates.toggle', $t) }}">
                                            @csrf
                                            <button class="btn2 sm" type="submit">{{ $t->is_active ? __('Nonaktifkan') : __('Aktifkan') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="rc-card rc-span2">
                    <div class="rc-card-title">{{ __('Template Email') }}</div>
                    <table class="rc-tbl">
                        <thead>
                            <tr><th>{{ __('Kunci') }}</th><th>{{ __('Subjek') }}</th><th>{{ __('Status') }}</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($emailTemplates as $t)
                                <tr>
                                    <td>{{ $t->key }}</td>
                                    <td>{{ $t->subject }}</td>
                                    <td><span class="rc-chip {{ $t->is_active ? 'rc-chip-teal' : 'rc-chip-mut' }}">{{ $t->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="3">{{ __('Belum ada data') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-content>
</x-layouts.app>
