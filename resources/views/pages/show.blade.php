@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)

@section('content')
    <div class="mx-auto max-w-5xl">
        <article class="overflow-hidden rounded-[2rem] bg-white shadow-[0_24px_80px_-48px_rgba(24,24,27,0.45)] watiri-ring">
            <div class="relative overflow-hidden border-b border-zinc-200/70 bg-[radial-gradient(circle_at_top_left,_rgba(243,212,219,0.6),_transparent_42%),linear-gradient(180deg,_rgba(255,255,255,0.98),_rgba(251,250,247,0.92))] px-6 py-10 sm:px-10 lg:px-14 lg:py-14">
                <div class="absolute right-0 top-0 h-32 w-32 -translate-y-8 translate-x-10 rounded-full bg-brand-100/70 blur-3xl"></div>

                <div class="relative max-w-3xl">
                    <div class="inline-flex items-center rounded-full bg-brand-100 px-5 py-2 text-xs font-medium tracking-[0.18em] text-brand-800">
                        {{ strtoupper($page->type) }}
                    </div>

                    <h1 class="mt-6 text-4xl leading-tight font-semibold tracking-tight text-zinc-900 font-serif sm:text-5xl">
                        {{ $page->title }}
                    </h1>

                    @if ($page->heading_2)
                        <p class="mt-5 max-w-2xl text-xl leading-8 text-zinc-700 sm:text-2xl">
                            {{ $page->heading_2 }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="px-6 py-8 sm:px-10 lg:px-14 lg:py-12">
                @if ($page->content)
                    <div class="page-content">
                        {!! \App\Support\PageContentFormatter::format($page->content) !!}
                    </div>
                @else
                    <div class="rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 px-6 py-8 text-sm text-zinc-600">
                        No content has been added to this page yet.
                    </div>
                @endif
            </div>
        </article>
    </div>
@endsection
