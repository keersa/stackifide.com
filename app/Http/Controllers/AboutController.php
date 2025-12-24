<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AboutController extends Controller
{

    public function index(): View
    {
        $title = 'About';
        return view('about.index', [
            'title' => $title,
        ]);
    }


}
