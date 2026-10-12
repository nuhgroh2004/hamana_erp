<?php

namespace App\Modules\Recruitment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class JobRequestFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],
            'position_id' => ['required', 'exists:positions,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
            'reason' => ['required', 'string', 'max:1000'],
            'target_date' => ['required', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => __(':attribute wajib diisi.'),
            'exists' => __(':attribute tidak valid.'),
            'integer' => __(':attribute harus berupa angka.'),
            'min' => __(':attribute minimal :min.'),
            'max' => __(':attribute maksimal :max.'),
            'date' => __(':attribute tidak valid.'),
            'after_or_equal' => __(':attribute tidak boleh sebelum hari ini.'),
            'string' => __(':attribute tidak valid.'),
        ];
    }

    public function attributes(): array
    {
        return [
            'department_id' => __('Departemen'),
            'position_id' => __('Jabatan'),
            'quantity' => __('Jumlah'),
            'reason' => __('Alasan'),
            'target_date' => __('Target Mulai'),
            'notes' => __('Catatan'),
        ];
    }
}
