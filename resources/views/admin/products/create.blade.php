@extends('layouts.admin')

@section('title', 'Add product — Admin')

@section('content')
    <div class="max-w-3xl">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">Add product</h1>
            <a class="text-sm text-zinc-600 hover:text-zinc-900" href="{{ route('admin.products.index') }}">Back</a>
        </div>

        <form class="mt-6 space-y-6 rounded-2xl bg-white p-6 watiri-ring" method="post" action="{{ route('admin.products.store') }}">
            @csrf
            @include('admin.products._form', ['product' => null])
            <button class="w-full rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">Create product</button>
        </form>
    </div>
@endsection

