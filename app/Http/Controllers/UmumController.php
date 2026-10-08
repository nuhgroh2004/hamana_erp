<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UmumController extends Controller
{
    public function setLocale(Request $request): RedirectResponse
    {
        $request->validate([
            'locale' => ['required', Rule::in(['id', 'en', 'ja'])],
        ]);

        $request->user()->update(['locale' => $request->locale]);

        return redirect(LaravelLocalization::getLocalizedURL($request->locale, url('pengaturan/umum')));
    }
}
