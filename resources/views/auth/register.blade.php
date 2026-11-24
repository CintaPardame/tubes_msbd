<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Konsumen - Circle Concordia Coffee (C3)</title>

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
    <div class="max-w-lg w-full mx-auto text-center mb-6">
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

    <!-- Register Card -->
    <div class="max-w-lg w-full mx-auto bg-white p-8 sm:p-10 rounded-3xl shadow-lg border border-sand">
        
        <div class="mb-6 text-center">
            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold uppercase tracking-wider inline-block mb-2">
                Pendaftaran Akun Konsumen (Level 3)
            </span>
            <h1 class="font-serif font-bold text-2xl sm:text-3xl text-forest">Buat Akun Pemesan</h1>
            <p class="text-xs text-stone-500 mt-1">Daftar untuk memesan biji kopi nusantara kemasan 1 kg secara online</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold text-forest mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-forest text-espresso @error('name') border-rose-500 @enderror"
                       placeholder="Contoh: Budi Pratama">
                @error('name')
                    <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-forest mb-1">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-forest text-espresso @error('email') border-rose-500 @enderror"
                       placeholder="nama@email.com">
                @error('email')
                    <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-semibold text-forest mb-1">Nomor WhatsApp / HP</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                           class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-forest text-espresso @error('phone') border-rose-500 @enderror"
                           placeholder="081234567890">
                    @error('phone')
                        <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-xs font-semibold text-forest mb-1">Alamat Pengiriman</label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}" required
                           class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-forest text-espresso @error('address') border-rose-500 @enderror"
                           placeholder="Kota & Alamat Lengkap">
                    @error('address')
                        <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-semibold text-forest mb-1">Kata Sandi</label>
                    <input type="password" id="password" name="password" required
                           class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-forest text-espresso @error('password') border-rose-500 @enderror"
                           placeholder="Min. 6 karakter">
                    @error('password')
                        <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-forest mb-1">Konfirmasi Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-forest text-espresso"
                           placeholder="Ulangi sandi">
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-full bg-forest hover:bg-forest-light text-cream font-medium text-xs tracking-wider uppercase transition-all shadow-md mt-4 flex items-center justify-center gap-2">
                <span>Daftar Sekarang</span>
                <span class="text-amberCustom">→</span>
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-sand/70 text-center text-xs text-stone-500">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-semibold text-amber-800 hover:text-forest underline underline-offset-2">
                Masuk di sini
            </a>
        </div>

    </div>

    <!-- Bottom Return Link -->
    <div class="max-w-md w-full mx-auto text-center mt-6 text-xs text-stone-500">
        <a href="{{ route('home') }}" class="hover:text-forest transition-colors">
            ← Kembali ke Halaman Utama
        </a>
    </div>

</body>
</html>
