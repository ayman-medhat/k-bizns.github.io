<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Update the application locale.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'locale' => 'required|in:en,ar',
        ]);

        session(['locale' => $request->input('locale')]);

        return redirect()->back();
    }
}
