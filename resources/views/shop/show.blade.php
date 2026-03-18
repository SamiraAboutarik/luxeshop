@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    {{-- Breadcrumb --}}
    <nav class="text-xs text-muted tracking-widest uppercase mb-8 flex items-center gap-2">
        <a href="{{ route('shop.index') }}" class="hover:text-gold transition-colors">Boutique</a>
        <span>/</span><span class="text-cream/60">{{ $product->name }}</span>
    </nav>
    <div class="grid md:grid-cols-2 gap-12">
        {{-- Image --}}
        <div class="aspect-square bg-surface border border-border rounded overflow-hidden">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <img src="https://picsum.photos/seed/{{ $product->id }}/400/400"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            @endif
        </div>
        {{-- Details --}}
        <div class="flex flex-col gap-6">
            <div>
                <p class="text-xs tracking-[.3em] uppercase text-gold mb-2">{{ $product->category->name }}</p>
                <h1 class="font-serif text-5xl text-cream leading-tight">{{ $product->name }}</h1>
            </div>
            <div class="text-4xl font-serif text-gold">{{ number_format($product->price, 2) }} MAD</div>
            <p class="text-muted text-sm leading-relaxed">{{ $product->description ?? 'Produit de haute qualité.' }}</p>
            <div class="flex items-center gap-2 text-sm">
                @if($product->stock > 0)
                    <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                    <span class="text-emerald-400">En stock ({{ $product->stock }})</span>
                @else
                    <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                    <span class="text-red-400">Rupture de stock</span>
                @endif
            </div>
            @auth
                @if($product->stock > 0)
                <form method="POST" action="{{ route('cart.add') }}" class="flex gap-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                        class="w-20 bg-surface border border-border rounded px-3 py-3 text-sm text-cream text-center focus:border-gold focus:outline-none">
                    <button type="submit" class="btn-gold flex-1 py-3 text-xs tracking-widest uppercase font-semibold rounded">Ajouter au panier</button>
                </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-gold py-3 text-xs tracking-widest uppercase font-semibold rounded text-center block">Se connecter pour acheter</a>
            @endauth
        </div>
    </div>
    {{-- Related --}}
    @if($related->isNotEmpty())
    <div class="mt-20 border-t border-border pt-12">
        <h2 class="font-serif text-3xl text-center mb-8">Produits similaires</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($related as $p)
            <a href="{{ route('shop.show', $p->slug) }}" class="product-card bg-surface border border-border rounded overflow-hidden group">
                <div class="aspect-square bg-dark overflow-hidden">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-border" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                        </div>
                    @endif
                </div>
                <div class="p-3">
                    <p class="font-serif text-base text-cream group-hover:text-gold transition-colors">{{ $p->name }}</p>
                    <p class="text-gold text-sm mt-1">{{ number_format($p->price,2) }} MAD</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
