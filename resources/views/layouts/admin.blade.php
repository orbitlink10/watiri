<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Admin — ' . config('app.name', 'Watiri Designs'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|cormorant-garamond:400,500,600,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-dvh bg-champagne-50 text-zinc-900 antialiased">
        <header class="border-b border-zinc-200/70 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold tracking-tight font-serif">
                        Admin
                    </a>
                    <span class="text-sm text-zinc-500">{{ config('app.name', 'Watiri Designs') }}</span>
                </div>
                <nav class="flex items-center gap-3 text-sm">
                    <a class="rounded-full px-4 py-2 text-zinc-700 hover:bg-zinc-100 hover:text-zinc-900" href="{{ route('admin.orders.index') }}">Orders</a>
                    <a class="rounded-full px-4 py-2 text-zinc-700 hover:bg-zinc-100 hover:text-zinc-900" href="{{ route('admin.products.index') }}">Products</a>
                    <a class="rounded-full px-4 py-2 text-zinc-700 hover:bg-zinc-100 hover:text-zinc-900" href="{{ route('admin.categories.index') }}">Categories</a>
                    <a class="rounded-full px-4 py-2 text-zinc-700 hover:bg-zinc-100 hover:text-zinc-900" href="{{ route('shop.index') }}">View shop</a>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="rounded-full bg-zinc-900 px-4 py-2 text-white hover:bg-zinc-800">Logout</button>
                    </form>
                </nav>
            </div>
        </header>

        <main class="mx-auto w-full max-w-6xl px-4 py-10">
            @if (session('status'))
                <div class="mb-6 rounded-xl bg-brand-100 px-4 py-3 text-sm text-brand-900 watiri-ring">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="border-t border-zinc-200/70 bg-white">
            <div class="mx-auto max-w-6xl px-4 py-6 text-xs text-zinc-500">
                &copy; {{ date('Y') }} {{ config('app.name', 'Watiri Designs') }} — Admin
            </div>
        </footer>
    </body>
</html>
