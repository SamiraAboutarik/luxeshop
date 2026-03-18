@extends('layouts.app')
@section('title', 'Commande confirmée')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-20 text-center fade-in">
    <div class="w-16 h-16 bg-gold/10 border border-gold/30 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
    </div>
    <h1 class="font-serif text-5xl text-cream mb-3">Commande confirmée !</h1>
    <p class="text-muted mb-8">Merci pour votre achat. Nous traitons votre commande.</p>
    @if($order)
    <div class="bg-surface border border-border rounded p-6 text-left mb-8">
        <div class="flex justify-between items-center mb-4">
            <span class="text-xs tracking-widest uppercase text-muted">Commande #{{ $order->id }}</span>
            <span class="text-gold font-semibold">{{ number_format($order->total,2) }} MAD</span>
        </div>
        @foreach($order->items as $item)
        <div class="flex justify-between text-sm py-2 border-t border-border/50">
            <span class="text-cream">{{ $item->product->name }} × {{ $item->quantity }}</span>
            <span class="text-muted">{{ number_format($item->subtotal,2) }} MAD</span>
        </div>
        @endforeach
    </div>
    @endif
    <a href="{{ route('shop.index') }}" class="btn-gold inline-block px-10 py-4 text-xs tracking-widest uppercase font-semibold rounded">Continuer mes achats</a>
</div>
@endsection
