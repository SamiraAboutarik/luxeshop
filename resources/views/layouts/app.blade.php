<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LUXE SHOP') – Boutique Premium</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { serif: ['Cormorant Garamond','serif'], sans: ['Jost','sans-serif'] },
                    colors: {
                        noir: '#0a0a0a', dark: '#111111', surface: '#1a1a1a',
                        border: '#2a2a2a', gold: '#c9a96e', 'gold-light': '#e8cfa0',
                        cream: '#f5f0e8', muted: '#888888',
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Jost', sans-serif; }
        h1,h2,h3,.font-serif { font-family: 'Cormorant Garamond', serif; }
        body { background: #0a0a0a; color: #f5f0e8; }
        .gold-border { border: 1px solid #c9a96e; }
        .btn-gold { background: #c9a96e; color: #0a0a0a; transition: all .3s; }
        .btn-gold:hover { background: #e8cfa0; transform: translateY(-1px); }
        .product-card { transition: transform .3s, box-shadow .3s; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(201,169,110,.15); }
        .nav-link { transition: color .2s; position: relative; }
        .nav-link::after { content:''; position:absolute; bottom:-2px; left:0; width:0; height:1px; background:#c9a96e; transition:width .3s; }
        .nav-link:hover::after, .nav-link.active::after { width:100%; }
        .alert-success { background: rgba(52,211,153,.1); border: 1px solid rgba(52,211,153,.3); color: #6ee7b7; }
        .alert-error { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); color: #fca5a5; }
        ::-webkit-scrollbar { width: 6px; } ::-webkit-scrollbar-track { background: #111; } ::-webkit-scrollbar-thumb { background: #c9a96e; border-radius: 3px; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
        .fade-in { animation: fadeIn .5s ease forwards; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">

{{-- Navbar --}}
<nav class="sticky top-0 z-50 bg-noir/95 backdrop-blur-sm border-b border-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('shop.index') }}" class="flex items-center gap-2 group">
                <span class="text-2xl font-serif text-gold tracking-widest">LUXE</span>
                <span class="text-xs font-sans font-300 text-muted tracking-[.3em] uppercase mt-1">SHOP</span>
            </a>

            {{-- Nav links --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('shop.index') }}" class="nav-link text-sm tracking-widest uppercase text-cream/80 hover:text-cream {{ request()->routeIs('shop.index') ? 'active' : '' }}">Boutique</a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-sm tracking-widest uppercase text-gold hover:text-gold-light">Admin</a>
                    @endif
                @endauth
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-4">
                @auth
                    {{-- Cart --}}
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-cream/70 hover:text-gold transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @php $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity'); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-gold text-noir text-[10px] font-bold rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                    {{-- User dropdown --}}
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-sm text-cream/70 hover:text-cream transition-colors">
                            <span class="w-7 h-7 rounded-full bg-surface border border-border flex items-center justify-center text-gold text-xs font-semibold">{{ substr(auth()->user()->name,0,1) }}</span>
                            <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                        </button>
                        <div class="absolute right-0 top-full mt-2 w-48 bg-surface border border-border rounded-sm shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-cream/70 hover:text-cream hover:bg-white/5 transition-colors">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm tracking-widest uppercase text-cream/70 hover:text-gold transition-colors">Connexion</a>
                    <a href="{{ route('register') }}" class="btn-gold px-4 py-2 text-xs tracking-widest uppercase font-semibold rounded-sm">Inscription</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Flash messages --}}
<div class="max-w-7xl mx-auto w-full px-4 pt-4">
    @if(session('success'))
        <div class="alert-success px-4 py-3 rounded-sm text-sm fade-in flex items-center gap-2 mb-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-error px-4 py-3 rounded-sm text-sm fade-in flex items-center gap-2 mb-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif
</div>

{{-- Main --}}
<main class="flex-1">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="border-t border-border mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <span class="text-xl font-serif text-gold tracking-widest">LUXE SHOP</span>
                <p class="text-muted text-xs mt-1 tracking-wider">L'excellence à portée de main</p>
            </div>
            <p class="text-muted text-xs tracking-wider">© {{ date('Y') }} LuxeShop – Tous droits réservés</p>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
