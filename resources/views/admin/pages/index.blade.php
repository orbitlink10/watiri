@extends('layouts.admin')

@section('title', 'Pages — Admin')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">Manage Pages</h1>
            <p class="mt-1 text-sm text-zinc-600">Create and edit your website pages.</p>
        </div>
        <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">
            Add new
        </a>
    </div>

    <form class="mt-6 grid gap-3 rounded-2xl bg-white p-6 watiri-ring sm:grid-cols-3" method="get" action="{{ route('admin.pages.index') }}">
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="q">Search</label>
            <input id="q" name="q" value="{{ $q }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
        </div>
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="type">Type</label>
            <select id="type" name="type" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">
                <option value="">All</option>
                <option value="page" @selected($type === 'page')>Page</option>
                <option value="post" @selected($type === 'post')>Post</option>
            </select>
        </div>
        <div class="flex items-end">
            <button class="w-full rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">Filter</button>
        </div>
    </form>

    <div class="mt-6 rounded-2xl bg-white watiri-ring">
        <div class="divide-y divide-zinc-200/70">
            @forelse ($pages as $page)
                <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <div class="font-medium text-zinc-900">{{ $page->title }}</div>
                            <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-700">{{ strtoupper($page->type) }}</span>
                            @if ($page->is_published)
                                <span class="rounded-full bg-brand-100 px-3 py-1 text-xs font-medium text-brand-800">Published</span>
                            @else
                                <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-700">Draft</span>
                            @endif
                        </div>
                        <div class="text-sm text-zinc-500">
                            /pages/{{ $page->slug }}
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('pages.show', $page) }}" class="rounded-md bg-zinc-100 px-4 py-2 text-sm text-zinc-800 hover:bg-zinc-200">
                            View
                        </a>
                        <a href="{{ route('admin.pages.edit', $page) }}" class="rounded-md bg-zinc-100 px-4 py-2 text-sm text-zinc-800 hover:bg-zinc-200">
                            Edit
                        </a>
                        <form method="post" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Delete this page?');">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-md bg-brand-600 px-4 py-2 text-sm font-medium text-white hover:bg-brand-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-sm text-zinc-600">No pages yet.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $pages->links() }}
    </div>
@endsection

