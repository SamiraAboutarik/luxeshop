@extends('layouts.app')
@section('title', 'Connexion')
@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="w-full max-w-md fade-in">
        <div class="text-center mb-10">
            <h1 class="font-serif text-4xl text-gold">Connexion</h1>
            <p class="text-muted text-sm mt-2 tracking-wider">Bienvenue de retour</p>
        </div>
        <div class="bg-surface border border-border rounded p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs tracking-widest uppercase text-muted mb-2">Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-dark border border-border rounded px-4 py-3 text-sm text-cream focus:border-gold focus:outline-none transition-colors placeholder-muted/50"
                        placeholder="vous@example.com">
                    @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs tracking-widest uppercase text-muted mb-2">Mot de passe</label>
                    <input type="password" name="password" required
                        class="w-full bg-dark border border-border rounded px-4 py-3 text-sm text-cream focus:border-gold focus:outline-none transition-colors placeholder-muted/50"
                        placeholder="••••••••">
                    @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="accent-gold">
                    <label for="remember" class="text-xs text-muted">Se souvenir de moi</label>
                </div>
                <button type="submit" class="btn-gold w-full py-3 text-xs tracking-widest uppercase font-semibold rounded">Se connecter</button>
            </form>
            <p class="text-center text-muted text-sm mt-6">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-gold hover:text-gold-light transition-colors">S'inscrire</a>
            </p>
        </div>
    </div>
</div>
@endsection
