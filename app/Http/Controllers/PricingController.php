<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PricingController extends Controller
{

    public function index(): View
    {
        $title = 'Pricing';
        return view('pricing.index', [
            'title' => $title,
        ]);
    }


}
