<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProController extends Controller
{

    public function learn(): View
    {
        $title = 'Learn More - Pro';
        return view('pro.learn-more', [
            'title' => $title,
        ]);
    }

    public function survey(): View
    {
        $title = 'Get Started - Pro';
        return view('pro.get-started', [
            'title' => $title,
        ]);
    }


}