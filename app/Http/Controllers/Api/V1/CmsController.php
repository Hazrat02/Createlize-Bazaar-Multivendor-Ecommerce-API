<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Page;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function page(string $key)
    {
        $page = Page::query()->where('key', $key)->firstOrFail();
        return response()->json(['key'=>$page->key,'title'=>$page->title,'content'=>$page->content]);
    }

    public function faqs()
    {
        return response()->json(Faq::query()->where('is_active', true)->orderBy('sort_order')->get());
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'email' => ['nullable','email','max:190'],
            'message' => ['required','string','max:2000'],
        ]);

        ContactMessage::create($data);

        return response()->json(['ok'=>true]);
    }
}
