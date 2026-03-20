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
            $this->grantPreviewAccess($page);

            return redirect()->route('pages.show', $page);
        }

        $isPreview = $page->preview_expires_at?->isFuture() === true;

        if (! $page->is_published && ! $isPreview) {
            abort(404);
        }

        return view('pages.show', [
            'page' => $page,
        ]);
    }

    public function legacyRedirect(Request $request, Page $page)
    {
        $isSignedPreview = $request->boolean('preview') && $request->hasValidSignature();
        $hasPreviewAccess = $page->preview_expires_at?->isFuture() === true;

        if (! $page->is_published && ! $isSignedPreview && ! $hasPreviewAccess) {
            abort(404);
        }

        $redirect = redirect()->route('pages.show', $page, 301);

        if ($isSignedPreview) {
            $this->grantPreviewAccess($page);
        }

        return $redirect;
    }

    private function grantPreviewAccess(Page $page): void
    {
        $page->forceFill([
            'preview_expires_at' => now()->addMinutes(30),
        ])->save();
    }
}
