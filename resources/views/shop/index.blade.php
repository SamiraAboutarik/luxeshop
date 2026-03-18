@extends('layouts.app')
@section('title', 'Boutique')
@section('content')
{{-- Hero --}}
<section class="border-b border-border">
    <div class="max-w-7xl mx-auto px-4 py-20 text-center">
        <p class="text-xs tracking-[.4em] uppercase text-gold mb-4">Collection Exclusive</p>
        <h1 class="font-serif text-6xl md:text-7xl text-cream mb-6">L'Art du <em>Luxe</em></h1>
        <p class="text-muted text-sm tracking-wider max-w-md mx-auto">Des produits soigneusement sélectionnés pour vous offrir le meilleur</p>
    </div>
</section>

{{-- Filters --}}
<section class="border-b border-border bg-dark/50">
    <div class="max-w-7xl mx-auto px-4 py-4">
        <form method="GET" class="flex flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..."
                class="bg-surface border border-border rounded px-4 py-2 text-sm text-cream focus:border-gold focus:outline-none w-64 placeholder-muted/50">
            <select name="category" class="bg-surface border border-border rounded px-4 py-2 text-sm text-cream focus:border-gold focus:outline-none">
                <option value="">Toutes catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="sort" class="bg-surface border border-border rounded px-4 py-2 text-sm text-cream focus:border-gold focus:outline-none">
                <option value="">Trier par</option>
                <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Nouveautés</option>
                <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Prix croissant</option>
                <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Prix décroissant</option>
            </select>
            <button type="submit" class="btn-gold px-5 py-2 text-xs tracking-widest uppercase font-semibold rounded">Filtrer</button>
            @if(request()->hasAny(['search','category','sort']))
                <a href="{{ route('shop.index') }}" class="text-muted text-xs hover:text-cream transition-colors">Réinitialiser</a>
            @endif
        </form>
    </div>
</section>

{{-- Products grid --}}
<section class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex items-center justify-between mb-8">
        <p class="text-muted text-sm">{{ $products->total() }} produit{{ $products->total()>1?'s':'' }}</p>
    </div>
    @if($products->isEmpty())
        <div class="text-center py-24">
            <p class="font-serif text-3xl text-muted/50">Aucun produit trouvé</p>
            <a href="{{ route('shop.index') }}" class="text-gold text-sm mt-4 inline-block hover:text-gold-light">Voir tout</a>
        </div>
    @else
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="product-card bg-surface border border-border rounded overflow-hidden group">
            {{-- Image --}}
            <a href="{{ route('shop.show', $product->slug) }}" class="block aspect-square overflow-hidden bg-dark relative">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <img src="https://picsum.photos/seed/{{ $product->id }}/400/400"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @endif
                @if($product->stock == 0)
                    <div class="absolute inset-0 bg-noir/70 flex items-center justify-center">
                        <span class="text-xs tracking-widest uppercase text-muted">Rupture</span>
                    </div>
                @endif
            </a>
            {{-- Info --}}
            <div class="p-4">
                <p class="text-[10px] tracking-widest uppercase text-muted mb-1">{{ $product->category->name }}</p>
                <a href="{{ route('shop.show', $product->slug) }}" class="block font-serif text-lg text-cream hover:text-gold transition-colors leading-tight mb-2">{{ $product->name }}</a>
                <div class="flex items-center justify-between">
                    <span class="text-gold font-semibold">{{ number_format($product->price, 2) }} MAD</span>
                    @auth
                        @if($product->stock > 0)
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-gold/10 hover:bg-gold text-gold hover:text-noir border border-gold/30 rounded transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-10">{{ $products->links() }}</div>
    @endif
</section>
@endsection
