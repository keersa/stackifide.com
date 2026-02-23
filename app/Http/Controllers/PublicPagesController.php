<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Event;
use App\Models\Faq;
use App\Models\GolfCourse;
use App\Models\GolfCourseFacility;
use App\Models\EventCause;

class PublicPagesController extends Controller
{


    /**
     * Display the about page.
     */
    public function about()
    {
        $title = 'About Stackifide';
        return view('about', compact('title'));
    }


    /**
     * Display the about page.
     */
    public function contact()
    {
        $title = 'Contact Stackifide';
        return view('contact', compact('title'));
    }


    public function pricing(): View
    {
        $title = 'Stackifide Pricing';
        return view('pricing', compact('title'));
    }


    /**
     * Display the FAQs page.
     */
    public function faqs()
    {
        $title = 'Frequently Asked Questions';
        $categories = Faq::getCategories();
        $faqs = Faq::ordered()->get();

        return view('faqs', [
            'title' => $title,
            'categories' => $categories,
            'faqs' => $faqs,
        ]);
    }

    /**
     * Display the upgrades page.
     */
    public function upgrades()
    {


        $title = 'Stackifide Upgrades';
        return view('upgrades', compact('title'));
    }

   

}
