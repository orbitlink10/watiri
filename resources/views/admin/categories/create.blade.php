@extends('layouts.admin')

@section('title', 'Add category — Admin')

@section('content')
    <div class="max-w-2xl">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">Add category</h1>
            <a class="text-sm text-zinc-600 hover:text-zinc-900" href="{{ route('admin.categories.index') }}">Back</a>
        </div>

        <form class="mt-6 space-y-4 rounded-2xl bg-white p-6 watiri-ring" method="post" action="{{ route('admin.categories.store') }}">
            @csrf

            <div class="space-y-1">
                <label class="text-sm font-medium text-zinc-900" for="name">Name</label>
                <input id="name" name="name" value="{{ old('name') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
                @error('name') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
            </div>

            <div class="space-y-1">
                <label class="text-sm font-medium text-zinc-900" for="description">Description (optional)</label>
                <textarea id="description" name="description" rows="4" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">{{ old('description') }}</textarea>
                @error('description') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
            </div>

            <button class="w-full rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">Create category</button>
        </form>
    </div>
@endsection

