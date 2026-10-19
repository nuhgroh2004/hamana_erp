<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Form;
use App\Models\Recruitment\FormField;
use App\Models\Recruitment\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormPublicController extends Controller
{
    public function show(string $slug)
    {
        $form = Form::with('fields')->where('slug', $slug)->firstOrFail();

        if (! $form->isOpen()) {
            return view('sdm-dan-payroll.rekrutmen.form.PublicClosed', [
                'form' => $form,
                'reason' => $form->is_active
                    ? ($form->close_at && $form->close_at->isPast() ? 'closed' : 'full')
                    : 'inactive',
            ]);
        }

        $payload = [
            'title' => $form->title,
            'slug' => $form->slug,
            'description' => $form->description,
            'successMsg' => $form->success_msg ?? __('Terima kasih, respons Anda sudah kami terima.'),
            'submitUrl' => route('rekrutmen.form.public.submit', $form->slug),
            'fields' => $form->fields->map(fn (FormField $f) => [
                'id' => $f->id,
                'type' => $f->type,
                'label' => $f->label,
                'help' => $f->help,
                'options' => $f->options ?? [],
                'file_types' => $f->file_types ?? ['pdf', 'jpg'],
                'max_mb' => $f->max_mb,
                'required' => $f->is_required,
            ])->all(),
        ];

        return view('sdm-dan-payroll.rekrutmen.form.PublicForm', ['payload' => $payload]);
    }

    public function submit(Request $request, string $slug)
    {
        $form = Form::with('fields')->where('slug', $slug)->firstOrFail();

        if (! $form->isOpen()) {
            return response()->json(['ok' => false, 'message' => __('Form ini sudah tidak menerima respons.')], 422);
        }

        $files = [];
        $values = [];

        foreach ($form->fields as $field) {
            $key = 'f_'.$field->id;
            $required = $field->is_required;

            if ($field->type === 'file') {
                if (! $request->hasFile($key)) {
                    if ($required) {
                        return response()->json(['ok' => false, 'message' => __('Kolom ":label" wajib diisi.', ['label' => $field->label])], 422);
                    }
                    continue;
                }

                $file = $request->file($key);
                $ext = strtolower($file->getClientOriginalExtension());
                $allowed = $field->file_types ?: ['pdf', 'jpg'];

                $okExt = $ext === 'pdf' ? in_array('pdf', $allowed, true)
                    : (in_array($ext, ['jpg', 'jpeg'], true) && in_array('jpg', $allowed, true));

                if (! $okExt) {
                    return response()->json(['ok' => false, 'message' => __('Format file ":label" harus :ext.', ['label' => $field->label, 'ext' => implode(' / ', $allowed)])], 422);
                }
                if ($file->getSize() > $field->max_mb * 1024 * 1024) {
                    return response()->json(['ok' => false, 'message' => __('Ukuran file ":label" maksimal :mb MB.', ['label' => $field->label, 'mb' => $field->max_mb])], 422);
                }

                $path = $file->store('recruitment-forms/'.$form->id, 'public');
                $files[(string) $field->id] = $path;
                $values[(string) $field->id] = $file->getClientOriginalName();
                continue;
            }

            $raw = $request->input($key);

            switch ($field->type) {
                case 'check':
                    $val = is_array($raw) ? array_values(array_filter($raw, 'is_string')) : [];
                    if ($required && ! $val) {
                        return response()->json(['ok' => false, 'message' => __('Kolom ":label" wajib diisi.', ['label' => $field->label])], 422);
                    }
                    $values[(string) $field->id] = $val;
                    break;

                case 'num':
                    if (($required || $raw !== null) && $raw !== null && ! is_numeric($raw)) {
                        return response()->json(['ok' => false, 'message' => __('Kolom ":label" harus angka.', ['label' => $field->label])], 422);
                    }
                    if ($required && ($raw === null || $raw === '')) {
                        return response()->json(['ok' => false, 'message' => __('Kolom ":label" wajib diisi.', ['label' => $field->label])], 422);
                    }
                    $values[(string) $field->id] = $raw === null || $raw === '' ? null : $raw;
                    break;

                case 'date':
                    if ($required && ($raw === null || $raw === '')) {
                        return response()->json(['ok' => false, 'message' => __('Kolom ":label" wajib diisi.', ['label' => $field->label])], 422);
                    }
                    if ($raw) {
                        try {
                            $raw = \Carbon\Carbon::parse($raw)->format('Y-m-d');
                        } catch (\Throwable $e) {
                            return response()->json(['ok' => false, 'message' => __('Kolom ":label" harus berupa tanggal yang valid.', ['label' => $field->label])], 422);
                        }
                    }
                    $values[(string) $field->id] = $raw ?: null;
                    break;

                case 'enum':
                case 'radio':
                    if ($required && ($raw === null || $raw === '')) {
                        return response()->json(['ok' => false, 'message' => __('Kolom ":label" wajib diisi.', ['label' => $field->label])], 422);
                    }
                    if ($raw !== null && $raw !== '' && ! in_array($raw, $field->options ?? [], true)) {
                        return response()->json(['ok' => false, 'message' => __('Pilihan tidak valid untuk ":label".', ['label' => $field->label])], 422);
                    }
                    $values[(string) $field->id] = $raw ?: null;
                    break;

                default:
                    $raw = is_string($raw) ? trim($raw) : $raw;
                    if ($required && ($raw === null || $raw === '')) {
                        return response()->json(['ok' => false, 'message' => __('Kolom ":label" wajib diisi.', ['label' => $field->label])], 422);
                    }
                    $values[(string) $field->id] = $raw === '' ? null : $raw;
            }
        }

        FormResponse::create([
            'form_id' => $form->id,
            'submitted_at' => now(),
            'values' => $values,
            'files' => $files ?: null,
        ]);

        return response()->json([
            'ok' => true,
            'message' => $form->success_msg ?? __('Terima kasih, respons Anda sudah kami terima.'),
        ]);
    }
}
