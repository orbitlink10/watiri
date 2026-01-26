<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $pagesQuery = Page::query()->latest();

        if ($request->filled('type')) {
            $pagesQuery->where('type', $request->string('type')->toString());
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $pagesQuery->where('title', 'like', "%{$q}%");
        }

        $pages = $pagesQuery->paginate(20)->withQueryString();

        return view('admin.pages.index', [
            'pages' => $pages,
            'type' => $request->string('type')->toString(),
            'q' => $request->string('q')->toString(),
        ]);
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $slug = $this->uniqueSlug($validated['slug'] ?: $validated['title']);

        $page = Page::create([
            'type' => $validated['type'],
            'title' => $validated['title'],
            'slug' => $slug,
            'meta_title' => $validated['meta_title'] ?: null,
            'meta_description' => $validated['meta_description'] ?: null,
            'image_alt_text' => $validated['image_alt_text'] ?: null,
            'heading_2' => $validated['heading_2'] ?: null,
            'content' => $validated['content'] ?: null,
            'is_published' => (bool) $validated['is_published'],
            'published_at' => $validated['is_published'] ? now() : null,
        ]);

        return redirect()->route('admin.pages.edit', $page)->with('status', 'Page created.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', [
            'page' => $page,
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $validated = $this->validated($request);

        $slug = $this->uniqueSlug($validated['slug'] ?: $validated['title'], $page->id);
        $isPublished = (bool) $validated['is_published'];

        $page->update([
            'type' => $validated['type'],
            'title' => $validated['title'],
            'slug' => $slug,
            'meta_title' => $validated['meta_title'] ?: null,
            'meta_description' => $validated['meta_description'] ?: null,
            'image_alt_text' => $validated['image_alt_text'] ?: null,
            'heading_2' => $validated['heading_2'] ?: null,
            'content' => $validated['content'] ?: null,
            'is_published' => $isPublished,
            'published_at' => $isPublished ? ($page->published_at ?: now()) : null,
        ]);

        return redirect()->route('admin.pages.index')->with('status', 'Page updated.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('status', 'Page deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:page,post'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:5000'],
            'image_alt_text' => ['nullable', 'string', 'max:255'],
            'heading_2' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:200000'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value);
        $slug = $base !== '' ? $base : Str::lower(Str::random(8));
        $counter = 2;

        while (Page::query()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}

