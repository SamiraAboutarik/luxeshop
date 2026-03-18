<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') – LuxeShop Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { serif: ['Cormorant Garamond','serif'], sans: ['Jost','sans-serif'] },
                colors: { noir:'#0a0a0a', dark:'#111111', surface:'#1a1a1a', border:'#2a2a2a', gold:'#c9a96e', 'gold-light':'#e8cfa0', cream:'#f5f0e8', muted:'#888888' }
            }}
        }
    </script>
    <style>
        * { font-family:'Jost',sans-serif; } h1,h2,h3,.font-serif { font-family:'Cormorant Garamond',serif; }
        body { background:#0a0a0a; color:#f5f0e8; }
        .sidebar-link { display:flex; align-items:center; gap:10px; padding:10px 16px; border-radius:4px; font-size:.8rem; letter-spacing:.1em; text-transform:uppercase; color:#888; transition:all .2s; }
        .sidebar-link:hover, .sidebar-link.active { background:rgba(201,169,110,.1); color:#c9a96e; }
        .stat-card { background:#1a1a1a; border:1px solid #2a2a2a; border-radius:6px; padding:24px; }
        .badge { padding:3px 10px; border-radius:20px; font-size:.7rem; font-weight:600; letter-spacing:.05em; }
        .badge-warning { background:rgba(251,191,36,.15); color:#fbbf24; }
        .badge-info { background:rgba(96,165,250,.15); color:#60a5fa; }
        .badge-primary { background:rgba(167,139,250,.15); color:#a78bfa; }
        .badge-success { background:rgba(52,211,153,.15); color:#34d399; }
        .badge-danger { background:rgba(239,68,68,.15); color:#f87171; }
        .btn-gold { background:#c9a96e; color:#0a0a0a; transition:all .3s; }
        .btn-gold:hover { background:#e8cfa0; }
        .alert-success { background:rgba(52,211,153,.1); border:1px solid rgba(52,211,153,.3); color:#6ee7b7; }
        @keyframes fadeIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}} .fade-in{animation:fadeIn .4s ease}
    </style>
</head>
<body class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-60 flex-shrink-0 bg-dark border-r border-border flex flex-col">
        <div class="p-6 border-b border-border">
            <a href="{{ route('shop.index') }}" class="block">
                <div class="text-xl font-serif text-gold tracking-widest">LUXE</div>
                <div class="text-[10px] text-muted tracking-[.3em] uppercase mt-0.5">Administration</div>
            </a>
        </div>
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                Tableau de bord
            </a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                Produits
            </a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Commandes
            </a>
            <a href="{{ route('shop.index') }}" class="sidebar-link">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Voir la boutique
            </a>
        </nav>
        <div class="p-4 border-t border-border">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-surface border border-border flex items-center justify-center text-gold text-xs font-bold">{{ substr(auth()->user()->name,0,1) }}</div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs text-cream truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-muted">Administrateur</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" title="Déconnexion" class="text-muted hover:text-gold transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-14 border-b border-border bg-dark flex items-center px-6">
            <h1 class="text-sm font-semibold tracking-wider uppercase text-muted">@yield('title', 'Dashboard')</h1>
        </header>
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="alert-success px-4 py-3 rounded text-sm fade-in mb-4">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
