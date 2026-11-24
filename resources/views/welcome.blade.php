<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profile->name ?? 'Circle Concordia Coffee' }} ({{ $profile->short_name ?? 'C3' }}) - Specialty Coffee Beans</title>

    <!-- Google Fonts: Fraunces & DM Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (via Vite) & Tailwind CDN Configured for Custom Color Palette -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
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
                            deep: '#0E1B15',
                        },
                        cream: {
                            DEFAULT: '#F6F1E7',
                            light: '#FAF7F2',
                            dark: '#EDE5D6',
                        },
                        espresso: {
                            DEFAULT: '#2B2118',
                            muted: '#5A4A3E',
                            light: '#7A685B',
                        },
                        amberCustom: {
                            DEFAULT: '#D9A05B',
                            dark: '#8F5A1C',
                            light: '#F4DEC1',
                        },
                        sand: {
                            DEFAULT: '#EDE4D3',
                            card: '#E8DDC8',
                            light: '#F3ECE0',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #F6F1E7;
            color: #2B2118;
        }
        .arch-frame {
            border-top-left-radius: 180px;
            border-top-right-radius: 180px;
        }
    </style>
</head>
<body class="font-sans antialiased selection:bg-forest selection:text-cream">

    <!-- Flash Notifications (jika ada) -->
    @if(session('success'))
        <div class="bg-emerald-700 text-white text-xs py-2.5 px-4 text-center font-medium shadow-sm flex items-center justify-center gap-2">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 1. TOP ANNOUNCEMENT BAR -->
    <div class="bg-forest text-cream text-[12px] py-2 px-4 text-center font-medium border-b border-forest-light tracking-wide flex items-center justify-center gap-2">
        <span class="w-2 h-2 rounded-full bg-amberCustom animate-pulse"></span>
        <span>Pemesanan Biji Kopi Specialty Per Paket (1 Paket = 1 kg / 1.000 gram) • Wajib Login Sebagai Konsumen</span>
    </div>

    <!-- 2. NAVBAR (Tombol Login di Pojok Kanan Atas) -->
    <header class="sticky top-0 z-50 bg-[#F6F1E7]/95 backdrop-blur-md border-b border-sand-DEFAULT/80 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Identity -->
            <a href="#beranda" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full bg-forest text-amberCustom flex items-center justify-center font-serif font-bold text-xl shadow-md group-hover:scale-105 transition-transform">
                    C<span class="text-xs text-white">3</span>
                </div>
                <div>
                    <span class="font-serif font-bold text-xl text-forest tracking-tight block">
                        {{ $profile->name }}
                    </span>
                    <span class="text-[10px] tracking-widest uppercase text-amberCustom-dark font-semibold block -mt-1">
                        Specialty Coffee Roasters
                    </span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden lg:flex items-center gap-8 text-sm font-medium text-espresso-muted">
                <a href="#beranda" class="hover:text-forest transition-colors">Beranda</a>
                <a href="#origins" class="hover:text-forest transition-colors">Asal Biji Kopi</a>
                <a href="#populer" class="hover:text-forest transition-colors">Kopi Populer (1 kg)</a>
                <a href="#visi-misi" class="hover:text-forest transition-colors">Visi & Misi</a>
                <a href="#proses" class="hover:text-forest transition-colors">Proses Kurasi</a>
            </nav>

            <!-- POJOK KANAN ATAS: TOMBOL LOGIN & USER AUTH -->
            <div class="flex items-center gap-3">
                @auth
                    <!-- Jika Sudah Login: Tampilkan Profil Singkat & Link Dashboard -->
                    <div class="flex items-center gap-2.5 bg-white py-1.5 px-3 rounded-full border border-sand shadow-sm">
                        <div class="w-7 h-7 rounded-full bg-forest text-amberCustom flex items-center justify-center text-xs font-bold font-serif">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:block text-left text-xs leading-tight">
                            <span class="font-bold text-forest block truncate max-w-[130px]">{{ auth()->user()->name }}</span>
                            <span class="text-[10px] text-amberCustom-dark font-medium">{{ auth()->user()->role }} (Lvl {{ auth()->user()->level }})</span>
                        </div>
                        <a href="{{ route('dashboard') }}" class="ml-1 px-3 py-1 bg-forest hover:bg-forest-light text-cream rounded-full text-xs font-medium transition-colors">
                            Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-stone-400 hover:text-rose-600 p-1 text-xs" title="Keluar">
                                ✕
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Jika Belum Login: Tampilkan Tombol Login & Register di Pojok Kanan Atas -->
                    <a href="{{ route('register') }}" class="hidden sm:inline-block text-xs font-semibold text-forest hover:text-amberCustom-dark px-3 py-2">
                        Daftar Akun
                    </a>
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center gap-2 bg-forest hover:bg-forest-light text-cream font-medium text-xs sm:text-sm px-5 py-2.5 rounded-full shadow-md hover:shadow-lg transition-all hover:scale-105">
                        <svg class="w-3.5 h-3.5 text-amberCustom" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>Masuk (Login)</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- 3. HERO SECTION (Editorial Layout dengan Arch Image Frame) -->
    <section id="beranda" class="relative pt-12 pb-20 md:py-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Left Column: Editorial Headline -->
                <div class="lg:col-span-7">
                    <!-- Kicker / Tag -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-sand-DEFAULT/60 border border-sand-DEFAULT text-amberCustom-dark text-xs font-semibold tracking-wider uppercase mb-6">
                        <span>🌱</span>
                        <span>Single Origin & Specialty Blend Nusantara • Paket 1 kg</span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="font-serif font-bold text-4xl sm:text-5xl lg:text-6xl text-forest leading-[1.15] tracking-tight mb-6">
                        Kopi pilihan dari kebun langsung ke cangkir Anda.
                    </h1>

                    <!-- Paragraph -->
                    <p class="text-base sm:text-lg text-espresso-muted leading-relaxed max-w-xl mb-8">
                        {{ $profile->about }}
                    </p>

                    <!-- Buttons -->
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('orders.create') }}" 
                           class="px-7 py-3.5 rounded-full bg-forest hover:bg-forest-light text-cream font-medium text-sm shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                            <span>Pesan Paket Kopi (1 kg)</span>
                            <span class="text-amberCustom">→</span>
                        </a>
                        <a href="#origins" 
                           class="px-7 py-3.5 rounded-full bg-transparent border-2 border-forest/30 hover:border-forest text-forest font-medium text-sm transition-all">
                            Lihat Asal Kebun Kopi
                        </a>
                    </div>

                    <!-- Notice Wajib Login untuk Konsumen -->
                    <div class="mt-8 p-3.5 rounded-2xl bg-white/70 border border-sand max-w-lg flex items-center gap-3 text-xs text-espresso-muted">
                        <span class="w-8 h-8 rounded-full bg-amberCustom/20 text-amberCustom-dark flex items-center justify-center font-bold text-sm flex-shrink-0">
                            🔒
                        </span>
                        <div>
                            <strong class="text-forest block">Aturan Pemesanan Konsumen:</strong>
                            Untuk melakukan pemesanan, silakan <a href="{{ route('login') }}" class="font-bold text-amber-800 underline">login terlebih dahulu</a> sebagai akun Konsumen.
                        </div>
                    </div>
                </div>

                <!-- Right Column: Arch Framed Visual Image + Floating Badge -->
                <div class="lg:col-span-5 flex justify-center lg:justify-end relative">
                    <div class="absolute -top-6 -right-6 w-72 h-72 rounded-full bg-amberCustom/15 blur-3xl pointer-events-none"></div>

                    <div class="relative w-full max-w-[360px] sm:max-w-[400px]">
                        <!-- Arch Image Frame -->
                        <div class="arch-frame overflow-hidden bg-forest shadow-2xl border-4 border-white/60 aspect-[3/4] relative">
                            <img src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=900&auto=format&fit=crop" 
                                 alt="Specialty Coffee Roasting Beans" 
                                 class="w-full h-full object-cover object-center scale-105 hover:scale-110 transition-transform duration-700 brightness-95">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-forest-dark/80 via-transparent to-transparent"></div>
                            
                            <div class="absolute bottom-6 left-6 right-6 text-cream text-center">
                                <span class="font-serif italic text-sm text-amberCustom">Circle Concordia Coffee (C3)</span>
                                <p class="text-xs text-cream/80 font-sans mt-0.5">Penjualan Biji Kopi Per Paket (1 kg)</p>
                            </div>
                        </div>

                        <!-- Floating Badge -->
                        <div class="absolute -bottom-5 -left-4 sm:-left-6 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-sand-DEFAULT max-w-[220px]">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-amberCustom"></span>
                                <span class="text-[11px] font-bold text-forest uppercase tracking-wider">Standar Kemasan</span>
                            </div>
                            <p class="text-xs text-espresso-muted leading-snug">
                                Kemasan minimum <strong class="text-forest">1 Paket = 1 kg (1.000g)</strong> dengan *one-way valve* kedap udara.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. FOREST GREEN VALUE STRIP -->
    <section class="bg-forest text-cream py-10 border-y border-forest-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <!-- Col 1 -->
                <div class="border-b md:border-b-0 md:border-r border-forest-light pb-6 md:pb-0 md:pr-8">
                    <span class="text-amberCustom font-serif text-lg font-bold block mb-1">Asal Kebun Tertelusur</span>
                    <p class="text-xs text-cream/75 leading-relaxed">
                        Data petani produsen, varietas, dan elevasi kebun terdata lengkap dalam sistem database MSBD.
                    </p>
                </div>

                <!-- Col 2 -->
                <div class="border-b md:border-b-0 md:border-r border-forest-light pb-6 md:pb-0 md:px-8">
                    <span class="text-amberCustom font-serif text-lg font-bold block mb-1">Kemasan Paket 1 kg (1.000g)</span>
                    <p class="text-xs text-cream/75 leading-relaxed">
                        Dijual dalam satuan paket 1 kg utuh untuk memastikan mutu, aroma, dan harga terbaik langsung dari roastery.
                    </p>
                </div>

                <!-- Col 3 -->
                <div class="md:pl-8">
                    <span class="text-amberCustom font-serif text-lg font-bold block mb-1">4 Role & 3 Level Otoritas</span>
                    <p class="text-xs text-cream/75 leading-relaxed">
                        Sistem login terintegrasi untuk Admin (Lvl 1), Kasir & Petani (Lvl 2), serta Konsumen (Lvl 3).
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. SUMBER BIJI KOPI (ORIGINS / DAERAH ASAL) -->
    <section id="origins" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <span class="text-xs font-bold uppercase tracking-widest text-amberCustom-dark">Katalog Perkebunan</span>
                <h2 class="font-serif font-bold text-3xl sm:text-4xl text-forest mt-1.5">
                    Asal Biji Kopi Nusantara
                </h2>
                <p class="text-sm text-espresso-muted mt-2 max-w-2xl">
                    Jelajahi sentra perkebunan kopi nusantara dengan karakter tanah vulkanik, iklim mikro, dan profil rasa yang berbeda-beda.
                </p>
            </div>

            <!-- Origins Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($origins as $origin)
                    <div class="bg-white rounded-2xl p-6 border border-sand-DEFAULT/90 shadow-sm hover:shadow-md hover:border-amberCustom/60 transition-all flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[11px] font-bold tracking-wider uppercase text-amberCustom-dark">
                                    {{ $origin->province }}
                                </span>
                                <span class="text-[11px] font-medium text-espresso-light bg-cream-dark/60 px-2.5 py-0.5 rounded-full">
                                    ⛰️ {{ $origin->altitude }}
                                </span>
                            </div>

                            <h3 class="font-serif font-bold text-2xl text-forest group-hover:text-amberCustom-dark transition-colors">
                                {{ $origin->name }}
                            </h3>

                            <p class="text-xs text-espresso-muted mt-2.5 leading-relaxed">
                                {{ $origin->description }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-sand-DEFAULT/60 flex items-center justify-between text-xs">
                            <span class="text-forest font-medium">
                                {{ $origin->products_count }} Varian Tersedia
                            </span>
                            <a href="#populer" class="text-amberCustom-dark font-semibold hover:text-forest flex items-center gap-1">
                                <span>Lihat Biji</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 6. BIJI KOPI POPULER (HARGA MINIMUM PER PAKET 1 KG) -->
    <section id="populer" class="py-20 bg-sand-light/50 border-y border-sand-DEFAULT">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-amberCustom-dark">Harga Minimum Per Paket (1 kg)</span>
                    <h2 class="font-serif font-bold text-3xl sm:text-4xl text-forest mt-1.5">
                        Koleksi Biji Kopi Populer
                    </h2>
                    <p class="text-sm text-espresso-muted mt-2 max-w-xl">
                        Varian biji kopi yang paling banyak dipesan. Harga di bawah adalah <strong>harga minimum per 1 paket (berat bersih 1 kg)</strong>.
                    </p>
                </div>
                <div class="mt-4 md:mt-0 text-xs font-semibold text-forest bg-amberCustom/20 border border-amberCustom/40 px-4 py-2 rounded-full">
                    📦 Minimal Pemesanan: 1 Paket (1.000 gram)
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($popularProducts as $product)
                    <div class="bg-white rounded-2xl overflow-hidden border border-sand-DEFAULT shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                        
                        <!-- Product Image Container -->
                        <div class="relative h-60 overflow-hidden bg-sand-DEFAULT/30">
                            <img src="{{ $product->main_image }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex gap-1.5">
                                <span class="px-3 py-1 rounded-full bg-forest text-cream text-[11px] font-semibold tracking-wide shadow">
                                    {{ $product->category->name }}
                                </span>
                                <span class="px-2.5 py-1 rounded-full bg-white/90 backdrop-blur-sm text-amberCustom-dark text-[11px] font-bold">
                                    Best Seller
                                </span>
                            </div>

                            <div class="absolute bottom-3 right-3">
                                <span class="px-2.5 py-1 rounded-md bg-forest-dark/90 backdrop-blur-sm text-amberCustom text-[11px] font-medium">
                                    {{ $product->roast_level }} Roast
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-[11px] text-amberCustom-dark font-semibold tracking-wide uppercase mb-1">
                                    📍 {{ $product->origin->name }} • {{ $product->process_method }}
                                </div>

                                <h3 class="font-serif font-bold text-xl text-forest group-hover:text-amberCustom-dark transition-colors">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-xs text-espresso-muted mt-2 line-clamp-2 leading-relaxed">
                                    {{ $product->description }}
                                </p>

                                <!-- Flavor Notes -->
                                <div class="mt-4 pt-3 border-t border-sand-DEFAULT/60">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-espresso-light block mb-1.5">Flavor Notes:</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach(explode(',', $product->flavor_notes) as $note)
                                            <span class="px-2.5 py-0.5 rounded-full bg-cream text-forest text-[11px] font-medium border border-sand-DEFAULT">
                                                {{ trim($note) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Price & Order CTA (Mengarahkan ke Order dengan Syarat Login) -->
                            <div class="mt-6 pt-4 border-t border-sand-DEFAULT/80 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-espresso-light block font-medium">Harga Min. Per Paket</span>
                                    <span class="font-serif font-bold text-xl text-forest">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[10px] text-amber-800 font-bold block">/ 1 Paket (1 kg)</span>
                                </div>

                                <a href="{{ route('orders.create', ['product_id' => $product->id]) }}" 
                                   class="px-5 py-2.5 rounded-full bg-forest hover:bg-forest-light text-cream font-medium text-xs flex items-center gap-1.5 shadow-sm transition-all hover:scale-105">
                                    <span>Pesan Paket (1 kg)</span>
                                    <svg class="w-3.5 h-3.5 text-amberCustom" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 7. VISI & MISI -->
    <section id="visi-misi" class="py-20 bg-sand">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-14">
                <span class="text-xs font-bold uppercase tracking-widest text-amberCustom-dark">Dedikasi Brand</span>
                <h2 class="font-serif font-bold text-3xl sm:text-4xl text-forest mt-1.5">
                    Visi & Misi Usaha C3
                </h2>
                <p class="text-sm text-espresso-muted mt-2">
                    Mengapa kami menamakan diri <strong>Circle Concordia Coffee</strong>: lingkaran harmoni yang menghubungkan petani, roastery, dan konsumen.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Visi Card -->
                <div class="lg:col-span-5 bg-forest text-cream p-8 sm:p-10 rounded-3xl shadow-lg flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-full bg-forest-light border border-amberCustom/30 flex items-center justify-center text-amberCustom text-xl font-serif mb-6">
                            ✦
                        </div>
                        <span class="text-xs uppercase tracking-widest text-amberCustom font-bold">Visi Utama</span>
                        <h3 class="font-serif font-bold text-2xl sm:text-3xl mt-2 mb-4 text-cream">
                            Lingkaran Harmoni Kopi Dunia
                        </h3>
                        <blockquote class="text-sm sm:text-base italic font-serif text-cream/90 leading-relaxed border-l-2 border-amberCustom pl-4 py-1">
                            "{{ $profile->vision }}"
                        </blockquote>
                    </div>
                    <div class="mt-8 pt-6 border-t border-forest-light text-xs text-cream/70">
                        Kemitraan direct trade berkelanjutan dan apresiasi kopi specialty nusantara.
                    </div>
                </div>

                <!-- Misi Card -->
                <div class="lg:col-span-7 bg-white p-8 sm:p-10 rounded-3xl border border-sand-DEFAULT/90 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="text-xs uppercase tracking-widest text-amberCustom-dark font-bold">Misi & Landasan Kerja</span>
                        <h3 class="font-serif font-bold text-2xl text-forest mt-1.5 mb-6">
                            3 Komitmen Operasional Kami
                        </h3>

                        <div class="space-y-4">
                            @if(!empty($profile->mission) && is_array($profile->mission))
                                @foreach($profile->mission as $idx => $misi)
                                    <div class="flex items-start gap-4 p-4 rounded-xl bg-cream-light border border-sand-DEFAULT/80">
                                        <div class="w-7 h-7 rounded-full bg-forest text-amberCustom flex-shrink-0 flex items-center justify-center font-bold text-xs font-serif mt-0.5">
                                            0{{ $idx + 1 }}
                                        </div>
                                        <p class="text-xs sm:text-sm text-espresso-muted leading-relaxed font-medium">
                                            {{ $misi }}
                                        </p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 text-xs text-espresso-light flex items-center gap-2">
                        <span class="text-amberCustom-dark font-bold">✓</span>
                        <span>Mendukung kesejahteraan petani produsen kopi lokal Indonesia.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. FOOTER DENGAN TOMBOL WHATSAPP RESMI OWNER / ADMIN -->
    <footer class="bg-forest-dark text-cream pt-16 pb-12 border-t border-forest-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- SECTION WA OWNER/ADMIN DALAM FOOTER (Sesuai Permintaan User) -->
            <div class="bg-gradient-to-r from-forest to-forest-light p-8 sm:p-10 rounded-3xl border border-forest-light shadow-xl mb-14 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider mb-2">
                        <span>💬</span> Layanan Pelanggan & Konsultasi Resmi
                    </div>
                    <h3 class="font-serif font-bold text-2xl sm:text-3xl text-cream">Hubungi Langsung Owner / Admin C3</h3>
                    <p class="text-xs sm:text-sm text-cream/75 mt-1 max-w-xl">
                        Punya pertanyaan seputar ketersediaan stok paket 1 kg, kerja sama pasokan cafe, atau konfirmasi nota pesanan? Chat langsung dengan Owner/Admin kami.
                    </p>
                </div>

                <!-- Tombol WhatsApp Berisi Nomor Owner/Admin -->
                @php
                    $ownerWaNumber = preg_replace('/[^0-9]/', '', $profile->phone ?? '6281234567890');
                @endphp
                <a href="https://wa.me/{{ $ownerWaNumber }}?text=Halo%20Owner/Admin%20Circle%20Concordia%20Coffee%20(C3),%20saya%20ingin%20berkonsultasi%20seputar%20pemesanan%20biji%20kopi." 
                   target="_blank"
                   class="flex-shrink-0 px-8 py-4 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm flex items-center gap-3 shadow-lg shadow-emerald-950/40 transition-all hover:scale-105">
                    <span class="text-xl">📱</span>
                    <div class="text-left">
                        <span class="text-[10px] block opacity-80 uppercase tracking-wider">Chat WhatsApp Owner/Admin</span>
                        <span class="text-sm font-bold font-mono">{{ $profile->phone ?? '+62 812-3456-7890' }}</span>
                    </div>
                </a>
            </div>

            <!-- Footer Columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12 text-xs text-cream/70">
                <div>
                    <span class="font-serif font-bold text-base text-cream block mb-2">{{ $profile->name }}</span>
                    <p class="leading-relaxed mb-3">{{ $profile->about }}</p>
                    <span class="text-amberCustom italic font-serif">"{{ $profile->tagline }}"</span>
                </div>

                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider mb-3">Navigasi Utama</h4>
                    <ul class="space-y-2">
                        <li><a href="#beranda" class="hover:text-amberCustom">Beranda</a></li>
                        <li><a href="#origins" class="hover:text-amberCustom">Asal Kopi Kebun</a></li>
                        <li><a href="#populer" class="hover:text-amberCustom">Kopi Populer (1 kg)</a></li>
                        <li><a href="#visi-misi" class="hover:text-amberCustom">Visi & Misi</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-amberCustom font-bold text-white">Login 4 Role</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider mb-3">Ketentuan Penjualan</h4>
                    <ul class="space-y-2">
                        <li>• Minimal Order: 1 Paket (1.000 gram)</li>
                        <li>• Kemasan Alumunium Valve Kedap Udara</li>
                        <li>• Opsi: Biji Utuh / Gilingan Custom</li>
                        <li>• Sistem Pemesanan: Khusus Konsumen Terdaftar</li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white uppercase tracking-wider mb-3">Alamat & Roastery</h4>
                    <p class="leading-relaxed mb-2">📍 {{ $profile->address }}</p>
                    <p class="mb-1">✉️ {{ $profile->email }}</p>
                    <p class="mb-1">📸 {{ $profile->instagram }}</p>
                    <p class="font-bold text-emerald-400 mt-2">WA: {{ $profile->phone }}</p>
                </div>
            </div>

            <!-- Copyright -->
            <div class="pt-6 border-t border-forest-light flex flex-col sm:flex-row items-center justify-between text-[11px] text-cream/50 gap-4">
                <p>&copy; {{ date('Y') }} {{ $profile->name }} ({{ $profile->short_name }}). All rights reserved.</p>
                <p>Tugas Besar Manajemen Sistem Basis Data (MSBD) • 4 Role & 3 Level</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button di Pojok Kanan Bawah untuk Kemudahan Pengunjung -->
    <a href="https://wa.me/{{ $ownerWaNumber }}?text=Halo%20Admin%20C3,%20saya%20tertarik%20dengan%20biji%20kopi%20Circle%20Concordia." 
       target="_blank" 
       title="Chat WhatsApp Owner / Admin"
       class="fixed bottom-6 right-6 z-50 w-14 h-14 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white flex items-center justify-center text-2xl shadow-2xl hover:scale-110 transition-transform">
        💬
    </a>

</body>
</html>
