@extends('layouts.app')

@section('title', 'Login — Watiri Designs')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="rounded-2xl bg-white p-6 watiri-ring">
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">Admin login</h1>
            <p class="mt-2 text-sm text-zinc-600">Sign in to manage products and orders.</p>

            <form class="mt-6 space-y-4" method="post" action="{{ route('login.store') }}">
                @csrf

                <div class="space-y-1">
                    <label class="text-sm font-medium text-zinc-900" for="username">Username</label>
                    <input
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40"
                    />
                    @error('username') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium text-zinc-900" for="password">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40"
                    />
                    @error('password') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>

                <button class="w-full rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">
                    Login
                </button>
            </form>
        </div>
    </div>
@endsection

