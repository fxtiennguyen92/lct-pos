<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;


class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            // Set the chosen locale from session
            App::setLocale(Session::get('locale'));
        } else {
            // Set the chosen locale from database
            if (Auth::check() && Auth::user()->locale) {
                App::setLocale(Auth::user()->locale);
            }

            // Get the browser's preferred language from the Accept-Language header
            $browserLanguage = $request->getPreferredLanguage(Language::getLocaleArray());
            if ($browserLanguage) {
                Session::put('locale', $browserLanguage);
                App::setLocale($browserLanguage);
            }
        }

        return $next($request);
    }
}
