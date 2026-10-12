<x-layouts.app :title="__('Detail Kandidat')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            @if (session('rc_msg'))
                <div class="rc-flash">{{ session('rc_msg') }}</div>
            @endif
            <div class="rc-card">
                <div class="rc-bar">
                    <div>
                        <div class="rc-card-title">{{ $item->name }}</div>
                        <div class="rc-sub">{{ $item->email }} &middot; {{ $item->phone }} &middot; {{ $item->city }}</div>
                    </div>
                    <div class="rc-actions">
                        <a class="btn2 sm" href="{{ route('recruitment.candidates.edit', $item) }}"><span class="material-symbols-outlined">edit</span>{{ __('Edit') }}</a>
                        <a class="btn2 sm" href="{{ route('recruitment.candidates') }}"><span class="material-symbols-outlined">arrow_back</span>{{ __('Kembali') }}</a>
                    </div>
                </div>
                <div class="rc-grid3">
                    <div>
                        <div class="rc-sub-title">{{ __('Profil') }}</div>
                        <table class="rc-tbl">
                            <tr><th>{{ __('No. KTP') }}</th><td>{{ $item->national_id }}</td></tr>
                            <tr><th>{{ __('Tanggal Lahir') }}</th><td>{{ $item->birth_date?->format('d/m/Y') }}</td></tr>
                            <tr><th>{{ __('Pendidikan') }}</th><td>{{ $item->education }}</td></tr>
                            <tr><th>{{ __('Pengalaman') }}</th><td>{{ $item->experience_years }} {{ __('tahun') }}</td></tr>
                            <tr><th>{{ __('Sumber') }}</th><td>{{ $item->source?->name }}</td></tr>
                            <tr><th>{{ __('Catatan') }}</th><td>{{ $item->notes }}</td></tr>
                        </table>
                    </div>
                    <div>
                        <div class="rc-sub-title">{{ __('Dokumen') }}</div>
                        <table class="rc-tbl">
                            <tbody>
                                @forelse ($item->documents as $doc)
                                    <tr>
                                        <td>{{ \App\Modules\Recruitment\Enums\DocumentType::tryFrom($doc->type)?->label() ?? $doc->type }}</td>
                                        <td>{{ $doc->original_name }}</td>
                                        <td>
                                            <a class="btn2 sm" href="{{ route('recruitment.candidates.documents.download', [$item, $doc]) }}"><span class="material-symbols-outlined">download</span>{{ __('Unduh') }}</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td>{{ __('Belum ada data') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        <form method="POST" class="rc-upload" action="{{ route('recruitment.candidates.documents.store', $item) }}" enctype="multipart/form-data">
                            @csrf
                            <select name="type" aria-label="{{ __('Jenis dokumen') }}">
                                <option value="cv">CV</option>
                                <option value="ktp">KTP</option>
                                <option value="ijazah">{{ __('Ijazah') }}</option>
                                <option value="sertifikat">{{ __('Sertifikat') }}</option>
                            </select>
                            <input type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <button class="btn1 sm" type="submit">{{ __('Unggah') }}</button>
                        </form>
                        @if ($errors->any())
                            <div class="rc-errors">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="rc-sub-title">{{ __('Lamaran') }}</div>
                        @forelse ($item->applications as $app)
                            <div class="rc-block">
                                <div>
                                    <strong>{{ $app->jobPosting?->title }}</strong>
                                    <span class="{{ $app->status->chipClass() }}">{{ $app->status->label() }}</span>
                                </div>
                                <div class="rc-sub">{{ __('Tahap') }}: {{ $app->currentStage?->name }} &middot; {{ $app->applied_at?->format('d/m/Y') }}</div>
                            </div>
                        @empty
                            <div class="rc-block">{{ __('Belum ada data') }}</div>
                        @endforelse
                    </div>
                </div>
                <div class="rc-grid3">
                    <div>
                        <div class="rc-sub-title">{{ __('Riwayat Tahap') }}</div>
                        @php $logs = collect($item->applications)->flatMap->stageLogs->sortByDesc('created_at'); @endphp
                        @forelse ($logs as $log)
                            <div class="rc-block">
                                <div>{{ $log->fromStage?->name }} &rarr; {{ $log->toStage?->name }}</div>
                                <div class="rc-sub">{{ $log->changer?->name ?? __('Sistem') }} &middot; {{ $log->created_at?->format('d/m/Y H:i') }}{{ $log->reason ? ' &middot; '.$log->reason : '' }}</div>
                            </div>
                        @empty
                            <div class="rc-block">{{ __('Belum ada aktivitas.') }}</div>
                        @endforelse
                    </div>
                    <div>
                        <div class="rc-sub-title">{{ __('Hasil Tes') }}</div>
                        @php $assessments = collect($item->applications)->flatMap->assessments->sortByDesc('assessed_at'); @endphp
                        @forelse ($assessments as $a)
                            <div class="rc-block">
                                <div>{{ $a->type }} — {{ $a->score }} <span class="{{ $a->passed ? 'rc-chip rc-chip-teal' : 'rc-chip rc-chip-red' }}">{{ $a->passed ? __('Lulus') : __('Tidak Lulus') }}</span></div>
                                <div class="rc-sub">{{ $a->assessor?->name }} &middot; {{ $a->assessed_at?->format('d/m/Y') }}{{ $a->notes ? ' &middot; '.$a->notes : '' }}</div>
                            </div>
                        @empty
                            <div class="rc-block">{{ __('Belum ada data') }}</div>
                        @endforelse
                    </div>
                    <div>
                        <div class="rc-sub-title">{{ __('Interview') }}</div>
                        @php $interviews = collect($item->applications)->flatMap->interviews->sortBy('scheduled_at'); @endphp
                        @forelse ($interviews as $iv)
                            <div class="rc-block">
                                <div>{{ $iv->type === 'hr' ? __('Interview HR') : __('Interview User') }} — {{ $iv->scheduled_at?->format('d/m/Y H:i') }}</div>
                                <div class="rc-sub">{{ $iv->location }} &middot; {{ $iv->status }}{{ $iv->recommendation ? ' &middot; '.$iv->recommendation : '' }}</div>
                            </div>
                        @empty
                            <div class="rc-block">{{ __('Belum ada data') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </x-content>
</x-layouts.app>
