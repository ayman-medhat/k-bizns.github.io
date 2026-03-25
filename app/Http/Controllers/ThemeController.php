<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:royal,majestic,azure,night',
        ]);

        session(['theme' => $request->theme]);

        return back();
    }
}
