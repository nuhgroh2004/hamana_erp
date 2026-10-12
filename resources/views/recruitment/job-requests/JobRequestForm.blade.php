<x-layouts.app :title="$item ? __('Ubah MPP') : __('Buat MPP')">
    <x-sidebar />
    <x-content :boxed="false">
        <div class="rc-dash">
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
                <div class="rc-card-title">{{ $item ? __('Ubah MPP :code', ['code' => $item->code]) : __('Buat MPP') }}</div>
                <form method="POST" class="rc-form" action="{{ $item ? route('recruitment.job-requests.update', $item) : route('recruitment.job-requests.store') }}">
                    @csrf
                    @if ($item)
                        @method('PUT')
                    @endif
                    <div class="rc-f">
                        <label for="department_id">{{ __('Departemen') }}</label>
                        <select id="department_id" name="department_id" required>
                            <option value="">{{ __('Pilih departemen') }}</option>
                            @foreach ($departments as $d)
                                <option value="{{ $d->id }}"{{ (string) old('department_id', $item?->department_id) === (string) $d->id ? ' selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="rc-f">
                        <label for="position_id">{{ __('Jabatan') }}</label>
                        <select id="position_id" name="position_id" required>
                            <option value="">{{ __('Pilih jabatan') }}</option>
                            @foreach ($positions as $p)
                                <option value="{{ $p->id }}"{{ (string) old('position_id', $item?->position_id) === (string) $p->id ? ' selected' : '' }}>{{ $p->name }}{{ $p->department ? ' — '.$p->department->name : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="rc-f">
                        <label for="quantity">{{ __('Jumlah') }}</label>
                        <input id="quantity" type="number" name="quantity" min="1" max="999" required value="{{ old('quantity', $item?->quantity ?? 1) }}">
                    </div>
                    <div class="rc-f">
                        <label for="target_date">{{ __('Target Mulai') }}</label>
                        <input id="target_date" type="date" name="target_date" required value="{{ old('target_date', $item?->target_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="rc-f rc-full">
                        <label for="reason">{{ __('Alasan') }}</label>
                        <textarea id="reason" name="reason" maxlength="1000" required>{{ old('reason', $item?->reason) }}</textarea>
                    </div>
                    <div class="rc-f rc-full">
                        <label for="notes">{{ __('Catatan') }}</label>
                        <textarea id="notes" name="notes" maxlength="500">{{ old('notes', $item?->notes) }}</textarea>
                    </div>
                    <div class="rc-form-acts">
                        <button class="btn1 sm" type="submit"><span class="material-symbols-outlined">save</span>{{ __('Simpan') }}</button>
                        <a class="btn2 sm" href="{{ route('recruitment.job-requests') }}">{{ __('Batal') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </x-content>
</x-layouts.app>
