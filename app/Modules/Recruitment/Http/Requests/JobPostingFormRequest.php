<?php

namespace App\Modules\Recruitment\Http\Requests;

use App\Modules\Recruitment\Models\JobRequest;
use Illuminate\Foundation\Http\FormRequest;

abstract class JobPostingFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_request_id' => ['required', 'exists:recruitment_job_requests,id'],
            'title' => ['required', 'string', 'max:255'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'location' => ['nullable', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1', 'max:999'],
            'description' => ['nullable', 'string', 'max:5000'],
            'requirements' => ['nullable', 'string', 'max:5000'],
            'requires_certificate' => ['nullable', 'boolean'],
            'deadline' => ['nullable', 'date', 'after_or_equal:today'],
            'priority' => ['required', 'in:low,normal,high'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $jobRequest = JobRequest::find($this->input('job_request_id'));

            if (!$jobRequest) {
                return;
            }

            if ($jobRequest->status->value !== 'approved') {
                $validator->errors()->add('job_request_id', __('Hanya MPP berstatus Disetujui yang bisa dijadikan lowongan.'));
            }

            if ((int) $this->input('quota') > (int) $jobRequest->quantity) {
                $validator->errors()->add('quota', __('Kuota tidak boleh melebihi jumlah pada MPP :code.', ['code' => $jobRequest->code]));
            }
        });
    }

    public function messages(): array
    {
        return [
            'required' => __(':attribute wajib diisi.'),
            'exists' => __(':attribute tidak valid.'),
            'integer' => __(':attribute harus berupa angka.'),
            'min' => __(':attribute minimal :min.'),
            'max' => __(':attribute maksimal :max.'),
            'string' => __(':attribute tidak valid.'),
            'date' => __(':attribute tidak valid.'),
            'after_or_equal' => __(':attribute tidak boleh sebelum hari ini.'),
            'in' => __(':attribute tidak valid.'),
            'boolean' => __(':attribute tidak valid.'),
        ];
    }

    public function attributes(): array
    {
        return [
            'job_request_id' => __('Permintaan tenaga kerja'),
            'title' => __('Judul lowongan'),
            'department_id' => __('Departemen'),
            'location' => __('Lokasi'),
            'quota' => __('Kuota'),
            'description' => __('Deskripsi'),
            'requirements' => __('Kualifikasi'),
            'deadline' => __('Batas daftar'),
            'priority' => __('Prioritas'),
        ];
    }

    public function postingData(): array
    {
        return $this->safe()->only([
            'job_request_id', 'title', 'department_id', 'location', 'quota',
            'description', 'requirements', 'deadline', 'priority',
        ]) + ['requires_certificate' => $this->boolean('requires_certificate')];
    }
}
