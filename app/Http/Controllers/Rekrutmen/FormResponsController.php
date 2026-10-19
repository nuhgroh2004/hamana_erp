<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Form;
use App\Models\Recruitment\FormResponse;
use App\Support\RekrutmenData;
use Illuminate\Http\Request;

class FormResponsController extends Controller
{
    public function index(Form $form)
    {
        $form->load('fields');

        $fields = $form->fields->map(fn ($f) => [
            'id' => $f->id,
            'label' => $f->label,
            'type' => $f->type,
        ])->all();

        $responses = $form->responses()
            ->orderByDesc('submitted_at')
            ->orderByDesc('id')
            ->get()
            ->map(fn (FormResponse $r) => [
                'id' => $r->id,
                'waktu' => RekrutmenData::tgl($r->submitted_at),
                'values' => $r->values ?? [],
                'files' => $r->files ?? [],
            ])
            ->all();

        $summary = [];
        foreach ($form->fields->filter(fn ($f) => in_array($f->type, ['enum', 'radio'], true))->take(2) as $f) {
            $counts = array_fill_keys(array_values($f->options ?? []), 0);
            foreach ($responses as $r) {
                $v = $r['values'][(string) $f->id] ?? null;
                if (is_string($v) && array_key_exists($v, $counts)) {
                    $counts[$v]++;
                }
            }
            $summary[] = [
                'label' => $f->label,
                'options' => collect($counts)->map(fn ($c, $o) => ['label' => $o, 'count' => $c])->values()->all(),
            ];
        }

        return view('sdm-dan-payroll.rekrutmen.form.ResponsForm', [
            'form' => $form,
            'fields' => $fields,
            'responses' => $responses,
            'summary' => $summary,
            'exportUrl' => route('rekrutmen.form.export', $form),
            'clearUrl' => route('rekrutmen.form.responses.clear', $form),
        ]);
    }

    public function export(Form $form)
    {
        $form->load('fields');

        $fields = $form->fields->all();
        $labels = array_merge(['Waktu'], array_map(fn ($f) => $f->label, $fields));

        $name = 'respons-'.$form->slug.'.csv';

        return response()->streamDownload(function () use ($form, $fields, $labels) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, $labels, ';');

            $form->responses()->orderBy('submitted_at')->chunk(500, function ($chunk) use ($out, $fields) {
                foreach ($chunk as $r) {
                    $values = $r->values ?? [];
                    $row = [RekrutmenData::tgl($r->submitted_at)];
                    foreach ($fields as $f) {
                        $v = $values[(string) $f->id] ?? '';
                        if (is_array($v)) {
                            $v = implode(', ', $v);
                        }
                        $row[] = (string) $v;
                    }
                    fputcsv($out, $row, ';');
                }
            });

            fclose($out);
        }, $name, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function destroyResponse(Form $form, FormResponse $response)
    {
        abort_unless($response->form_id === $form->id, 404);
        $response->delete();

        return response()->json(['ok' => true, 'message' => __('Respons dihapus.')]);
    }

    public function clearResponses(Form $form)
    {
        $form->responses()->delete();

        return response()->json(['ok' => true, 'message' => __('Semua respons dihapus.')]);
    }
}
