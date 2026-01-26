@php
    $page = $page ?? null;
@endphp

<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="meta_title">Meta Title</label>
            <input id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
            @error('meta_title') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="image_alt_text">Image Alt Text</label>
            <input id="image_alt_text" name="image_alt_text" value="{{ old('image_alt_text', $page->image_alt_text ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
            @error('image_alt_text') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="space-y-1">
        <label class="text-sm font-medium text-zinc-900" for="meta_description">Meta Description</label>
        <textarea id="meta_description" name="meta_description" rows="3" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
        @error('meta_description') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="title">Page Title</label>
            <input id="title" name="title" value="{{ old('title', $page->title ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
            @error('title') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="heading_2">Heading 2 (optional)</label>
            <input id="heading_2" name="heading_2" value="{{ old('heading_2', $page->heading_2 ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
            @error('heading_2') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="space-y-1 sm:col-span-2">
            <label class="text-sm font-medium text-zinc-900" for="slug">Slug (optional)</label>
            <input id="slug" name="slug" value="{{ old('slug', $page->slug ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
            @error('slug') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
            <div class="mt-1 text-xs text-zinc-500">URL will be <span class="font-mono">/pages/your-slug</span></div>
        </div>
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="type">Type</label>
            <select id="type" name="type" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">
                <option value="page" @selected(old('type', $page->type ?? 'page') === 'page')>Page</option>
                <option value="post" @selected(old('type', $page->type ?? 'page') === 'post')>Post</option>
            </select>
            @error('type') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="space-y-1">
        <label class="text-sm font-medium text-zinc-900" for="content">Page Description</label>
        <textarea id="content" name="content" rows="12" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">{{ old('content', $page->content ?? '') }}</textarea>
        @error('content') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        <div class="mt-1 text-xs text-zinc-500">You can format this content with the editor toolbar.</div>
    </div>

    <div class="flex items-center gap-3">
        <input id="is_published" type="checkbox" name="is_published" value="1" class="h-4 w-4 rounded border-zinc-300 text-brand-700 focus:ring-brand-400/40" @checked((bool) old('is_published', $page->is_published ?? false)) />
        <label for="is_published" class="text-sm text-zinc-700">Publish</label>
        @error('is_published') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
    </div>
</div>

