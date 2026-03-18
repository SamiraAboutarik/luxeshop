@extends('layouts.admin')
@section('title', 'Tableau de bord')
@section('content')
{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    @php
    $statCards = [
        ['label'=>'Commandes total','value'=>$stats['total_orders'],'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','color'=>'text-blue-400'],
        ['label'=>'En attente','value'=>$stats['pending_orders'],'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'text-yellow-400'],
        ['label'=>'Revenu total','value'=>number_format($stats['total_revenue'],0).' MAD','icon'=>'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'text-gold'],
        ['label'=>'Produits','value'=>$stats['total_products'],'icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10','color'=>'text-purple-400'],
        ['label'=>'Clients','value'=>$stats['total_users'],'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0','color'=>'text-emerald-400'],
        ['label'=>'Stock faible','value'=>$stats['low_stock'],'icon'=>'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z','color'=>'text-red-400'],
    ];
    @endphp
    @foreach($statCards as $card)
    <div class="stat-card fade-in">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs tracking-widest uppercase text-muted mb-1">{{ $card['label'] }}</p>
                <p class="text-2xl font-serif {{ $card['color'] }}">{{ $card['value'] }}</p>
            </div>
            <svg class="w-5 h-5 {{ $card['color'] }} opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $card['icon'] }}"/>
            </svg>
        </div>
    </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-2 gap-6">
    {{-- Recent orders --}}
    <div class="bg-surface border border-border rounded p-5">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-serif text-xl">Commandes récentes</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-gold text-xs hover:text-gold-light transition-colors tracking-wider">Voir tout →</a>
        </div>
        <div class="space-y-2">
            @foreach($recent_orders as $order)
            <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-3 rounded hover:bg-dark/50 transition-colors group">
                <div>
                    <p class="text-sm text-cream group-hover:text-gold transition-colors">#{{ $order->id }} — {{ $order->user->name }}</p>
                    <p class="text-xs text-muted">{{ $order->created_at->diffForHumans() }}</p>
                </div>
                <div class="text-right">
                    <p class="text-gold text-sm font-semibold">{{ number_format($order->total,2) }}</p>
                    <span class="badge badge-{{ str_replace('badge-','',$order->status_badge) }}">{{ $order->status }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    {{-- Top products --}}
    <div class="bg-surface border border-border rounded p-5">
        <h2 class="font-serif text-xl mb-4">Top Produits</h2>
        <div class="space-y-3">
            @foreach($top_products as $i => $product)
            <div class="flex items-center gap-3">
                <span class="text-muted font-mono text-xs w-4">{{ $i+1 }}</span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-cream truncate">{{ $product->name }}</p>
                    <div class="h-1 bg-dark rounded mt-1">
                        <div class="h-1 bg-gold rounded" style="width:{{ $top_products->first()->order_items_count > 0 ? ($product->order_items_count/$top_products->first()->order_items_count*100) : 0 }}%"></div>
                    </div>
                </div>
                <span class="text-muted text-xs">{{ $product->order_items_count }} ventes</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
