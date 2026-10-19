<?php

namespace App\Http\Controllers\Rekrutmen;

use App\Http\Controllers\Controller;
use App\Models\Recruitment\Form;
use Illuminate\Http\Request;

class FormShareController extends Controller
{
    public function show(Form $form)
    {
        $embed = '<iframe src="'.e($form->publicUrl()).'" width="100%" height="700" frameborder="0"></iframe>';

        return view('sdm-dan-payroll.rekrutmen.form.BagikanForm', [
            'form' => $form,
            'embed' => $embed,
            'saveUrl' => route('rekrutmen.form.settings', $form),
        ]);
    }

    public function settings(Request $request, Form $form)
    {
        $data = $request->validate([
            'response_limit' => ['required', 'integer', 'min:0', 'max:100000'],
            'close_at' => ['nullable', 'date'],
            'success_msg' => ['nullable', 'string', 'max:1000'],
        ]);

        $form->update([
            'response_limit' => $data['response_limit'],
            'close_at' => $data['close_at'] ?: null,
            'success_msg' => $data['success_msg'] ?: __('Terima kasih, respons Anda sudah kami terima.'),
        ]);

        return response()->json(['ok' => true, 'message' => __('Pengaturan bagikan tersimpan.')]);
    }
}
