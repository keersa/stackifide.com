<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $categories = Faq::getCategories();
        $faqsByCategory = Faq::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->groupBy('category');

        // Ensure every category has a key (even if empty)
        $grouped = [];
        foreach ($categories as $cat) {
            $grouped[$cat['slug']] = [
                'label' => $cat['label'],
                'faqs' => $faqsByCategory->get($cat['slug'], collect())->values(),
            ];
        }

        return view('super-admin.faqs.index', [
            'grouped' => $grouped,
            'categories' => $categories,
        ]);
    }

    public function reorder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'in:getting-started,plans-pricing,features-support,technical'],
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:faqs,id'],
        ]);

        $category = $validated['category'];
        $order = $validated['order'];

        // Ensure we only update FAQs that belong to this category
        $faqs = Faq::where('category', $category)->whereIn('id', $order)->get()->keyBy('id');
        foreach ($order as $position => $id) {
            if (isset($faqs[$id])) {
                $faqs[$id]->update(['sort_order' => $position]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function create(): View
    {
        return view('super-admin.faqs.create', [
            'categories' => Faq::getCategories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:64', 'in:getting-started,plans-pricing,features-support,technical'],
            'question' => ['required', 'string', 'max:1000'],
            'answer' => ['required', 'string', 'max:5000'],
        ]);

        $maxOrder = (int) Faq::where('category', $validated['category'])->max('sort_order');
        Faq::create([
            'category' => $validated['category'],
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'sort_order' => $maxOrder + 1,
        ]);

        return redirect()->route('super-admin.faqs.index')
            ->with('success', 'FAQ created.');
    }

    public function edit(Faq $faq): View
    {
        return view('super-admin.faqs.edit', [
            'faq' => $faq,
            'categories' => Faq::getCategories(),
        ]);
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:64', 'in:getting-started,plans-pricing,features-support,technical'],
            'question' => ['required', 'string', 'max:1000'],
            'answer' => ['required', 'string', 'max:5000'],
        ]);

        $faq->update([
            'category' => $validated['category'],
            'question' => $validated['question'],
            'answer' => $validated['answer'],
        ]);

        return redirect()->route('super-admin.faqs.index')
            ->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();
        return redirect()->route('super-admin.faqs.index')
            ->with('success', 'FAQ deleted.');
    }
}
