<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Circle Concordia Coffee (C3)</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Fraunces"', 'serif'],
                        sans: ['"DM Sans"', 'sans-serif'],
                    },
                    colors: {
                        forest: {
                            DEFAULT: '#1F3A2E',
                            light: '#2B4F3F',
                            dark: '#14271F',
                        },
                        cream: '#F6F1E7',
                        espresso: '#2B2118',
                        amberCustom: '#D9A05B',
                        sand: '#EDE4D3',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-stone-100 text-espresso font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Top Navigation Header -->
    <header class="bg-forest text-cream border-b border-forest-light sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Left: Brand -->
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 rounded-full bg-cream text-forest flex items-center justify-center font-serif font-bold text-lg shadow">
                        C3
                    </div>
                    <div>
                        <span class="font-serif font-bold text-lg text-cream block leading-tight">Circle Concordia</span>
                        <span class="text-[9px] text-amberCustom uppercase tracking-widest block">Dashboard Sistem</span>
                    </div>
                </a>

                <div class="hidden sm:block h-6 w-px bg-forest-light mx-2"></div>

                <a href="{{ route('home') }}" class="hidden sm:inline-block text-xs text-cream/70 hover:text-amberCustom transition-colors">
                    🌐 Lihat Website Depan
                </a>
            </div>

            <!-- Right: User Info & Actions -->
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <span class="text-xs font-bold text-cream block">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-amberCustom font-medium">
                        {{ auth()->user()->role_label }}
                    </span>
                </div>

                <!-- Role Pill -->
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider
                    @if(auth()->user()->role === 'admin') bg-rose-900/80 text-rose-200 border border-rose-700
                    @elseif(auth()->user()->role === 'kasir') bg-blue-900/80 text-blue-200 border border-blue-700
                    @elseif(auth()->user()->role === 'petani') bg-emerald-900/80 text-emerald-200 border border-emerald-700
                    @else bg-amber-900/80 text-amber-200 border border-amber-700
                    @endif">
                    {{ auth()->user()->role }} • Lvl {{ auth()->user()->level }}
                </span>

                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 rounded-lg bg-forest-light hover:bg-rose-900 text-cream text-xs flex items-center gap-1 transition-colors" title="Keluar Akun">
                        <span>🚪</span>
                        <span class="hidden md:inline">Keluar</span>
                    </button>
                </form>
            </div>

        </div>
    </header>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-1">
        
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-2 shadow-sm">
                <span class="font-bold text-base">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-center gap-2 shadow-sm">
                <span class="font-bold text-base">⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-stone-200 py-4 text-center text-xs text-stone-500">
        <p>&copy; {{ date('Y') }} Circle Concordia Coffee (C3). Sistem Informasi Manajemen Basis Data.</p>
    </footer>

</body>
</html>
