<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Form;
use App\Models\Recruitment\FormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FormBuilderController extends Controller
{
    public function show(Form $form)
    {
        $form->load('fields');

        $payload = [
            'id' => $form->id,
            'title' => $form->title,
            'description' => $form->description,
            'slug' => $form->slug,
            'active' => $form->is_active,
            'saveUrl' => route('rekrutmen.form.update', $form),
            'fields' => $form->fields->map(fn (FormField $f) => [
                'id' => $f->id,
                'type' => $f->type,
                'label' => $f->label,
                'help' => $f->help,
                'options' => $f->options ?? [],
                'file_types' => $f->file_types ?? ['pdf', 'jpg'],
                'max_mb' => $f->max_mb,
                'is_required' => $f->is_required,
            ])->all(),
        ];

        return view('sdm-dan-payroll.rekrutmen.form.EditForm', compact('form', 'payload'));
    }

    public function update(Request $request, Form $form)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'fields' => ['required', 'array'],
            'fields.*.id' => ['nullable', 'integer'],
            'fields.*.type' => ['required', Rule::in(array_keys(FormField::TYPES))],
            'fields.*.label' => ['required', 'string', 'max:500'],
            'fields.*.help' => ['nullable', 'string', 'max:1000'],
            'fields.*.options' => ['nullable', 'array'],
            'fields.*.options.*' => ['string', 'max:255'],
            'fields.*.file_types' => ['nullable', 'array'],
            'fields.*.file_types.*' => [Rule::in(['pdf', 'jpg'])],
            'fields.*.max_mb' => ['nullable', 'integer', 'min:1', 'max:25'],
            'fields.*.is_required' => ['nullable', 'boolean'],
        ]);

        foreach ($data['fields'] as $i => $f) {
            if (in_array($f['type'], ['enum', 'radio', 'check'], true) && empty($f['options'])) {
                return response()->json([
                    'ok' => false,
                    'message' => __('Pertanyaan ":label" butuh minimal satu pilihan.', ['label' => $f['label']]),
                ], 422);
            }
            if ($f['type'] === 'file' && empty($f['file_types'])) {
                $data['fields'][$i]['file_types'] = ['pdf', 'jpg'];
            }
        }

        DB::transaction(function () use ($form, $data) {
            $form->update([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
            ]);

            $keep = [];
            foreach (array_values($data['fields']) as $ord => $f) {
                $attrs = [
                    'type' => $f['type'],
                    'label' => $f['label'],
                    'help' => $f['help'] ?? null,
                    'options' => ! empty($f['options']) ? array_values($f['options']) : null,
                    'file_types' => $f['type'] === 'file' ? ($f['file_types'] ?? ['pdf', 'jpg']) : null,
                    'max_mb' => $f['type'] === 'file' ? ($f['max_mb'] ?? 5) : 5,
                    'is_required' => (bool) ($f['is_required'] ?? false),
                    'ord' => $ord,
                ];

                if (! empty($f['id']) && $field = $form->fields()->find($f['id'])) {
                    $field->update($attrs);
                    $keep[] = $field->id;
                } else {
                    $keep[] = $form->fields()->create($attrs)->id;
                }
            }

            $form->fields()->whereNotIn('id', $keep)->delete();
        });

        return response()->json(['ok' => true, 'message' => __('Perubahan tersimpan.')]);
    }
}
