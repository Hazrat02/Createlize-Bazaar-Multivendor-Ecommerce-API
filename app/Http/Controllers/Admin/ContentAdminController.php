<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContentAdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Content/Index', [
            'pages' => Page::query()->orderBy('key')->get(),
            'faqs' => Faq::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function savePages(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'pages' => ['required','array'],
            'pages.*.key' => ['required','string','max:50'],
            'pages.*.title' => ['nullable','string','max:255'],
            'pages.*.content' => ['nullable','string'],
        ]);

        foreach ($data['pages'] as $p) {
            Page::query()->updateOrCreate(
                ['key' => $p['key']],
                ['title' => $p['title'] ?? null, 'content' => $p['content'] ?? null]
            );
        }

        return back()->with('success','Pages saved');
    }

    public function saveFaqs(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'faqs' => ['required','array'],
            'faqs.*.question' => ['required','string','max:255'],
            'faqs.*.answer' => ['required','string'],
            'faqs.*.sort_order' => ['nullable','integer','min:0'],
        ]);

        Faq::query()->delete();
        foreach ($data['faqs'] as $i => $f) {
            Faq::create([
                'question' => $f['question'],
                'answer' => $f['answer'],
                'sort_order' => $f['sort_order'] ?? $i,
            ]);
        }

        return back()->with('success','FAQs saved');
    }
}
