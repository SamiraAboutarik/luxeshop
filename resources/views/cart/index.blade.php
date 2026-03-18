@extends('layouts.app')
@section('title', 'Mon Panier')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <h1 class="font-serif text-4xl text-cream mb-8">Mon Panier</h1>
    @if($items->isEmpty())
        <div class="text-center py-24 border border-border rounded bg-surface">
            <svg class="w-12 h-12 text-muted mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <p class="font-serif text-2xl text-muted/60">Votre panier est vide</p>
            <a href="{{ route('shop.index') }}" class="btn-gold inline-block mt-6 px-8 py-3 text-xs tracking-widest uppercase font-semibold rounded">Continuer mes achats</a>
        </div>
    @else
    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-3">
            @foreach($items as $item)
            <div class="bg-surface border border-border rounded p-4 flex gap-4 items-center fade-in">
                <div class="w-16 h-16 bg-dark rounded overflow-hidden flex-shrink-0">
                    @if($item->product->image)
                        <img src="{{ asset('storage/'.$item->product->image) }}" alt="" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center"><svg class="w-6 h-6 text-border" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16"/></svg></div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-serif text-lg text-cream truncate">{{ $item->product->name }}</p>
                    <p class="text-gold text-sm">{{ number_format($item->product->price,2) }} MAD</p>
                </div>
                <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                    @csrf @method('PATCH')
                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                        class="w-16 bg-dark border border-border rounded px-2 py-1.5 text-sm text-cream text-center focus:border-gold focus:outline-none"
                        onchange="this.form.submit()">
                </form>
                <p class="text-cream font-semibold w-28 text-right text-sm">{{ number_format($item->quantity * $item->product->price,2) }} MAD</p>
                <form method="POST" action="{{ route('cart.remove', $item) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-muted hover:text-red-400 transition-colors p-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </form>
            </div>
            @endforeach
            <form method="POST" action="{{ route('cart.clear') }}" class="flex justify-end">
                @csrf @method('DELETE')
                <button type="submit" class="text-muted text-xs hover:text-red-400 transition-colors tracking-wider uppercase">Vider le panier</button>
            </form>
        </div>
        {{-- Summary --}}
        <div class="bg-surface border border-border rounded p-6 h-fit sticky top-20">
            <h2 class="font-serif text-2xl mb-6">Récapitulatif</h2>
            <div class="space-y-3 text-sm mb-6">
                @foreach($items as $item)
                <div class="flex justify-between text-muted">
                    <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                    <span>{{ number_format($item->quantity * $item->product->price,2) }}</span>
                </div>
                @endforeach
                <div class="border-t border-border pt-3 flex justify-between font-semibold text-cream">
                    <span>Total</span>
                    <span class="text-gold text-lg">{{ number_format($total,2) }} MAD</span>
                </div>
            </div>
            <a href="{{ route('checkout.index') }}" class="btn-gold w-full block py-3 text-xs tracking-widest uppercase font-semibold rounded text-center">Commander →</a>
            <a href="{{ route('shop.index') }}" class="block text-center text-muted text-xs mt-3 hover:text-cream transition-colors tracking-wider">Continuer mes achats</a>
        </div>
    </div>
    @endif
</div>
@endsection
