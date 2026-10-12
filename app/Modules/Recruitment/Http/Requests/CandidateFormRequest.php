<?php

namespace App\Modules\Recruitment\Http\Requests;

use App\Modules\Recruitment\Models\Candidate;
use Illuminate\Foundation\Http\FormRequest;

class CandidateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'national_id' => ['nullable', 'string', 'max:50'],
            'birth_date' => ['nullable', 'date'],
            'city' => ['nullable', 'string', 'max:255'],
            'education' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:50'],
            'source_id' => ['nullable', 'exists:recruitment_sources,id'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $current = $this->route('candidate');

            $queries = [
                'email' => $this->input('email'),
                'national_id' => $this->input('national_id'),
                'phone' => $this->input('phone'),
            ];

            foreach ($queries as $field => $value) {
                if (!$value) {
                    continue;
                }

                $duplicate = Candidate::where($field, $value)
                    ->when($current instanceof Candidate, fn ($q) => $q->where('id', '!=', $current->id))
                    ->first();

                if ($duplicate) {
                    $validator->errors()->add($field, __('Data ini sudah terdaftar pada kandidat :name.', ['name' => $duplicate->name]));
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'required' => __(':attribute wajib diisi.'),
            'email' => __(':attribute tidak valid.'),
            'exists' => __(':attribute tidak valid.'),
            'integer' => __(':attribute harus berupa angka.'),
            'min' => __(':attribute minimal :min.'),
            'max' => __(':attribute maksimal :max.'),
            'date' => __(':attribute tidak valid.'),
            'string' => __(':attribute tidak valid.'),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('Nama'),
            'email' => 'Email',
            'phone' => __('No. HP'),
            'national_id' => __('No. KTP'),
            'birth_date' => __('Tanggal Lahir'),
            'city' => __('Kota'),
            'education' => __('Pendidikan'),
            'experience_years' => __('Pengalaman (tahun)'),
            'source_id' => __('Sumber kandidat'),
            'notes' => __('Catatan'),
        ];
    }
}
