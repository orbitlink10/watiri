<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, Page $page)
    {
        $isSignedPreview = $request->boolean('preview') && $request->hasValidSignature();

        if ($isSignedPreview) {
            $request->session()->put("page_preview_ids.{$page->id}", true);

            return redirect()->route('pages.show', $page)
                ->cookie($this->previewCookieName($page), '1', 30);
        }

        $isPreview = $request->session()->get("page_preview_ids.{$page->id}") === true
            || $request->cookie($this->previewCookieName($page)) === '1';

        if (! $page->is_published && ! $isPreview) {
            abort(404);
        }

        return view('pages.show', [
            'page' => $page,
        ]);
    }

    public function legacyRedirect(Page $page)
    {
        if (! $page->is_published) {
            abort(404);
        }

        return redirect()->route('pages.show', $page, 301);
    }

    private function previewCookieName(Page $page): string
    {
        return 'page_preview_'.$page->id;
    }
}
