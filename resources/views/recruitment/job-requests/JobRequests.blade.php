<x-layouts.app :title="__('Permintaan Tenaga Kerja (MPP)')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
            @if (session('rc_msg'))
                <div class="rc-flash">{{ session('rc_msg') }}</div>
            @endif
            <div class="rc-card">
                <div class="rc-bar">
                    <a class="btn1 sm" href="{{ route('recruitment.job-requests.create') }}"><span class="material-symbols-outlined">add</span>{{ __('Buat MPP') }}</a>
                    <form method="GET" class="rc-filter">
                        <label class="rc-filter-label" for="jrStatus">{{ __('Status') }}</label>
                        <select id="jrStatus" name="status">
                            <option value="">{{ __('Semua') }}</option>
                            @foreach ($statuses as $s)
                                <option value="{{ $s->value }}"{{ $status === $s->value ? ' selected' : '' }}>{{ $s->label() }}</option>
                            @endforeach
                        </select>
                        <button class="btn2 sm" type="submit">{{ __('Terapkan') }}</button>
                    </form>
                </div>
                <div class="rc-scroll">
                    <table class="rc-tbl">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>{{ __('Departemen') }}</th>
                                <th>{{ __('Jabatan') }}</th>
                                <th>{{ __('Jumlah') }}</th>
                                <th>{{ __('Target Mulai') }}</th>
                                <th>{{ __('Pemohon') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $jr)
                                <tr>
                                    <td>{{ $jr->code }}</td>
                                    <td>{{ $jr->department?->name }}</td>
                                    <td>{{ $jr->position?->name }}</td>
                                    <td>{{ $jr->quantity }}</td>
                                    <td>{{ $jr->target_date?->format('d/m/Y') }}</td>
                                    <td>{{ $jr->requester?->name }}</td>
                                    <td>
                                        <span class="{{ $jr->status->chipClass() }}">{{ $jr->status->label() }}</span>
                                        @if ($jr->approved_at && $jr->notes)
                                            <div class="rc-sub">{{ $jr->approver?->name }} &middot; {{ $jr->approved_at->format('d/m/Y') }} &middot; {{ $jr->notes }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="rc-actions">
                                            @if ($jr->status === \App\Modules\Recruitment\Enums\JobRequestStatus::Pending)
                                                <details class="rc-rev">
                                                    <summary class="btn2 sm"><span class="material-symbols-outlined">how_to_reg</span>{{ __('Tinjau') }}</summary>
                                                    <form method="POST" action="{{ route('recruitment.job-requests.approve', $jr) }}">
                                                        @csrf
                                                        <input type="text" name="notes" maxlength="500" placeholder="{{ __('Catatan approver (opsional)') }}" aria-label="{{ __('Catatan approver (opsional)') }}">
                                                        <button class="btn1 sm" type="submit" name="decision" value="approved">{{ __('Setujui') }}</button>
                                                        <button class="btn2 sm" type="submit" name="decision" value="rejected">{{ __('Tolak') }}</button>
                                                    </form>
                                                </details>
                                                <a class="btn2 sm" href="{{ route('recruitment.job-requests.edit', $jr) }}"><span class="material-symbols-outlined">edit</span>{{ __('Edit') }}</a>
                                                <form method="POST" class="rc-inline" action="{{ route('recruitment.job-requests.cancel', $jr) }}" data-confirm="{{ __('Batalkan permintaan :code?', ['code' => $jr->code]) }}">
                                                    @csrf
                                                    <button class="btn2 sm" type="submit">{{ __('Batalkan') }}</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">{{ __('Belum ada data') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $items->links() }}
            </div>
        </div>
    </x-content>
</x-layouts.app>
