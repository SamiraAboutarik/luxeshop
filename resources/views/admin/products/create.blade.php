@extends('layouts.admin')
@section('title', 'Nouveau produit')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-muted hover:text-gold transition-colors">← Retour</a>
        <h2 class="font-serif text-2xl">Nouveau produit</h2>
    </div>
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-surface border border-border rounded p-6 space-y-5">
        @csrf
        <div class="grid grid-cols-2 gap-5">
            <div class="col-span-2">
                <label class="block text-xs tracking-widest uppercase text-muted mb-2">Nom du produit *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-dark border border-border rounded px-4 py-3 text-sm text-cream focus:border-gold focus:outline-none">
                @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs tracking-widest uppercase text-muted mb-2">Catégorie *</label>
                <select name="category_id" required class="w-full bg-dark border border-border rounded px-4 py-3 text-sm text-cream focus:border-gold focus:outline-none">
                    <option value="">Choisir...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs tracking-widest uppercase text-muted mb-2">Prix (MAD) *</label>
                <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required class="w-full bg-dark border border-border rounded px-4 py-3 text-sm text-cream focus:border-gold focus:outline-none">
                @error('price')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs tracking-widest uppercase text-muted mb-2">Stock *</label>
                <input type="number" name="stock" value="{{ old('stock',0) }}" min="0" required class="w-full bg-dark border border-border rounded px-4 py-3 text-sm text-cream focus:border-gold focus:outline-none">
                @error('stock')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs tracking-widest uppercase text-muted mb-2">Image</label>
                <input type="file" name="image" accept="image/*" class="w-full bg-dark border border-border rounded px-4 py-3 text-sm text-muted focus:border-gold focus:outline-none file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-gold file:text-noir cursor-pointer">
                @error('image')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="col-span-2">
                <label class="block text-xs tracking-widest uppercase text-muted mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full bg-dark border border-border rounded px-4 py-3 text-sm text-cream focus:border-gold focus:outline-none resize-none">{{ old('description') }}</textarea>
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active',1) ? 'checked' : '' }} class="accent-gold w-4 h-4">
                <label for="is_active" class="text-sm text-cream">Produit actif</label>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-gold px-8 py-3 text-xs tracking-widest uppercase font-semibold rounded">Créer le produit</button>
            <a href="{{ route('admin.products.index') }}" class="px-8 py-3 text-xs tracking-widest uppercase text-muted hover:text-cream transition-colors border border-border rounded">Annuler</a>
        </div>
    </form>
</div>
@endsection
