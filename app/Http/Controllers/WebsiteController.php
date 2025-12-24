<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class WebSiteController extends Controller
{

    public function index(): View
    {
        return view('websites.index');
    }
    /**
     * Update the user's profile information.
     */
    public function show(Website $website): View
    {
        return view('websites.show', [
            'website' => $website,
        ]);
    }

}
