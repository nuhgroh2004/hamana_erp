<x-layouts.app :title="__('Talent Pool')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            @if (session('rc_msg'))
                <div class="rc-flash">{{ session('rc_msg') }}</div>
            @endif
            @if ($errors->any())
                <div class="rc-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="rc-card">
                <div class="rc-bar">
                    <form method="POST" class="rc-filter" action="{{ route('recruitment.talent-pool.add') }}">
                        @csrf
                        <select name="candidate_id" required aria-label="{{ __('Kandidat') }}">
                            <option value="">{{ __('Tambah kandidat…') }}</option>
                            @foreach (\App\Modules\Recruitment\Models\Candidate::where('is_talent_pool', false)->orderBy('name')->get() as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} — {{ $c->city }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="tags" maxlength="500" placeholder="{{ __('Tag (pisahkan koma)') }}" aria-label="{{ __('Tag') }}">
                        <button class="btn1 sm" type="submit"><span class="material-symbols-outlined">person_add</span>{{ __('Masukkan') }}</button>
                    </form>
                    <form method="GET" class="rc-filter">
                        <input type="search" name="q" value="{{ $q }}" placeholder="{{ __('Cari nama, kota, pendidikan…') }}" aria-label="{{ __('Cari') }}">
                        <button class="btn2 sm" type="submit">{{ __('Terapkan') }}</button>
                    </form>
                </div>
                <div class="rc-scroll">
                    <table class="rc-tbl">
                        <thead>
                            <tr>
                                <th>{{ __('Nama') }}</th>
                                <th>{{ __('Kota') }}</th>
                                <th>{{ __('Pendidikan') }}</th>
                                <th>{{ __('Pengalaman') }}</th>
                                <th>{{ __('Tag') }}</th>
                                <th>{{ __('Sumber') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $c)
                                <tr>
                                    <td>{{ $c->name }}</td>
                                    <td>{{ $c->city }}</td>
                                    <td>{{ $c->education }}</td>
                                    <td>{{ $c->experience_years }} {{ __('tahun') }}</td>
                                    <td>
                                        @foreach ($c->talent_tags ?? [] as $tag)
                                            <span class="rc-chip rc-chip-purple">{{ $tag }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $c->source?->name }}</td>
                                    <td>
                                        <div class="rc-actions">
                                            <a class="btn2 sm" href="{{ route('recruitment.candidates.show', $c) }}"><span class="material-symbols-outlined">visibility</span>{{ __('Detail') }}</a>
                                            <form method="POST" action="{{ route('recruitment.talent-pool.remove', $c) }}">
                                                @csrf
                                                <button class="btn2 sm" type="submit" data-confirm="{{ __('Keluarkan dari talent pool?') }}"><span class="material-symbols-outlined">person_remove</span>{{ __('Keluarkan') }}</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7">{{ __('Belum ada data') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $items->links() }}
            </div>
        </div>
    </x-content>
</x-layouts.app>
