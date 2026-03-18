@extends('layouts.admin')
@section('title', 'Produits')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="font-serif text-2xl">Gestion des produits</h2>
    <a href="{{ route('admin.products.create') }}" class="btn-gold px-5 py-2 text-xs tracking-widest uppercase font-semibold rounded">+ Nouveau produit</a>
</div>
<div class="bg-surface border border-border rounded overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-border">
                <th class="text-left px-4 py-3 text-xs tracking-widest uppercase text-muted">Produit</th>
                <th class="text-left px-4 py-3 text-xs tracking-widest uppercase text-muted">Catégorie</th>
                <th class="text-left px-4 py-3 text-xs tracking-widest uppercase text-muted">Prix</th>
                <th class="text-left px-4 py-3 text-xs tracking-widest uppercase text-muted">Stock</th>
                <th class="text-left px-4 py-3 text-xs tracking-widest uppercase text-muted">Statut</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-border">
            @foreach($products as $product)
            <tr class="hover:bg-dark/30 transition-colors">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-dark rounded overflow-hidden flex-shrink-0">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <img src="https://picsum.photos/seed/{{ $product->id }}/400/400"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @endif
                        </div>
                        <span class="text-cream font-medium">{{ $product->name }}</span>
                    </div>
                </td>
                <td class="px-4 py-3 text-muted">{{ $product->category->name }}</td>
                <td class="px-4 py-3 text-gold font-semibold">{{ number_format($product->price,2) }} MAD</td>
                <td class="px-4 py-3">
                    <span class="{{ $product->stock < 5 ? 'text-red-400' : 'text-emerald-400' }}">{{ $product->stock }}</span>
                </td>
                <td class="px-4 py-3">
                    @if($product->is_active)
                        <span class="badge badge-success">Actif</span>
                    @else
                        <span class="badge badge-danger">Inactif</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3 justify-end">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-muted hover:text-gold transition-colors text-xs tracking-wider uppercase">Modifier</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Supprimer ce produit ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-muted hover:text-red-400 transition-colors text-xs tracking-wider uppercase">Supprimer</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-4 py-4 border-t border-border">{{ $products->links() }}</div>
</div>
@endsection
