<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PartnerController extends Controller
{

    public function learn(): View
    {
        $title = 'Learn More - Partner';
        return view('partner.learn-more', [
            'title' => $title,
        ]);
    }

    public function survey(): View
    {
        $title = 'Get Started - Partner';
        return view('partner.get-started', [
            'title' => $title,
        ]);
    }


}