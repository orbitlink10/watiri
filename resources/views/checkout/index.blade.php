@extends('layouts.app')

@section('title', 'Checkout — Watiri Designs')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-2xl bg-white p-6 watiri-ring">
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">Checkout</h1>
            <p class="mt-2 text-sm text-zinc-600">Enter your details and we’ll confirm your order on WhatsApp/phone.</p>

            <form class="mt-6 space-y-4" method="post" action="{{ route('checkout.store') }}">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-zinc-900" for="customer_name">Full name</label>
                        <input
                            id="customer_name"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40"
                        />
                        @error('customer_name') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-medium text-zinc-900" for="customer_phone">Phone/WhatsApp</label>
                        <input
                            id="customer_phone"
                            name="customer_phone"
                            value="{{ old('customer_phone') }}"
                            placeholder="+254…"
                            class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40"
                        />
                        @error('customer_phone') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium text-zinc-900" for="customer_email">Email (optional)</label>
                    <input
                        id="customer_email"
                        name="customer_email"
                        type="email"
                        value="{{ old('customer_email') }}"
                        class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40"
                    />
                    @error('customer_email') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium text-zinc-900" for="delivery_address">Delivery address (optional)</label>
                    <input
                        id="delivery_address"
                        name="delivery_address"
                        value="{{ old('delivery_address') }}"
                        placeholder="e.g. Nairobi, Westlands…"
                        class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40"
                    />
                    @error('delivery_address') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-medium text-zinc-900" for="notes">Notes (optional)</label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="4"
                        class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40"
                    >{{ old('notes') }}</textarea>
                    @error('notes') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                </div>

                <button class="w-full rounded-md bg-brand-600 px-5 py-3 text-sm font-medium text-white hover:bg-brand-700">
                    Place order
                </button>
            </form>
        </div>
    </div>
@endsection

