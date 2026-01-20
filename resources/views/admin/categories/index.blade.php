@extends('layouts.admin')

@section('title', 'Categories — Admin')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">Categories</h1>
            <p class="mt-1 text-sm text-zinc-600">Organize products by category.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">
            Add category
        </a>
    </div>

    <div class="mt-6 rounded-2xl bg-white watiri-ring">
        <div class="divide-y divide-zinc-200/70">
            @forelse ($categories as $category)
                <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <div class="font-medium text-zinc-900">{{ $category->name }}</div>
                        <div class="text-sm text-zinc-500">{{ $category->slug }} • {{ number_format($category->products_count) }} products</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="rounded-md bg-zinc-100 px-4 py-2 text-sm text-zinc-800 hover:bg-zinc-200">
                            Edit
                        </a>
                        <form method="post" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-md bg-brand-600 px-4 py-2 text-sm font-medium text-white hover:bg-brand-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-sm text-zinc-600">No categories yet.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
@endsection

