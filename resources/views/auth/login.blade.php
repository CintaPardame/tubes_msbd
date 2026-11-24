<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Circle Concordia Coffee (C3)</title>

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
<body class="bg-cream text-espresso font-sans antialiased min-h-screen flex flex-col justify-between py-8 px-4">

    <!-- Header Logo -->
    <div class="max-w-md w-full mx-auto text-center mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
            <div class="w-12 h-12 rounded-full bg-forest text-amberCustom flex items-center justify-center font-serif font-bold text-2xl shadow-md group-hover:scale-105 transition-transform">
                C<span class="text-xs text-white">3</span>
            </div>
            <div class="text-left">
                <span class="font-serif font-bold text-2xl text-forest tracking-tight block">Circle Concordia</span>
                <span class="text-[10px] tracking-widest uppercase text-amber-800 font-semibold block -mt-1">Specialty Coffee Roasters</span>
            </div>
        </a>
    </div>

    <!-- Login Card -->
    <div class="max-w-md w-full mx-auto bg-white p-8 rounded-3xl shadow-lg border border-sand">
        
        <div class="mb-6 text-center">
            <h1 class="font-serif font-bold text-2xl sm:text-3xl text-forest">Selamat Datang</h1>
            <p class="text-xs text-stone-500 mt-1">Silakan masuk ke akun Anda untuk mengakses sistem</p>
        </div>

        @if(session('error'))
            <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start gap-2">
                <span class="font-bold">⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-start gap-2">
                <span class="font-bold">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-semibold text-forest mb-1">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-forest text-espresso @error('email') border-rose-500 @enderror"
                       placeholder="nama@email.com">
                @error('email')
                    <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-xs font-semibold text-forest">Kata Sandi (Password)</label>
                </div>
                <input type="password" id="password" name="password" required
                       class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-forest text-espresso"
                       placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-xs text-stone-600">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-sand text-forest focus:ring-forest">
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-full bg-forest hover:bg-forest-light text-cream font-medium text-xs tracking-wider uppercase transition-all shadow-md mt-2 flex items-center justify-center gap-2">
                <span>Masuk Sekarang</span>
                <span class="text-amberCustom">→</span>
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-sand/70 text-center text-xs text-stone-500">
            Belum memiliki akun konsumen? 
            <a href="{{ route('register') }}" class="font-semibold text-amber-800 hover:text-forest underline underline-offset-2">
                Daftar sebagai Konsumen
            </a>
        </div>

        <!-- Role Quick Access Helper (Sangat berguna untuk pengujian Dosen & Praktikum MSBD) -->
        <div class="mt-8 pt-5 border-t border-sand bg-stone-50 -mx-8 -mb-8 p-6 rounded-b-3xl text-left border-stone-200">
            <span class="text-[11px] font-bold text-forest uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                <span>🔐</span> Akun Uji Coba (4 Role & 3 Level):
            </span>
            <div class="grid grid-cols-2 gap-2 text-[11px]">
                <button type="button" onclick="fillLogin('admin@c3coffee.com', 'password')" class="p-2 bg-white rounded-lg border border-sand hover:border-forest text-left">
                    <span class="font-bold text-forest block">1. Admin (Lvl 1)</span>
                    <span class="text-stone-400 text-[10px]">admin@c3coffee.com</span>
                </button>
                <button type="button" onclick="fillLogin('kasir@c3coffee.com', 'password')" class="p-2 bg-white rounded-lg border border-sand hover:border-forest text-left">
                    <span class="font-bold text-forest block">2. Kasir (Lvl 2)</span>
                    <span class="text-stone-400 text-[10px]">kasir@c3coffee.com</span>
                </button>
                <button type="button" onclick="fillLogin('petani@c3coffee.com', 'password')" class="p-2 bg-white rounded-lg border border-sand hover:border-forest text-left">
                    <span class="font-bold text-forest block">3. Petani (Lvl 2)</span>
                    <span class="text-stone-400 text-[10px]">petani@c3coffee.com</span>
                </button>
                <button type="button" onclick="fillLogin('user@c3coffee.com', 'password')" class="p-2 bg-white rounded-lg border border-sand hover:border-forest text-left">
                    <span class="font-bold text-forest block">4. Konsumen (Lvl 3)</span>
                    <span class="text-stone-400 text-[10px]">user@c3coffee.com</span>
                </button>
            </div>
            <p class="text-[10px] text-stone-500 mt-2 text-center">Password untuk semua akun: <code class="font-bold text-forest">password</code> (Klik untuk autofill)</p>
        </div>

    </div>

    <!-- Bottom Return Link -->
    <div class="max-w-md w-full mx-auto text-center mt-6 text-xs text-stone-500">
        <a href="{{ route('home') }}" class="hover:text-forest transition-colors">
            ← Kembali ke Halaman Utama
        </a>
    </div>

    <script>
        function fillLogin(email, pass) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
        }
    </script>
</body>
</html>
