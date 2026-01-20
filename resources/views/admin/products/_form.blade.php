<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="category_id">Category</label>
            <select id="category_id" name="category_id" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id ?? 0) === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="name">Name</label>
            <input id="name" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
            @error('name') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="space-y-1">
        <label class="text-sm font-medium text-zinc-900" for="description">Description (optional)</label>
        <textarea id="description" name="description" rows="4" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="price">Price (KES)</label>
            <input id="price" name="price" type="number" min="0" value="{{ old('price', $product->price ?? 0) }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
            @error('price') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="stock">Stock</label>
            <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $product->stock ?? 0) }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
            @error('stock') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="is_active">Status</label>
            <select id="is_active" name="is_active" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">
                <option value="1" @selected((bool) old('is_active', $product->is_active ?? true))>Active</option>
                <option value="0" @selected(! (bool) old('is_active', $product->is_active ?? true))>Inactive</option>
            </select>
            @error('is_active') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="space-y-1">
        <label class="text-sm font-medium text-zinc-900" for="image_url">Image URL (optional)</label>
        <input id="image_url" name="image_url" value="{{ old('image_url', $product->image_url ?? '') }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
        @error('image_url') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
    </div>
</div>

