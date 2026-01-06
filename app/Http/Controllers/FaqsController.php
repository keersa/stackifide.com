<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class FaqsController extends Controller
{

    public function index(): View
    {
        $title = 'Frequently Asked Questions';
        
        $faqs = [
            [
                'question' => 'What services do you offer for restaurants?',
                'answer' => 'We offer comprehensive web solutions for restaurants including custom websites, menu management systems, online ordering platforms, kitchen notification systems, analytics, SEO optimization, and social media integration.',
            ],
            [
                'question' => 'How long does it take to set up a website?',
                'answer' => 'The setup time varies depending on the package you choose. Basic packages typically take 1-2 weeks, while Pro packages with additional features may take 2-4 weeks. Custom Enterprise solutions are tailored to your specific needs and timeline.',
            ],
            [
                'question' => 'Do you provide hosting services?',
                'answer' => 'Yes, hosting is included in both our Basic and Pro packages. We handle all the technical aspects of hosting, including security updates, backups, and performance optimization.',
            ],
            [
                'question' => 'Can I update my menu myself?',
                'answer' => 'Absolutely! Our menu management system includes an easy-to-use admin panel where you can update menu items, prices, descriptions, and images without any technical knowledge.',
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept all major credit cards, bank transfers, and can set up custom payment plans for Enterprise clients. Monthly subscriptions are billed automatically.',
            ],
            [
                'question' => 'Is there a contract or can I cancel anytime?',
                'answer' => 'Our Basic and Pro plans are month-to-month with no long-term contracts. You can cancel anytime with 30 days notice. Enterprise partnerships may have custom terms based on the scope of work.',
            ],
            [
                'question' => 'Do you offer support after setup?',
                'answer' => 'Yes! All packages include ongoing support. Basic includes email support, Pro includes priority email and phone support, and Enterprise includes dedicated account management.',
            ],
            [
                'question' => 'Can I integrate with my existing POS system?',
                'answer' => 'Yes, we can integrate with most major POS systems. This is typically available in our Pro and Enterprise packages. Contact us to discuss your specific POS system requirements.',
            ],
        ];
        
        return view('faqs.index', [
            'title' => $title,
            'faqs' => $faqs,
        ]);
    }


}
