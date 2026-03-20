<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, Page $page)
    {
        $isPreview = $request->session()->get("page_preview_ids.{$page->id}") === true;

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
}
