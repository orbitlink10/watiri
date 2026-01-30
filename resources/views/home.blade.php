@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $home = $homeContent ?? \App\Models\HomeContent::defaults();

    $heroImage = asset('images/hero-bridal.svg');
    if (! empty($home['hero_image_path'] ?? null) && Storage::disk('public')->exists($home['hero_image_path'])) {
        $lastModified = Storage::disk('public')->lastModified($home['hero_image_path']) ?: now()->timestamp;
        $heroImage = route('hero.image', ['v' => $lastModified]);
    }

    $linkResolver = function (?string $value, string $fallback) {
        if (blank($value)) {
            return $fallback;
        }

        if (Str::startsWith($value, '#')) {
            return $value;
        }

        if (Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        return url($value);
    };

    $heroPrimaryLink = $linkResolver($home['hero_primary_link'] ?? null, route('shop.index'));
    $heroSecondaryLink = $linkResolver($home['hero_secondary_link'] ?? null, '#consult');
    $deliveryPoints = collect($home['delivery_points'] ?? [])->filter()->take(3);
@endphp

@section('title', $home['seo_title'] ?? 'Watiri Designs - Bridal Accessories in Kenya')

@section('content')
    <section class="relative overflow-hidden rounded-2xl bg-white watiri-ring">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-50 via-white to-champagne-100"></div>
        <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-brand-200/70 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-champagne-200/70 blur-3xl"></div>

        <div class="relative grid gap-10 p-8 md:grid-cols-2 md:items-center md:p-12">
            <div class="space-y-6">
                <div class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-xs font-medium tracking-wide text-zinc-700 watiri-ring">
                    <span class="inline-flex h-2 w-2 rounded-full bg-brand-500"></span>
                    {{ $home['hero_badge'] ?? 'Bridal Accessories in Kenya' }}
                </div>

                <h1 class="text-4xl font-semibold leading-tight tracking-tight text-zinc-900 md:text-5xl font-serif">
                    {{ $home['hero_heading'] ?? 'Wedding day details,' }}
                    <span class="text-brand-700">{{ $home['hero_heading_highlight'] ?? 'perfectly finished.' }}</span>
                </h1>

                <p class="max-w-prose text-base leading-relaxed text-zinc-700">
                    {{ $home['hero_description'] ?? 'From statement hair pieces and timeless veils to jewellery that photographs beautifully - Watiri Designs helps you complete your bridal look with confidence.' }}
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ $heroPrimaryLink }}" class="inline-flex items-center rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">
                        {{ $home['hero_primary_label'] ?? 'Shop collections' }}
                    </a>
                    <a href="{{ $heroSecondaryLink }}" class="inline-flex items-center rounded-md bg-white px-5 py-3 text-sm font-medium text-zinc-900 watiri-ring hover:bg-zinc-50">
                        {{ $home['hero_secondary_label'] ?? 'Book a styling consult' }}
                    </a>
                </div>

                <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-zinc-600" id="delivery">
                    @forelse ($deliveryPoints as $point)
                        <div class="inline-flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>
                            {{ $point }}
                        </div>
                    @empty
                        <div class="inline-flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>
                            {{ __('Delivery information coming soon.') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="relative">
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-brand-200/50 via-white to-champagne-200/60 blur-xl"></div>
                <div class="relative overflow-hidden rounded-2xl bg-white watiri-ring">
                    <img
                        src="{{ $heroImage }}"
                        alt="Watiri Designs bridal accessories"
                        class="h-[360px] w-full object-cover md:h-[460px]"
                    />
                </div>
                <div class="mt-4 grid grid-cols-3 gap-3 text-xs text-zinc-700">
                    <div class="rounded-xl bg-white px-4 py-3 watiri-ring">
                        <div class="font-semibold">Hair pieces</div>
                        <div class="text-zinc-500">Pearls • crystal • florals</div>
                    </div>
                    <div class="rounded-xl bg-white px-4 py-3 watiri-ring">
                        <div class="font-semibold">Veils</div>
                        <div class="text-zinc-500">Cathedral • fingertip</div>
                    </div>
                    <div class="rounded-xl bg-white px-4 py-3 watiri-ring">
                        <div class="font-semibold">Jewellery</div>
                        <div class="text-zinc-500">Earrings • sets</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-12" id="collections">
        <div class="flex items-end justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">{{ $home['categories_title'] ?? 'Shop by category' }}</h2>
                <p class="text-sm text-zinc-600">{{ $home['categories_subtitle'] ?? 'Curated pieces that complement your dress, venue, and hairstyle.' }}</p>
            </div>
            <a class="hidden text-sm font-medium text-zinc-900 underline-offset-4 hover:underline md:inline" href="{{ route('shop.index') }}">View shop</a>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse (($homeCategories ?? collect()) as $category)
                @php
                    $iconVariant = match ($category->slug) {
                        'hair-accessories' => 'hair',
                        'veils' => 'veil',
                        'bridal-jewellery' => 'jewel',
                        'garters' => 'garter',
                        'cover-ups' => 'cover',
                        'gifts' => 'gift',
                        default => 'default',
                    };

                    $iconWrap = match ($iconVariant) {
                        'veil', 'cover' => 'bg-champagne-100 text-champagne-800',
                        'jewel', 'gift' => 'bg-white text-zinc-900',
                        default => 'bg-brand-100 text-brand-700',
                    };

                    $bg = match ($iconVariant) {
                        'veil', 'cover' => 'from-champagne-50 to-white',
                        'jewel' => 'from-brand-50 to-champagne-50',
                        'gift' => 'from-white to-champagne-50',
                        default => 'from-brand-50 to-white',
                    };
                @endphp

                <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="group relative overflow-hidden rounded-2xl bg-white p-6 watiri-ring">
                    <div class="absolute inset-0 bg-gradient-to-br {{ $bg }} opacity-90"></div>
                    <div class="relative space-y-3">
                        <div class="inline-flex h-11 w-11 items-center justify-center rounded-xl {{ $iconWrap }} watiri-ring">
                            @if ($iconVariant === 'hair')
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-6 w-6">
                                    <path d="M6 12c2.5-6 9.5-6 12 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M7 14c1.5 3 8.5 3 10 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M12 5v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            @elseif ($iconVariant === 'veil')
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-6 w-6">
                                    <path d="M12 3c4 4 7 8 7 12a7 7 0 0 1-14 0c0-4 3-8 7-12Z" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M8 14c1.5 1.2 3 1.8 4 1.8s2.5-.6 4-1.8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            @elseif ($iconVariant === 'jewel')
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-6 w-6">
                                    <path d="M12 3c2.8 3.3 5.2 6.2 5.2 9.2A5.2 5.2 0 1 1 6.8 12.2C6.8 9.2 9.2 6.3 12 3Z" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M12 10v6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M9.5 16.5h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            @elseif ($iconVariant === 'garter')
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-6 w-6">
                                    <path d="M7 9c3-3 7-3 10 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M6 12c4-4 8-4 12 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M7 15c3 3 7 3 10 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            @elseif ($iconVariant === 'cover')
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-6 w-6">
                                    <path d="M7 7 12 3l5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M7 7v14m10-14v14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M7 12h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            @elseif ($iconVariant === 'gift')
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-6 w-6">
                                    <path d="M4 10h16v10H4V10Z" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M12 10v10" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M4 10h16l-2-4H6l-2 4Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                    <path d="M9 6c0-1.7 1.3-3 3-3 1.7 0 3 1.3 3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-6 w-6">
                                    <path d="M5 12h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M12 5v14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-zinc-900">{{ $category->name }}</div>
                            <div class="text-sm text-zinc-600">{{ $category->description ?: 'Browse products in this category.' }}</div>
                        </div>
                        <div class="text-sm font-medium text-zinc-900 group-hover:underline">Shop {{ strtolower($category->name) }}</div>
                    </div>
                </a>
            @empty
                <div class="rounded-2xl bg-white p-10 text-center text-sm text-zinc-600 watiri-ring">
                    No categories yet. Add categories in the admin dashboard.
                </div>
            @endforelse
        </div>
    </section>

    <section class="mt-12" id="bestsellers">
        <div class="flex items-end justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">{{ $home['bestsellers_title'] ?? 'Bestsellers' }}</h2>
                <p class="text-sm text-zinc-600">{{ $home['bestsellers_subtitle'] ?? 'Popular picks for brides, bridesmaids, and traditional ceremonies.' }}</p>
            </div>
            <a class="hidden text-sm font-medium text-zinc-900 underline-offset-4 hover:underline md:inline" href="#contact">Need help choosing?</a>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @forelse (($featuredProducts ?? collect()) as $product)
                <div class="group rounded-2xl bg-white p-5 watiri-ring hover:bg-zinc-50">
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <div class="flex items-center justify-between gap-3">
                            <span class="inline-flex items-center rounded-full bg-brand-100 px-3 py-1 text-xs font-medium text-brand-800">
                                {{ $product->category?->name ?? 'Category' }}
                            </span>
                            <span class="text-xs text-zinc-500">{{ $product->stock > 0 ? 'In stock' : 'Preorder' }}</span>
                        </div>
                        <div class="mt-6 h-28 rounded-xl bg-gradient-to-br from-brand-50 via-white to-champagne-100 watiri-ring"></div>
                        <div class="mt-4 space-y-1">
                            <div class="text-sm font-semibold text-zinc-900 group-hover:underline">{{ $product->name }}</div>
                            <div class="text-sm text-zinc-700">KES {{ number_format($product->price) }}</div>
                        </div>
                    </a>
                    <form class="mt-4" method="post" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <button class="w-full rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                            Add to cart
                        </button>
                    </form>
                </div>
            @empty
                <div class="rounded-2xl bg-white p-10 text-center text-sm text-zinc-600 watiri-ring lg:col-span-4">
                    No products yet. Add products in the admin dashboard.
                </div>
            @endforelse
        </div>
    </section>

    <section class="mt-12 rounded-2xl bg-white p-8 watiri-ring" id="consult">
        <div class="grid gap-8 md:grid-cols-3 md:items-center">
            <div class="md:col-span-2">
                <h2 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">{{ $home['consult_title'] ?? 'Not sure what suits your dress?' }}</h2>
                <p class="mt-2 text-sm leading-relaxed text-zinc-600">
                    {{ $home['consult_body'] ?? 'Send us your dress style, venue, and hair inspo - we will recommend accessories that match your look and budget.' }}
                </p>
            </div>
            <div class="flex flex-wrap gap-3 md:justify-end">
                @if (! empty($home['consult_primary_label']))
                    <a href="{{ $linkResolver($home['consult_primary_link'] ?? null, '#contact') }}" class="inline-flex items-center rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">
                        {{ $home['consult_primary_label'] }}
                    </a>
                @endif
                @if (! empty($home['consult_secondary_label']))
                    <a href="{{ $linkResolver($home['consult_secondary_link'] ?? null, 'https://wa.me/254700000000') }}" class="inline-flex items-center rounded-md bg-brand-600 px-5 py-3 text-sm font-medium text-white hover:bg-brand-700">
                        {{ $home['consult_secondary_label'] }}
                    </a>
                @endif
                @if (empty($home['consult_primary_label']) && empty($home['consult_secondary_label']))
                    <a href="#contact" class="inline-flex items-center rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">
                        {{ __('Talk to us') }}
                    </a>
                    <a href="https://wa.me/254700000000" class="inline-flex items-center rounded-md bg-brand-600 px-5 py-3 text-sm font-medium text-white hover:bg-brand-700">
                        {{ __('WhatsApp') }}
                    </a>
                @endif
            </div>
        </div>
    </section>

    <section class="mt-12 grid gap-4 lg:grid-cols-3" id="faq">
        <div class="rounded-2xl bg-white p-6 watiri-ring">
            <div class="text-sm font-semibold text-zinc-900">Fast delivery</div>
            <p class="mt-2 text-sm text-zinc-600">
                Same-day Nairobi dispatch options and reliable nationwide couriers.
            </p>
        </div>
        <div class="rounded-2xl bg-white p-6 watiri-ring">
            <div class="text-sm font-semibold text-zinc-900">Quality you can feel</div>
            <p class="mt-2 text-sm text-zinc-600">
                Carefully finished pieces with secure fittings for all-day wear.
            </p>
        </div>
        <div class="rounded-2xl bg-white p-6 watiri-ring">
            <div class="text-sm font-semibold text-zinc-900">Friendly support</div>
            <p class="mt-2 text-sm text-zinc-600">
                We help you match accessories to your hairstyle, neckline, and theme.
            </p>
        </div>
    </section>

    <section class="mt-12 rounded-2xl bg-zinc-900 p-8 text-white md:p-10" id="contact">
        <div class="grid gap-8 md:grid-cols-2 md:items-center">
            <div class="space-y-3">
                <h2 class="text-2xl font-semibold tracking-tight font-serif">{{ $home['newsletter_title'] ?? 'Get updates + new arrivals' }}</h2>
                <p class="text-sm text-white/80">
                    {{ $home['newsletter_body'] ?? 'Join the list for restocks, styling tips, and bridal offers.' }}
                </p>

                @if (session('subscribed'))
                    <div class="rounded-xl bg-white/10 px-4 py-3 text-sm text-white/90 ring-1 ring-white/15">
                        Subscribed{{ session('subscribed_email') ? ' with ' . session('subscribed_email') : '' }}. Thank you!
                    </div>
                @endif
            </div>
            <form class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end" action="{{ route('subscribe') }}" method="post">
                @csrf
                <label class="sr-only" for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    placeholder="you@example.com"
                    class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-brand-300/60 sm:max-w-xs"
                />
                <button type="submit" class="rounded-md bg-brand-600 px-5 py-3 text-sm font-medium text-white hover:bg-brand-700">
                    Subscribe
                </button>
            </form>
        </div>
    </section>
@endsection
