<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\Response;

class ApplyUserLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $request->isMethod('get')) {
            $locale = $user->locale ?: 'id';
            $default = LaravelLocalization::getDefaultLocale();

            if ($locale !== $default) {
                $others = array_diff(array_keys(LaravelLocalization::getSupportedLocales()), [$default]);
                $first = $request->segments()[0] ?? '';

                if (!in_array($first, $others, true)) {
                    return redirect(LaravelLocalization::getLocalizedURL($locale, $request->fullUrl()));
                }
            }
        }

        return $next($request);
    }
}
