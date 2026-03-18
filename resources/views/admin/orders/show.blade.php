@extends('layouts.admin')
@section('title', 'Commande #'.$order->id)
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-muted hover:text-gold transition-colors">← Retour</a>
        <h2 class="font-serif text-2xl">Commande #{{ $order->id }}</h2>
        <span class="badge {{ $order->status_badge }}">{{ $order->status }}</span>
    </div>
    <div class="grid md:grid-cols-2 gap-6 mb-6">
        {{-- Client info --}}
        <div class="bg-surface border border-border rounded p-5">
            <h3 class="text-xs tracking-widest uppercase text-muted mb-3">Client</h3>
            <p class="text-cream font-medium">{{ $order->user->name }}</p>
            <p class="text-muted text-sm">{{ $order->user->email }}</p>
        </div>
        {{-- Shipping --}}
        <div class="bg-surface border border-border rounded p-5">
            <h3 class="text-xs tracking-widest uppercase text-muted mb-3">Livraison</h3>
            <p class="text-cream text-sm">{{ $order->shipping_address }}</p>
            <p class="text-cream text-sm">{{ $order->shipping_city }}</p>
            <p class="text-muted text-sm">{{ $order->shipping_phone }}</p>
        </div>
    </div>
    {{-- Items --}}
    <div class="bg-surface border border-border rounded p-5 mb-6">
        <h3 class="text-xs tracking-widest uppercase text-muted mb-4">Articles</h3>
        <div class="space-y-3">
            @foreach($order->items as $item)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-dark rounded overflow-hidden flex-shrink-0">
                        @if($item->product->image)
                            <img src="{{ asset('storage/'.$item->product->image) }}" class="w-full h-full object-cover" alt="">
                        @endif
                    </div>
                    <div>
                        <p class="text-cream text-sm">{{ $item->product->name }}</p>
                        <p class="text-muted text-xs">× {{ $item->quantity }} × {{ number_format($item->unit_price,2) }} MAD</p>
                    </div>
                </div>
                <span class="text-gold font-semibold text-sm">{{ number_format($item->subtotal,2) }} MAD</span>
            </div>
            @endforeach
        </div>
        <div class="border-t border-border mt-4 pt-4 flex justify-between font-semibold">
            <span class="text-muted text-sm">Total</span>
            <span class="text-gold text-lg font-serif">{{ number_format($order->total,2) }} MAD</span>
        </div>
    </div>
    {{-- Status update --}}
    <div class="bg-surface border border-border rounded p-5">
        <h3 class="text-xs tracking-widest uppercase text-muted mb-4">Mettre à jour le statut</h3>
        <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex gap-3">
            @csrf @method('PATCH')
            <select name="status" class="flex-1 bg-dark border border-border rounded px-4 py-2 text-sm text-cream focus:border-gold focus:outline-none">
                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status==$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-gold px-6 py-2 text-xs tracking-widest uppercase font-semibold rounded">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection
