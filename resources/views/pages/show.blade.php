@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="rounded-2xl bg-white p-8 watiri-ring">
            <div class="inline-flex items-center rounded-full bg-brand-100 px-4 py-2 text-xs font-medium text-brand-800">
                {{ strtoupper($page->type) }}
            </div>

            <h1 class="mt-4 text-3xl font-semibold tracking-tight text-zinc-900 font-serif">
                {{ $page->title }}
            </h1>

            @if ($page->heading_2)
                <h2 class="mt-3 text-lg text-zinc-700">
                    {{ $page->heading_2 }}
                </h2>
            @endif

            @if ($page->content)
                <div class="prose prose-zinc mt-6 max-w-none">
                    {!! $page->content !!}
                </div>
            @else
                <div class="mt-6 text-sm text-zinc-600">No content.</div>
            @endif
        </div>
    </div>
@endsection

