<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Form;
use App\Support\RekrutmenData;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function index()
    {
        $rows = Form::withCount(['fields', 'responses'])
            ->orderByDesc('updated_at')
            ->get()
            ->map(fn (Form $f) => [
                'id' => $f->id,
                'title' => $f->title,
                'slug' => $f->slug,
                'url' => $f->publicUrl(),
                'active' => $f->is_active,
                'open' => $f->isOpen(),
                'n' => (int) $f->fields_count,
                'rc' => (int) $f->responses_count,
                'edited' => RekrutmenData::tgl($f->updated_at),
                'editUrl' => route('rekrutmen.form.edit', $f),
                'previewUrl' => route('rekrutmen.form.preview', $f),
                'responsUrl' => route('rekrutmen.form.respons', $f),
                'bagikanUrl' => route('rekrutmen.form.bagikan', $f),
                'toggleUrl' => route('rekrutmen.form.toggle', $f),
                'duplicateUrl' => route('rekrutmen.form.duplicate', $f),
                'destroyUrl' => route('rekrutmen.form.destroy', $f),
            ])
            ->all();

        return view('sdm-dan-payroll.rekrutmen.form.DaftarForm', compact('rows'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
        ]);

        $title = ($data['title'] ?? '') !== '' ? $data['title'] : __('Form Tanpa Judul');

        $form = Form::create([
            'title' => $title,
            'description' => null,
            'slug' => Form::makeSlug($title),
            'is_active' => false,
            'success_msg' => __('Terima kasih, respons Anda sudah kami terima.'),
        ]);

        $form->fields()->create([
            'type' => 'text',
            'label' => 'Pertanyaan 1',
            'ord' => 0,
        ]);

        return response()->json([
            'ok' => true,
            'message' => __('Form baru dibuat.'),
            'url' => route('rekrutmen.form.edit', $form),
        ]);
    }

    public function toggle(Form $form)
    {
        $form->update(['is_active' => ! $form->is_active]);

        return response()->json([
            'ok' => true,
            'message' => $form->is_active ? __('Form diaktifkan.') : __('Form dinonaktifkan.'),
            'active' => $form->is_active,
            'open' => $form->isOpen(),
        ]);
    }

    public function duplicate(Form $form)
    {
        $clone = Form::create([
            'title' => $form->title.' (Salinan)',
            'description' => $form->description,
            'slug' => Form::makeSlug($form->title.'-salinan'),
            'is_active' => false,
            'success_msg' => $form->success_msg,
            'response_limit' => $form->response_limit,
            'close_at' => $form->close_at,
        ]);

        foreach ($form->fields()->get() as $f) {
            $clone->fields()->create([
                'type' => $f->type,
                'label' => $f->label,
                'help' => $f->help,
                'options' => $f->options,
                'file_types' => $f->file_types,
                'max_mb' => $f->max_mb,
                'is_required' => $f->is_required,
                'ord' => $f->ord,
            ]);
        }

        return response()->json([
            'ok' => true,
            'message' => __('Form diduplikasi.'),
            'url' => route('rekrutmen.form.edit', $clone),
        ]);
    }

    public function regenerate(Form $form)
    {
        $base = Str::slug($form->title) ?: 'form';
        $slug = $base.'-'.Str::lower(Str::random(4));
        while (Form::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.Str::lower(Str::random(4));
        }
        $form->update(['slug' => $slug]);

        return response()->json([
            'ok' => true,
            'message' => __('Tautan baru dibuat.'),
            'slug' => $slug,
            'url' => $form->publicUrl(),
        ]);
    }

    public function destroy(Form $form)
    {
        $form->delete();

        return response()->json(['ok' => true, 'message' => __('Form dihapus.')]);
    }
}
