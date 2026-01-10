<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BasicController extends Controller
{

    public function learn(): View
    {
        $title = 'Learn More - Basic';
        return view('basic.learn-more', [
            'title' => $title,
        ]);
    }

    public function survey(): View
    {
        $title = 'Get Started - Basic';
        return view('basic.get-started', [
            'title' => $title,
        ]);
    }



}
