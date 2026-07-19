<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request, $language)
    {
        if (!auth()->check()) {
            return back();
        }

        if (in_array($language, ['ru', 'en'])) {
            Session::put('locale', $language);
        }

        return back();
    }
}
