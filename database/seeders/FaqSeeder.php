<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['category' => 'getting-started', 'question' => 'What services do you offer for restaurants?', 'answer' => 'We offer comprehensive web solutions for restaurants including custom websites, menu management systems, online ordering platforms, kitchen notification systems, analytics, SEO optimization, and social media integration.', 'sort_order' => 0],
            ['category' => 'getting-started', 'question' => 'How long does it take to set up a website?', 'answer' => 'The setup time varies depending on the package you choose. Basic packages typically take 1-2 weeks, while Pro packages with additional features may take 2-4 weeks. Custom Enterprise solutions are tailored to your specific needs and timeline.', 'sort_order' => 1],
            ['category' => 'plans-pricing', 'question' => 'What payment methods do you accept?', 'answer' => 'We accept all major credit cards, bank transfers, and can set up custom payment plans for Enterprise clients. Monthly subscriptions are billed automatically.', 'sort_order' => 0],
            ['category' => 'plans-pricing', 'question' => 'Is there a contract or can I cancel anytime?', 'answer' => 'Our Basic and Pro plans are month-to-month with no long-term contracts. You can cancel anytime with 30 days notice. Enterprise partnerships may have custom terms based on the scope of work.', 'sort_order' => 1],
            ['category' => 'features-support', 'question' => 'Do you provide hosting services?', 'answer' => 'Yes, hosting is included in both our Basic and Pro packages. We handle all the technical aspects of hosting, including security updates, backups, and performance optimization.', 'sort_order' => 0],
            ['category' => 'features-support', 'question' => 'Can I update my menu myself?', 'answer' => 'Absolutely! Our menu management system includes an easy-to-use admin panel where you can update menu items, prices, descriptions, and images without any technical knowledge.', 'sort_order' => 1],
            ['category' => 'features-support', 'question' => 'Do you offer support after setup?', 'answer' => 'Yes! All packages include ongoing support. Basic includes email support, Pro includes priority email and phone support, and Enterprise includes dedicated account management.', 'sort_order' => 2],
            ['category' => 'technical', 'question' => 'Can I integrate with my existing POS system?', 'answer' => 'Yes, we can integrate with most major POS systems. This is typically available in our Pro and Enterprise packages. Contact us to discuss your specific POS system requirements.', 'sort_order' => 0],
        ];

        foreach ($faqs as $item) {
            Faq::firstOrCreate(
                ['question' => $item['question']],
                ['category' => $item['category'], 'answer' => $item['answer'], 'sort_order' => $item['sort_order']]
            );
        }
    }
}
