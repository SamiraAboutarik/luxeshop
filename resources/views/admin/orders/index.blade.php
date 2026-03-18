@extends('layouts.admin')
@section('title', 'Commandes')
@section('content')
<h2 class="font-serif text-2xl mb-6">Gestion des commandes</h2>
<div class="bg-surface border border-border rounded overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-border">
                <th class="text-left px-4 py-3 text-xs tracking-widest uppercase text-muted">#</th>
                <th class="text-left px-4 py-3 text-xs tracking-widest uppercase text-muted">Client</th>
                <th class="text-left px-4 py-3 text-xs tracking-widest uppercase text-muted">Total</th>
                <th class="text-left px-4 py-3 text-xs tracking-widest uppercase text-muted">Statut</th>
                <th class="text-left px-4 py-3 text-xs tracking-widest uppercase text-muted">Date</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-border">
            @foreach($orders as $order)
            <tr class="hover:bg-dark/30 transition-colors">
                <td class="px-4 py-3 text-muted font-mono text-xs">#{{ $order->id }}</td>
                <td class="px-4 py-3">
                    <p class="text-cream">{{ $order->user->name }}</p>
                    <p class="text-muted text-xs">{{ $order->user->email }}</p>
                </td>
                <td class="px-4 py-3 text-gold font-semibold">{{ number_format($order->total,2) }} MAD</td>
                <td class="px-4 py-3"><span class="badge {{ $order->status_badge }}">{{ $order->status }}</span></td>
                <td class="px-4 py-3 text-muted text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-gold text-xs hover:text-gold-light transition-colors tracking-wider uppercase">Détails →</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-4 py-4 border-t border-border">{{ $orders->links() }}</div>
</div>
@endsection
