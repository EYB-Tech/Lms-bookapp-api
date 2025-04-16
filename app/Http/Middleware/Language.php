<?php

namespace App\Http\Middleware;

// use App;
use Config;
use Closure;
// use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (LaravelLocalization::setLocale()) {
            $locale = LaravelLocalization::setLocale();
        } else {
            $locale = env('DEFAULT_LANGUAGE', 'en');
        }

        App::setLocale($locale);
        LaravelLocalization::setLocale($locale);
        // $request->session()->put('locale', $locale);

        // $langcode = Session::has('langcode') ? Session::get('langcode') : 'en';
        Carbon::setLocale($locale);

        return $next($request);
    }
}
