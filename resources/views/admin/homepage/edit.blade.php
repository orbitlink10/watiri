@extends('layouts.admin')

@section('title', 'Homepage content — Admin')

@php
    $v = $values ?? [];
@endphp

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="text-sm uppercase tracking-[0.2em] text-zinc-500">Homepage</div>
            <h1 class="text-2xl font-semibold leading-tight text-zinc-900 font-serif">Edit homepage content</h1>
        </div>
    </div>

    <form method="post" action="{{ route('admin.homepage.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid gap-4 lg:grid-cols-2">
            <div class="space-y-3 rounded-2xl bg-white p-6 watiri-ring">
                <div class="text-sm font-semibold text-zinc-900">SEO</div>
                <div class="space-y-1">
                    <label class="text-sm text-zinc-700" for="seo_title">Meta title</label>
                    <input id="seo_title" name="seo_title" value="{{ old('seo_title', $v['seo_title'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                    @error('seo_title') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-sm text-zinc-700" for="seo_description">Meta description</label>
                    <textarea id="seo_description" name="seo_description" rows="3" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">{{ old('seo_description', $v['seo_description'] ?? '') }}</textarea>
                    @error('seo_description') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="space-y-3 rounded-2xl bg-white p-6 watiri-ring">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-semibold text-zinc-900">Hero image</div>
                    @if (! empty($homeContent?->hero_image_path))
                        <a class="text-xs text-zinc-600 hover:text-zinc-900" href="{{ Storage::disk('public')->url($homeContent->hero_image_path) }}" target="_blank" rel="noreferrer">View current</a>
                    @endif
                </div>
                <label class="inline-flex items-center gap-3 rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800 cursor-pointer">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                        <path d="M12 16v-5m0 0V7m0 4h4m-4 0H8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M4 12a8 8 0 1 0 16 0 8 8 0 0 0-16 0Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                    </svg>
                    <span>Select image</span>
                    <input id="hero_image" type="file" name="hero_image" accept="image/*" class="hidden" onchange="document.getElementById('hero_image_name').textContent = this.files?.[0]?.name || 'No file chosen';" />
                </label>
                <div id="hero_image_name" class="text-sm text-zinc-700">No file chosen</div>
                <div class="text-xs text-zinc-500">JPEG/PNG up to 4MB. Recommended aspect: portrait/illustration similar to current hero.</div>
                @error('hero_image') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 watiri-ring space-y-4">
            <div class="text-sm font-semibold text-zinc-900">Hero copy</div>
            <div class="grid gap-4 md:grid-cols-3">
                <div class="space-y-1">
                    <label class="text-sm text-zinc-700" for="hero_badge">Badge text</label>
                    <input id="hero_badge" name="hero_badge" value="{{ old('hero_badge', $v['hero_badge'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                    @error('hero_badge') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="space-y-1 md:col-span-2">
                    <label class="text-sm text-zinc-700" for="hero_heading">Heading</label>
                    <input id="hero_heading" name="hero_heading" value="{{ old('hero_heading', $v['hero_heading'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                    @error('hero_heading') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="space-y-1 md:col-span-2">
                    <label class="text-sm text-zinc-700" for="hero_heading_highlight">Highlighted phrase</label>
                    <input id="hero_heading_highlight" name="hero_heading_highlight" value="{{ old('hero_heading_highlight', $v['hero_heading_highlight'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                    @error('hero_heading_highlight') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="space-y-1 md:col-span-3">
                    <label class="text-sm text-zinc-700" for="hero_description">Intro paragraph</label>
                    <textarea id="hero_description" name="hero_description" rows="3" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">{{ old('hero_description', $v['hero_description'] ?? '') }}</textarea>
                    @error('hero_description') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-2 rounded-xl bg-champagne-50 p-4 ring-1 ring-champagne-200/70">
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-champagne-900">Primary CTA</div>
                    <div class="space-y-1">
                        <label class="text-sm text-zinc-700" for="hero_primary_label">Label</label>
                        <input id="hero_primary_label" name="hero_primary_label" value="{{ old('hero_primary_label', $v['hero_primary_label'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                        @error('hero_primary_label') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm text-zinc-700" for="hero_primary_link">Link</label>
                        <input id="hero_primary_link" name="hero_primary_link" value="{{ old('hero_primary_link', $v['hero_primary_link'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" placeholder="/shop" />
                        @error('hero_primary_link') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="space-y-2 rounded-xl bg-white p-4 ring-1 ring-zinc-200/70">
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-700">Secondary CTA</div>
                    <div class="space-y-1">
                        <label class="text-sm text-zinc-700" for="hero_secondary_label">Label</label>
                        <input id="hero_secondary_label" name="hero_secondary_label" value="{{ old('hero_secondary_label', $v['hero_secondary_label'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                        @error('hero_secondary_label') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm text-zinc-700" for="hero_secondary_link">Link</label>
                        <input id="hero_secondary_link" name="hero_secondary_link" value="{{ old('hero_secondary_link', $v['hero_secondary_link'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" placeholder="#consult" />
                        @error('hero_secondary_link') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div class="space-y-1 md:col-span-3">
                    <div class="text-sm font-semibold text-zinc-900">Delivery points</div>
                    <div class="grid gap-3 md:grid-cols-3">
                        @for ($i = 0; $i < 3; $i++)
                            <div>
                                <input name="delivery_points[]" value="{{ old('delivery_points.' . $i, $v['delivery_points'][$i] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" placeholder="e.g. Nairobi pickup available" />
                            </div>
                        @endfor
                    </div>
                    @error('delivery_points') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                    @error('delivery_points.*') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                    <div class="mt-1 text-xs text-zinc-500">Leave blanks to hide unused badges.</div>
                </div>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <div class="space-y-3 rounded-2xl bg-white p-6 watiri-ring">
                <div class="text-sm font-semibold text-zinc-900">Categories section</div>
                <div class="space-y-1">
                    <label class="text-sm text-zinc-700" for="categories_title">Title</label>
                    <input id="categories_title" name="categories_title" value="{{ old('categories_title', $v['categories_title'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                    @error('categories_title') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-sm text-zinc-700" for="categories_subtitle">Subtitle</label>
                    <textarea id="categories_subtitle" name="categories_subtitle" rows="2" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">{{ old('categories_subtitle', $v['categories_subtitle'] ?? '') }}</textarea>
                    @error('categories_subtitle') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="space-y-3 rounded-2xl bg-white p-6 watiri-ring">
                <div class="text-sm font-semibold text-zinc-900">Bestsellers section</div>
                <div class="space-y-1">
                    <label class="text-sm text-zinc-700" for="bestsellers_title">Title</label>
                    <input id="bestsellers_title" name="bestsellers_title" value="{{ old('bestsellers_title', $v['bestsellers_title'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                    @error('bestsellers_title') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-sm text-zinc-700" for="bestsellers_subtitle">Subtitle</label>
                    <textarea id="bestsellers_subtitle" name="bestsellers_subtitle" rows="2" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">{{ old('bestsellers_subtitle', $v['bestsellers_subtitle'] ?? '') }}</textarea>
                    @error('bestsellers_subtitle') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 watiri-ring space-y-4">
            <div class="text-sm font-semibold text-zinc-900">Consult section</div>
            <div class="grid gap-4 md:grid-cols-3">
                <div class="space-y-1 md:col-span-2">
                    <label class="text-sm text-zinc-700" for="consult_title">Title</label>
                    <input id="consult_title" name="consult_title" value="{{ old('consult_title', $v['consult_title'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                    @error('consult_title') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="space-y-1 md:col-span-3">
                    <label class="text-sm text-zinc-700" for="consult_body">Body</label>
                    <textarea id="consult_body" name="consult_body" rows="2" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">{{ old('consult_body', $v['consult_body'] ?? '') }}</textarea>
                    @error('consult_body') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-1">
                    <label class="text-sm text-zinc-700" for="consult_primary_label">Primary CTA label</label>
                    <input id="consult_primary_label" name="consult_primary_label" value="{{ old('consult_primary_label', $v['consult_primary_label'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                    @error('consult_primary_label') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-sm text-zinc-700" for="consult_primary_link">Primary CTA link</label>
                    <input id="consult_primary_link" name="consult_primary_link" value="{{ old('consult_primary_link', $v['consult_primary_link'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" placeholder="#contact" />
                    @error('consult_primary_link') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-sm text-zinc-700" for="consult_secondary_label">Secondary CTA label</label>
                    <input id="consult_secondary_label" name="consult_secondary_label" value="{{ old('consult_secondary_label', $v['consult_secondary_label'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                    @error('consult_secondary_label') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-sm text-zinc-700" for="consult_secondary_link">Secondary CTA link</label>
                    <input id="consult_secondary_link" name="consult_secondary_link" value="{{ old('consult_secondary_link', $v['consult_secondary_link'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" placeholder="https://wa.me/254700000000" />
                    @error('consult_secondary_link') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 watiri-ring space-y-4">
            <div class="text-sm font-semibold text-zinc-900">Newsletter</div>
            <div class="grid gap-4 md:grid-cols-3">
                <div class="space-y-1 md:col-span-2">
                    <label class="text-sm text-zinc-700" for="newsletter_title">Title</label>
                    <input id="newsletter_title" name="newsletter_title" value="{{ old('newsletter_title', $v['newsletter_title'] ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                    @error('newsletter_title') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
                <div class="space-y-1 md:col-span-3">
                    <label class="text-sm text-zinc-700" for="newsletter_body">Body</label>
                    <textarea id="newsletter_body" name="newsletter_body" rows="2" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">{{ old('newsletter_body', $v['newsletter_body'] ?? '') }}</textarea>
                    @error('newsletter_body') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('home') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-medium text-zinc-700 watiri-ring hover:bg-zinc-50">Preview site</a>
            <button type="submit" class="inline-flex items-center rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">
                Save homepage
            </button>
        </div>
    </form>
@endsection
