@extends('layouts.admin')

@section('title', 'Edit page — Admin')

@section('content')
    <div class="max-w-4xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">Edit Page</h1>
                <div class="mt-1 text-sm text-zinc-600">
                    <a class="watiri-link" href="{{ route('pages.show', $page) }}" target="_blank">View: /pages/{{ $page->slug }}</a>
                </div>
            </div>
            <a class="text-sm text-zinc-600 hover:text-zinc-900" href="{{ route('admin.pages.index') }}">Back</a>
        </div>

        <form class="mt-6 space-y-6 rounded-2xl bg-white p-6 watiri-ring" method="post" action="{{ route('admin.pages.update', $page) }}">
            @csrf
            @method('PUT')
            @include('admin.pages._form', ['page' => $page])
            <button class="w-full rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">Save changes</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#content',
            menubar: true,
            height: 360,
            plugins: 'link image lists table code fullscreen media',
            toolbar:
                'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image media | table | code fullscreen',
        });
    </script>
@endpush

