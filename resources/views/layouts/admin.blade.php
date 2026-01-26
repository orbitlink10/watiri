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
        @php
            $navItem = function (string $href, string $label, bool $active = false) {
                $base = 'group flex items-center gap-3 rounded-lg px-3 py-2 text-sm';
                $activeClass = $active ? 'bg-zinc-100 text-zinc-900 watiri-ring' : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900';
                return $base . ' ' . $activeClass;
            };
        @endphp

        <div class="flex min-h-dvh">
            <aside class="w-72 shrink-0 border-r border-zinc-200/70 bg-white">
                <div class="flex h-full flex-col">
                    <div class="border-b border-zinc-200/70 p-6">
                        <a href="{{ route('admin.dashboard') }}" class="block">
                            <div class="text-xl font-semibold tracking-tight text-zinc-900 font-serif">
                                {{ config('app.name', 'Watiri Designs') }}
                            </div>
                            <div class="mt-1 text-xs tracking-widest text-zinc-500">ADMIN PANEL</div>
                        </a>
                    </div>

                    <nav class="flex-1 space-y-6 p-4">
                        <div class="space-y-1">
                            <a href="{{ route('home') }}" class="{{ $navItem(route('home'), 'Visit Website') }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5 text-zinc-500 group-hover:text-zinc-900">
                                    <path d="M14 3h7v7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10 14 21 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M21 14v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span>{{ __('Visit Website') }}</span>
                            </a>

                            <a href="{{ route('admin.dashboard') }}" class="{{ $navItem(route('admin.dashboard'), 'Dashboard', request()->routeIs('admin.dashboard')) }}">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5 text-zinc-500 group-hover:text-zinc-900">
                                    <path d="M12 3a9 9 0 1 0 9 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M12 12 19 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12 12v6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                <span>{{ __('Dashboard') }}</span>
                            </a>
                        </div>

                        <div class="space-y-2">
                            <div class="px-3 text-xs font-medium tracking-widest text-zinc-500">CONTENT MANAGEMENT</div>
                            <div class="space-y-1">
                                <a href="{{ route('admin.pages.index') }}" class="{{ $navItem(route('admin.pages.index'), 'Pages', request()->routeIs('admin.pages.*')) }}">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5 text-zinc-500 group-hover:text-zinc-900">
                                        <path d="M6 3h9l3 3v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                        <path d="M15 3v4h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8 11h8M8 15h8M8 19h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.6" />
                                    </svg>
                                    <span>{{ __('Pages') }}</span>
                                </a>

                                <a href="{{ route('admin.categories.index') }}" class="{{ $navItem(route('admin.categories.index'), 'Categories', request()->routeIs('admin.categories.*')) }}">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5 text-zinc-500 group-hover:text-zinc-900">
                                        <path d="M4 6h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M4 12h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M4 18h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M8 6v12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.35" />
                                    </svg>
                                    <span>{{ __('Categories') }}</span>
                                </a>

                                <a href="{{ route('admin.products.index') }}" class="{{ $navItem(route('admin.products.index'), 'Products', request()->routeIs('admin.products.*')) }}">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5 text-zinc-500 group-hover:text-zinc-900">
                                        <path d="M3 7h18v14H3V7Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M3 12h18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.35" />
                                    </svg>
                                    <span>{{ __('Products') }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="px-3 text-xs font-medium tracking-widest text-zinc-500">SALES</div>
                            <div class="space-y-1">
                                <a href="{{ route('admin.orders.index') }}" class="{{ $navItem(route('admin.orders.index'), 'Orders', request()->routeIs('admin.orders.*')) }}">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-5 w-5 text-zinc-500 group-hover:text-zinc-900">
                                        <path d="M6 6h15l-1.5 9H7.2L6 6Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                        <path d="M6 6 5.3 3H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M9 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM18 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" fill="currentColor" />
                                    </svg>
                                    <span>{{ __('Orders') }}</span>
                                </a>
                            </div>
                        </div>
                    </nav>

                    <div class="border-t border-zinc-200/70 p-4">
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button class="flex w-full items-center justify-center rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="min-w-0 flex-1">
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
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
