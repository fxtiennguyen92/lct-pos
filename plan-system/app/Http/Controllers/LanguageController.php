<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(string $locale, Request $request)
    {
        if (in_array($locale, Language::getLocaleArray())) {
            // Store the locale in the session
            App::setLocale($locale);
            Session::put('locale', $locale);
            

            // Save the locale to the database if the user is authenticated
            if (Auth::check()) {
                $user = User::find(Auth::user()->id);
                $user->locale = $locale;
                $user->save();
            }
        }

        return back();
    }
}
