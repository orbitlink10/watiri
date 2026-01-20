<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|cormorant-garamond:400,500,600,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-dvh bg-champagne-50 text-zinc-900 antialiased">
        <header class="border-b border-zinc-200/70 bg-white/90 backdrop-blur">
            <div class="bg-brand-100 text-zinc-800">
                <div class="mx-auto flex max-w-6xl flex-col gap-1 px-4 py-2 text-xs md:flex-row md:items-center md:justify-between">
                    <a class="watiri-link" href="tel:+254700000000">
                        Call/WhatsApp: <span class="font-semibold">+254 700 000 000</span>
                    </a>
                    <div class="text-zinc-700">
                        We accept <span class="font-medium">M-Pesa</span>, <span class="font-medium">Visa</span>, <span class="font-medium">Mastercard</span> &amp; <span class="font-medium">PayPal</span>
                    </div>
                </div>
            </div>

            <div class="border-b border-zinc-200/70 bg-white">
                <div class="mx-auto grid max-w-6xl grid-cols-2 gap-x-6 gap-y-2 px-4 py-2 text-[11px] tracking-widest text-zinc-700 md:grid-cols-4 md:text-xs">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-2 w-2 rounded-full bg-brand-500"></span>
                        7 DAY RETURNS
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-2 w-2 rounded-full bg-brand-500"></span>
                        NATIONWIDE DELIVERY
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-2 w-2 rounded-full bg-brand-500"></span>
                        NAIROBI PICKUP
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-2 w-2 rounded-full bg-brand-500"></span>
                        FREE DELIVERY 10K+
                    </div>
                </div>
            </div>

            <div class="border-b border-zinc-200/70 bg-zinc-50/70">
                <div class="mx-auto flex max-w-6xl items-center justify-center px-4 py-2 text-sm">
                    <span class="font-semibold tracking-wide">15% OFF SITEWIDE!</span>
                    <span class="mx-2 hidden text-zinc-500 md:inline">&bull;</span>
                    <span class="text-zinc-700">Use code</span>
                    <span class="ml-2 inline-flex items-center rounded-full bg-white px-3 py-1 font-mono text-xs watiri-ring">
                        WATIRI15
                    </span>
                </div>
            </div>

            <div class="mx-auto max-w-6xl px-4 py-4">
                <div class="grid grid-cols-1 items-center gap-4 md:grid-cols-[auto,1fr,auto]">
                    <a href="{{ route('home') }}" class="group inline-flex items-baseline gap-2">
                        <span class="text-3xl font-semibold uppercase tracking-[0.18em] text-zinc-900 font-serif">
                            Watiri
                        </span>
                        <span class="text-xs tracking-[0.35em] text-zinc-600 group-hover:text-zinc-900">
                            Designs
                        </span>
                    </a>

                    <form action="{{ route('shop.index') }}" method="get" class="relative">
                        <label class="sr-only" for="q">Search</label>
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-zinc-400">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="1.5" />
                                <path d="M16.5 16.5 21 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </span>
                        <input
                            id="q"
                            name="q"
                            placeholder="Search bridal accessories…"
                            class="w-full rounded-md bg-white px-10 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40"
                        />
                    </form>

                    <div class="flex items-center justify-between gap-3 md:justify-end">
                        <a href="#account" class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-100 hover:text-zinc-900">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                <path d="M20 21a8 8 0 1 0-16 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="1.5" />
                            </svg>
                            <span class="hidden sm:inline">Account</span>
                        </a>
                        <a href="#wishlist" class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-100 hover:text-zinc-900">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                <path d="M12 21s-7-4.6-9.3-9.1C1.5 9.4 2.3 6.7 4.6 5.5 7 4.3 9.2 5.6 12 8c2.8-2.4 5-3.7 7.4-2.5 2.3 1.2 3.1 3.9 1.9 6.4C19 16.4 12 21 12 21Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                            <span class="hidden sm:inline">Wishlist</span>
                        </a>
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 rounded-md bg-zinc-900 px-3 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5">
                                <path d="M6 6h15l-1.5 9H7.2L6 6Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                <path d="M6 6 5.3 3H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M9 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM18 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" fill="currentColor" />
                            </svg>
                            <span class="hidden sm:inline">Cart</span>
                            <span class="inline-flex items-center justify-center rounded-full bg-white/15 px-2 py-0.5 text-xs">
                                {{ array_sum(session('cart', [])) }}
                            </span>
                        </a>
                    </div>
                </div>

                <nav class="mt-4 border-t border-zinc-200/70 pt-3">
                    <div class="-mx-4 flex gap-2 overflow-x-auto px-4 text-sm text-zinc-700 md:justify-between md:overflow-visible">
                        <a class="whitespace-nowrap rounded-full px-4 py-2 hover:bg-zinc-100 hover:text-zinc-900" href="{{ route('shop.index') }}">Shop</a>
                        @foreach (($navCategories ?? collect()) as $category)
                            <a class="whitespace-nowrap rounded-full px-4 py-2 hover:bg-zinc-100 hover:text-zinc-900" href="{{ route('shop.index', ['category' => $category->slug]) }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                        <a class="whitespace-nowrap rounded-full px-4 py-2 text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900" href="{{ route('admin.dashboard') }}">Admin</a>
                        <a class="whitespace-nowrap rounded-full px-4 py-2 text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900" href="{{ route('welcome') }}">Dev Welcome</a>
                    </div>
                </nav>
            </div>
        </header>

        <main class="mx-auto w-full max-w-6xl px-4 py-10">
            @yield('content')
        </main>

        <footer class="border-t border-zinc-200/70 bg-white">
            <div class="mx-auto grid max-w-6xl gap-10 px-4 py-10 md:grid-cols-4">
                <div class="space-y-3">
                    <div class="text-lg font-semibold font-serif">Watiri Designs</div>
                    <p class="text-sm text-zinc-600">
                        Bridal accessories handcrafted and curated for modern brides in Kenya.
                    </p>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="font-medium tracking-wide text-zinc-900">Shop</div>
                    <div class="grid gap-2 text-zinc-600">
                        @foreach (($navCategories ?? collect())->take(4) as $category)
                            <a class="watiri-link" href="{{ route('shop.index', ['category' => $category->slug]) }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="font-medium tracking-wide text-zinc-900">Support</div>
                    <div class="grid gap-2 text-zinc-600">
                        <a class="watiri-link" href="#delivery">Delivery &amp; Returns</a>
                        <a class="watiri-link" href="#faq">FAQs</a>
                        <a class="watiri-link" href="#contact">Contact</a>
                    </div>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="font-medium tracking-wide text-zinc-900">Contact</div>
                    <div class="grid gap-2 text-zinc-600">
                        <a class="watiri-link" href="mailto:hello@watiridesigns.co.ke">hello@watiridesigns.co.ke</a>
                        <a class="watiri-link" href="tel:+254700000000">+254 700 000 000</a>
                        <span class="text-zinc-500">Nairobi, Kenya</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-zinc-200/70">
                <div class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-6 text-xs text-zinc-500 md:flex-row md:items-center md:justify-between">
                    <div>&copy; {{ date('Y') }} {{ config('app.name', 'Watiri Designs') }}</div>
                    <div class="flex gap-4">
                        <a class="watiri-link" href="#privacy">Privacy</a>
                        <a class="watiri-link" href="#terms">Terms</a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
