@extends('layouts.app')
@section('title', 'Finaliser la commande')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <h1 class="font-serif text-4xl text-cream mb-8">Finaliser la commande</h1>
    <div class="grid lg:grid-cols-5 gap-8">
        {{-- Form --}}
        <div class="lg:col-span-3">
            <form method="POST" action="{{ route('checkout.store') }}" class="space-y-5">
                @csrf
                <div class="bg-surface border border-border rounded p-6">
                    <h2 class="font-serif text-xl mb-5 text-gold">Informations de livraison</h2>
                    @foreach([['shipping_address','Adresse','text','12 Rue Mohammed V'],['shipping_city','Ville','text','Agadir'],['shipping_phone','Téléphone','tel','+212 6XX XXX XXX']] as [$name,$label,$type,$placeholder])
                    <div class="mb-4">
                        <label class="block text-xs tracking-widest uppercase text-muted mb-2">{{ $label }}</label>
                        <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name) }}" required placeholder="{{ $placeholder }}"
                            class="w-full bg-dark border border-border rounded px-4 py-3 text-sm text-cream focus:border-gold focus:outline-none placeholder-muted/50">
                        @error($name)<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    @endforeach
                    <div>
                        <label class="block text-xs tracking-widest uppercase text-muted mb-2">Notes (optionnel)</label>
                        <textarea name="notes" rows="3" placeholder="Instructions spéciales..."
                            class="w-full bg-dark border border-border rounded px-4 py-3 text-sm text-cream focus:border-gold focus:outline-none placeholder-muted/50 resize-none">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn-gold w-full py-4 text-sm tracking-widest uppercase font-semibold rounded">Confirmer la commande</button>
            </form>
        </div>
        {{-- Order summary --}}
        <div class="lg:col-span-2">
            <div class="bg-surface border border-border rounded p-6 sticky top-20">
                <h2 class="font-serif text-xl mb-5">Votre commande</h2>
                <div class="space-y-3 text-sm mb-4">
                    @foreach($items as $item)
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-cream">{{ $item->product->name }}</p>
                            <p class="text-muted text-xs">× {{ $item->quantity }}</p>
                        </div>
                        <span class="text-gold">{{ number_format($item->quantity * $item->product->price,2) }} MAD</span>
                    </div>
                    @endforeach
                </div>
                <div class="border-t border-border pt-4 flex justify-between font-semibold">
                    <span>Total</span>
                    <span class="text-gold text-xl font-serif">{{ number_format($total,2) }} MAD</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
