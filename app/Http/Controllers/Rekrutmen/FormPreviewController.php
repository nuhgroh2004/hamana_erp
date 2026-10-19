<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Form;

class FormPreviewController extends Controller
{
    public function show(Form $form)
    {
        $form->load('fields');

        $payload = [
            'title' => $form->title,
            'description' => $form->description,
            'successMsg' => $form->success_msg ?? __('Terima kasih, respons Anda sudah kami terima.'),
            'fields' => $form->fields->map(fn ($f) => [
                'id' => $f->id,
                'type' => $f->type,
                'label' => $f->label,
                'help' => $f->help,
                'options' => $f->options ?? [],
                'file_types' => $f->file_types ?? [],
                'max_mb' => $f->max_mb,
                'required' => $f->is_required,
            ])->all(),
        ];

        return view('sdm-dan-payroll.rekrutmen.form.PreviewForm', compact('form', 'payload'));
    }
}
