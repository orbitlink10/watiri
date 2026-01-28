<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeContentController extends Controller
{
    public function edit()
    {
        $homeContent = HomeContent::query()->first();

        return view('admin.homepage.edit', [
            'values' => HomeContent::viewData(),
            'homeContent' => $homeContent,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'seo_title' => ['required', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:2000'],
            'hero_badge' => ['nullable', 'string', 'max:255'],
            'hero_heading' => ['required', 'string', 'max:255'],
            'hero_heading_highlight' => ['required', 'string', 'max:255'],
            'hero_description' => ['required', 'string', 'max:2000'],
            'hero_primary_label' => ['required', 'string', 'max:120'],
            'hero_primary_link' => ['nullable', 'string', 'max:255'],
            'hero_secondary_label' => ['nullable', 'string', 'max:120'],
            'hero_secondary_link' => ['nullable', 'string', 'max:255'],
            'delivery_points' => ['nullable', 'array', 'max:5'],
            'delivery_points.*' => ['nullable', 'string', 'max:160'],
            'categories_title' => ['required', 'string', 'max:255'],
            'categories_subtitle' => ['nullable', 'string', 'max:500'],
            'bestsellers_title' => ['required', 'string', 'max:255'],
            'bestsellers_subtitle' => ['nullable', 'string', 'max:500'],
            'consult_title' => ['required', 'string', 'max:255'],
            'consult_body' => ['nullable', 'string', 'max:500'],
            'consult_primary_label' => ['nullable', 'string', 'max:120'],
            'consult_primary_link' => ['nullable', 'string', 'max:255'],
            'consult_secondary_label' => ['nullable', 'string', 'max:120'],
            'consult_secondary_link' => ['nullable', 'string', 'max:255'],
            'newsletter_title' => ['required', 'string', 'max:255'],
            'newsletter_body' => ['nullable', 'string', 'max:500'],
            'hero_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $homeContent = HomeContent::query()->first() ?? new HomeContent();

        $homeContent->fill([
            'seo_title' => $validated['seo_title'],
            'seo_description' => $validated['seo_description'] ?? null,
            'hero_badge' => $validated['hero_badge'] ?? null,
            'hero_heading' => $validated['hero_heading'],
            'hero_heading_highlight' => $validated['hero_heading_highlight'],
            'hero_description' => $validated['hero_description'],
            'hero_primary_label' => $validated['hero_primary_label'],
            'hero_primary_link' => $validated['hero_primary_link'] ?? null,
            'hero_secondary_label' => $validated['hero_secondary_label'] ?? null,
            'hero_secondary_link' => $validated['hero_secondary_link'] ?? null,
            'delivery_points' => collect($validated['delivery_points'] ?? [])
                ->filter(fn ($value) => filled($value))
                ->values()
                ->all(),
            'categories_title' => $validated['categories_title'],
            'categories_subtitle' => $validated['categories_subtitle'] ?? null,
            'bestsellers_title' => $validated['bestsellers_title'],
            'bestsellers_subtitle' => $validated['bestsellers_subtitle'] ?? null,
            'consult_title' => $validated['consult_title'],
            'consult_body' => $validated['consult_body'] ?? null,
            'consult_primary_label' => $validated['consult_primary_label'] ?? null,
            'consult_primary_link' => $validated['consult_primary_link'] ?? null,
            'consult_secondary_label' => $validated['consult_secondary_label'] ?? null,
            'consult_secondary_link' => $validated['consult_secondary_link'] ?? null,
            'newsletter_title' => $validated['newsletter_title'],
            'newsletter_body' => $validated['newsletter_body'] ?? null,
        ]);

        if ($request->hasFile('hero_image')) {
            if ($homeContent->hero_image_path) {
                Storage::disk('public')->delete($homeContent->hero_image_path);
            }

            $homeContent->hero_image_path = $request->file('hero_image')->store('home', 'public');
        }

        $homeContent->save();

        return redirect()->route('admin.homepage.edit')->with('status', 'Homepage content updated.');
    }
}
