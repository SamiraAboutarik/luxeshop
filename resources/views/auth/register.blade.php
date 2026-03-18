@extends('layouts.app')
@section('title', 'Inscription')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="w-full max-w-md fade-in">
        <div class="text-center mb-10">
            <h1 class="font-serif text-4xl text-gold">Créer un compte</h1>
            <p class="text-muted text-sm mt-2 tracking-wider">Rejoignez notre communauté</p>
        </div>
        <div class="bg-surface border border-border rounded p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                @foreach([['name','Nom complet','text','Jean Dupont'],['email','Adresse email','email','vous@example.com'],['password','Mot de passe','password','••••••••'],['password_confirmation','Confirmer le mot de passe','password','••••••••']] as [$field,$label,$type,$placeholder])
                <div>
                    <label class="block text-xs tracking-widest uppercase text-muted mb-2">{{ $label }}</label>
                    <input type="{{ $type }}" name="{{ $field }}" @if($type!='password') value="{{ old($field) }}" @endif required
                        class="w-full bg-dark border border-border rounded px-4 py-3 text-sm text-cream focus:border-gold focus:outline-none transition-colors placeholder-muted/50"
                        placeholder="{{ $placeholder }}">
                    @error($field)<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                @endforeach
                <button type="submit" class="btn-gold w-full py-3 text-xs tracking-widest uppercase font-semibold rounded">Créer mon compte</button>
            </form>
            <p class="text-center text-muted text-sm mt-6">
                Déjà un compte ? <a href="{{ route('login') }}" class="text-gold hover:text-gold-light transition-colors">Se connecter</a>
            </p>
        </div>
    </div>
</div>
@endsection
