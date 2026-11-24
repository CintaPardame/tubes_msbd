<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profile->name ?? 'Circle Concordia Coffee' }} ({{ $profile->short_name ?? 'C3' }}) - Specialty Coffee Beans</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (via Vite) & Fallback CDN for instant high-fidelity render -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        coffee: {
                            50: '#FDF8F5',
                            100: '#F9EDE5',
                            200: '#F2D9C9',
                            300: '#E8BFA6',
                            400: '#D79F7E',
                            500: '#C07E56',
                            600: '#A4633E',
                            700: '#834A2E',
                            800: '#5E3420',
                            900: '#3D2114',
                            950: '#231109',
                        },
                        amberGold: '#D97706',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-stone-50 text-stone-800 font-sans antialiased selection:bg-coffee-600 selection:text-white">

    <!-- 1. NAVIGATION BAR -->
    <header class="sticky top-0 z-50 bg-stone-900/90 backdrop-blur-md border-b border-stone-800 text-stone-100 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="#beranda" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-coffee-700 to-amber-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-coffee-900/40 group-hover:scale-105 transition-transform">
                    ☕
                </div>
                <div>
                    <span class="text-xl font-bold tracking-tight text-white flex items-center gap-1.5 font-serif">
                        {{ $profile->short_name }} <span class="text-xs px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400 font-sans font-medium">Coffee</span>
                    </span>
                    <p class="text-[11px] text-stone-400 -mt-0.5 tracking-wider uppercase">{{ $profile->name }}</p>
                </div>
            </a>

            <!-- Menu Navigation -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-stone-300">
                <a href="#beranda" class="hover:text-amber-400 transition-colors">Beranda</a>
                <a href="#tentang" class="hover:text-amber-400 transition-colors">Visi & Misi</a>
                <a href="#origins" class="hover:text-amber-400 transition-colors">Sumber Biji Kopi</a>
                <a href="#populer" class="hover:text-amber-400 transition-colors">Kopi Populer</a>
                <a href="#katalog" class="hover:text-amber-400 transition-colors">Semua Produk</a>
            </nav>

            <!-- Action Button -->
            <div class="flex items-center gap-4">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone ?? '6281234567890') }}?text=Halo%20C3,%20saya%20ingin%20tanya%20seputar%20biji%20kopi%20Circle%20Concordia" 
                   target="_blank"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-coffee-600 to-amber-600 hover:from-coffee-500 hover:to-amber-500 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-full shadow-md shadow-coffee-950/30 transition-all hover:scale-105">
                    <span>Hubungi Kami</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </header>

    <!-- 2. HERO SECTION -->
    <section id="beranda" class="relative min-h-[85vh] flex items-center justify-center bg-stone-950 text-white overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?q=80&w=1920&auto=format&fit=crop" 
                 alt="Coffee Farm & Roasted Beans" 
                 class="w-full h-full object-cover object-center opacity-30 filter brightness-75 scale-105 animate-pulse duration-1000">
            <div class="absolute inset-0 bg-gradient-to-t from-stone-950 via-stone-950/70 to-transparent"></div>
            <div class="absolute inset-0 bg-radial-gradient from-transparent via-stone-950/50 to-stone-950"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs sm:text-sm font-medium mb-6">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                Specialty Coffee Beans & Direct Trade Indonesia
            </div>

            <!-- Big Title -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-bold font-serif tracking-tight leading-tight mb-4">
                {{ $profile->name }}
            </h1>
            
            <p class="text-lg sm:text-2xl text-amber-400 font-serif italic mb-6">
                "{{ $profile->tagline }}"
            </p>

            <p class="max-w-2xl mx-auto text-stone-300 text-sm sm:text-base leading-relaxed mb-10">
                {{ $profile->about }}
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#populer" 
                   class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-amber-600 hover:bg-amber-500 text-white font-semibold shadow-lg shadow-amber-900/40 transition-all hover:scale-105">
                    Lihat Biji Kopi Populer
                </a>
                <a href="#origins" 
                   class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-stone-800/80 hover:bg-stone-800 border border-stone-700 text-stone-200 font-medium hover:text-white transition-all">
                    Jelajahi Asal Kebun Kopi
                </a>
            </div>

            <!-- Key Highlights Stat Bar -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 pt-10 border-t border-stone-800/80">
                <div class="p-3">
                    <span class="block text-2xl sm:text-3xl font-bold text-amber-400 font-serif">{{ $origins->count() }}+</span>
                    <span class="text-xs text-stone-400 uppercase tracking-wider">Origin Nusantara</span>
                </div>
                <div class="p-3">
                    <span class="block text-2xl sm:text-3xl font-bold text-amber-400 font-serif">100%</span>
                    <span class="text-xs text-stone-400 uppercase tracking-wider">Biji Kopi Specialty</span>
                </div>
                <div class="p-3">
                    <span class="block text-2xl sm:text-3xl font-bold text-amber-400 font-serif">Direct</span>
                    <span class="text-xs text-stone-400 uppercase tracking-wider">Kemitraan Petani</span>
                </div>
                <div class="p-3">
                    <span class="block text-2xl sm:text-3xl font-bold text-amber-400 font-serif">Fresh</span>
                    <span class="text-xs text-stone-400 uppercase tracking-wider">Roasted Weekly</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. TENTANG KAMI, VISI & MISI SECTION -->
    <section id="tentang" class="py-20 bg-stone-100 border-b border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-coffee-600">Filosofi & Komitmen</span>
                <h2 class="text-3xl sm:text-4xl font-bold font-serif text-stone-900 mt-2">Visi & Misi {{ $profile->short_name }}</h2>
                <div class="w-16 h-1 bg-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Visi Card (5 cols) -->
                <div class="lg:col-span-5 bg-gradient-to-br from-stone-900 to-coffee-950 text-white p-8 sm:p-10 rounded-3xl shadow-xl flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 w-44 h-44 rounded-full bg-amber-500/10 pointer-events-none blur-2xl"></div>
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-2xl mb-6">
                            👁️
                        </div>
                        <span class="text-xs uppercase tracking-widest text-amber-400 font-semibold">Visi Kami</span>
                        <h3 class="text-2xl font-serif font-bold mt-2 mb-4">Lingkaran Harmoni Kopi Dunia</h3>
                        <blockquote class="text-stone-300 text-sm sm:text-base italic leading-relaxed border-l-2 border-amber-500/60 pl-4 py-1">
                            "{{ $profile->vision }}"
                        </blockquote>
                    </div>
                    <div class="mt-8 pt-6 border-t border-stone-800 text-xs text-stone-400">
                        {{ $profile->name }} berkomitmen membawa cita rasa tanah nusantara ke panggung internasional.
                    </div>
                </div>

                <!-- Misi Cards (7 cols) -->
                <div class="lg:col-span-7 bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-stone-200 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-coffee-100 text-coffee-700 flex items-center justify-center text-2xl mb-6">
                            🎯
                        </div>
                        <span class="text-xs uppercase tracking-widest text-coffee-700 font-semibold">Misi Kami</span>
                        <h3 class="text-2xl font-serif font-bold text-stone-900 mt-2 mb-6">Tiga Pilar Utama Operasional C3</h3>

                        <div class="space-y-4">
                            @if(!empty($profile->mission) && is_array($profile->mission))
                                @foreach($profile->mission as $index => $item)
                                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-stone-50 border border-stone-100 hover:border-amber-200 transition-colors">
                                        <div class="w-7 h-7 rounded-full bg-amber-600 text-white flex-shrink-0 flex items-center justify-center font-bold text-xs mt-0.5">
                                            {{ $index + 1 }}
                                        </div>
                                        <p class="text-sm text-stone-700 leading-relaxed font-medium">
                                            {{ $item }}
                                        </p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 flex items-center gap-3 text-xs text-stone-500 bg-amber-50/70 p-3.5 rounded-xl border border-amber-200/60">
                        <span class="text-lg">🌿</span>
                        <span>Semua biji kopi dipetik saat merah sempurna (*full red cherry*) dan diproses secara higienis ramah lingkungan.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. SUMBER BIJI KOPI (ORIGINS / DAERAH ASAL) SECTION -->
    <section id="origins" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-14">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-coffee-600">Teritorial & Terroir</span>
                    <h2 class="text-3xl sm:text-4xl font-bold font-serif text-stone-900 mt-2">Sumber Biji Kopi Nusantara</h2>
                    <p class="text-stone-500 text-sm mt-2 max-w-xl">
                        Karakter rasa kopi sangat dipengaruhi oleh ketinggian, iklim mikro, dan tanah tempat tumbuhnya. Kenali asal-usul biji kopi C3.
                    </p>
                </div>
                <div class="mt-4 md:mt-0 text-sm text-stone-500 font-medium">
                    Total: <span class="font-bold text-stone-900">{{ $origins->count() }} Daerah Penghasil</span>
                </div>
            </div>

            <!-- Origins Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($origins as $origin)
                    <div class="group relative rounded-3xl overflow-hidden bg-stone-900 text-white shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col justify-end min-h-[380px]">
                        <!-- Background Image -->
                        <img src="{{ $origin->image_url }}" 
                             alt="{{ $origin->name }}" 
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 brightness-75">
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-950 via-stone-950/60 to-transparent"></div>

                        <!-- Top Badges -->
                        <div class="absolute top-5 left-5 right-5 flex items-center justify-between z-10">
                            <span class="px-3 py-1 rounded-full bg-black/60 backdrop-blur-md text-[11px] font-semibold tracking-wider uppercase text-amber-300 border border-amber-500/30">
                                📍 {{ $origin->province }}
                            </span>
                            <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-medium text-white">
                                ⛰️ {{ $origin->altitude }}
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="relative z-10 p-6 sm:p-7">
                            <h3 class="text-2xl font-bold font-serif text-white group-hover:text-amber-300 transition-colors">
                                {{ $origin->name }}
                            </h3>
                            <p class="text-xs text-stone-300 mt-2 line-clamp-3 leading-relaxed">
                                {{ $origin->description }}
                            </p>

                            <div class="mt-4 pt-4 border-t border-stone-700/60 flex items-center justify-between text-xs">
                                <span class="text-stone-400">Varian Tersedia:</span>
                                <span class="px-2.5 py-0.5 rounded-full bg-amber-500 text-stone-950 font-bold">
                                    {{ $origin->products_count }} Varian Kopi
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. BIJI KOPI POPULER (FEATURED PRODUCTS) SECTION -->
    <section id="populer" class="py-20 bg-stone-100 border-t border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="px-4 py-1.5 rounded-full bg-amber-600/10 text-amber-700 text-xs font-bold uppercase tracking-wider inline-block mb-3">
                    ★ Paling Diminati Pelanggan
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold font-serif text-stone-900">Biji Kopi Populer C3</h2>
                <p class="text-stone-600 text-sm mt-3">
                    Deretan biji kopi terfavorit dengan penjualan tertinggi, disangrai presisi untuk mengeluarkan aroma dan profil rasa terbaik.
                </p>
                <div class="w-16 h-1 bg-amber-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($popularProducts as $product)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-stone-200/80 transition-all duration-300 flex flex-col group">
                        <!-- Image Container with Badges -->
                        <div class="relative h-64 overflow-hidden bg-stone-100">
                            <img src="{{ $product->main_image }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <!-- Popular Badge -->
                            <div class="absolute top-4 left-4 z-10 flex gap-2">
                                <span class="px-3 py-1 rounded-full bg-amber-600 text-white font-bold text-xs shadow-md flex items-center gap-1">
                                    <span>🔥</span> Populer
                                </span>
                                <span class="px-2.5 py-1 rounded-full bg-stone-900/80 backdrop-blur-md text-stone-200 font-medium text-xs">
                                    {{ $product->category->name }}
                                </span>
                            </div>

                            <!-- Roast Level Tag -->
                            <div class="absolute bottom-3 right-3 z-10">
                                <span class="px-3 py-1 rounded-lg bg-stone-950/80 backdrop-blur-md text-amber-300 text-xs font-semibold">
                                    ♨️ {{ $product->roast_level }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-1.5 text-xs text-coffee-700 font-semibold mb-1">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                    <span>{{ $product->origin->name }}</span>
                                    <span class="text-stone-300">•</span>
                                    <span class="text-stone-500 font-normal">{{ $product->process_method }}</span>
                                </div>

                                <h3 class="text-xl font-bold font-serif text-stone-900 group-hover:text-amber-700 transition-colors">
                                    {{ $product->name }}
                                </h3>

                                <p class="text-xs text-stone-500 mt-2 line-clamp-2 leading-relaxed">
                                    {{ $product->description }}
                                </p>

                                <!-- Flavor Notes Pills -->
                                <div class="mt-4">
                                    <span class="text-[11px] font-bold text-stone-400 uppercase tracking-wider block mb-1.5">Karakter Rasa (Notes):</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach(explode(',', $product->flavor_notes) as $note)
                                            <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-700 text-[11px] font-medium border border-stone-200">
                                                {{ trim($note) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Price & Action -->
                            <div class="mt-6 pt-5 border-t border-stone-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[11px] text-stone-400 block font-medium">Isi {{ $product->weight_grams }}g</span>
                                    <span class="text-xl font-bold text-stone-900 font-serif">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone ?? '6281234567890') }}?text=Halo%20C3,%20saya%20mau%20pesan%20biji%20kopi%20{{ urlencode($product->name) }}" 
                                   target="_blank"
                                   class="px-4 py-2 rounded-xl bg-stone-900 hover:bg-amber-600 text-white font-medium text-xs flex items-center gap-1.5 shadow-sm transition-colors">
                                    <span>Beli Sekarang</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 6. SEMUA KOLEKSI PRODUK (KATALOG LENGKAP) -->
    <section id="katalog" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-coffee-600">Pilihan Menyeluruh</span>
                    <h2 class="text-3xl font-bold font-serif text-stone-900 mt-1">Katalog Semua Biji Kopi</h2>
                    <p class="text-stone-500 text-sm mt-1">
                        Jelajahi seluruh koleksi biji kopi nusantara yang dipanggang segar oleh roastery kami.
                    </p>
                </div>
                <div class="mt-4 md:mt-0 flex gap-2">
                    @foreach($categories as $cat)
                        <span class="px-3 py-1 rounded-full bg-stone-100 text-stone-600 text-xs font-medium border border-stone-200">
                            {{ $cat->name }} ({{ $cat->products_count }})
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Table / Compact Card Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($allProducts as $item)
                    <div class="p-5 rounded-2xl border border-stone-200 hover:border-amber-400 bg-stone-50/50 hover:bg-white transition-all flex gap-4 items-center">
                        <img src="{{ $item->main_image }}" alt="{{ $item->name }}" class="w-20 h-20 rounded-xl object-cover flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-stone-200 text-stone-700">{{ $item->category->name }}</span>
                                <span class="text-xs text-amber-600 font-semibold truncate">{{ $item->origin->name }}</span>
                            </div>
                            <h4 class="text-sm font-bold text-stone-900 truncate">{{ $item->name }}</h4>
                            <p class="text-xs text-stone-500 mt-0.5 font-serif font-bold">
                                Rp {{ number_format($item->price, 0, ',', '.') }} <span class="text-[10px] font-sans text-stone-400 font-normal">/ {{ $item->weight_grams }}g</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 7. FOOTER SECTION -->
    <footer class="bg-stone-950 text-stone-300 pt-16 pb-12 border-t border-stone-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-14">
                <!-- Col 1: Brand Info -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-coffee-700 to-amber-600 flex items-center justify-center text-white font-bold text-lg">
                            ☕
                        </div>
                        <span class="text-xl font-bold text-white font-serif">{{ $profile->name }}</span>
                    </div>
                    <p class="text-xs text-stone-400 leading-relaxed mb-4">
                        {{ $profile->about }}
                    </p>
                    <span class="inline-block text-xs text-amber-400 italic font-serif">
                        "{{ $profile->tagline }}"
                    </span>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Navigasi</h4>
                    <ul class="space-y-2.5 text-xs text-stone-400">
                        <li><a href="#beranda" class="hover:text-amber-400 transition-colors">Beranda Utama</a></li>
                        <li><a href="#tentang" class="hover:text-amber-400 transition-colors">Visi & Misi Perusahaan</a></li>
                        <li><a href="#origins" class="hover:text-amber-400 transition-colors">Peta Asal Biji Kopi</a></li>
                        <li><a href="#populer" class="hover:text-amber-400 transition-colors">Produk Paling Populer</a></li>
                        <li><a href="#katalog" class="hover:text-amber-400 transition-colors">Katalog Semua Biji Kopi</a></li>
                    </ul>
                </div>

                <!-- Col 3: Asal Daerah Unggulan -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Origin Unggulan</h4>
                    <ul class="space-y-2 text-xs text-stone-400">
                        @foreach($origins->take(4) as $o)
                            <li class="flex items-center gap-2">
                                <span class="text-amber-500">•</span>
                                <span>{{ $o->name }} ({{ $o->altitude }})</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Col 4: Kontak & Alamat -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Kontak Kami</h4>
                    <ul class="space-y-3 text-xs text-stone-400">
                        <li class="flex items-start gap-2.5">
                            <span class="text-amber-500 mt-0.5">📍</span>
                            <span>{{ $profile->address }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-amber-500">📞</span>
                            <span>{{ $profile->phone }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-amber-500">✉️</span>
                            <span>{{ $profile->email }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-amber-500">📸</span>
                            <span>{{ $profile->instagram }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="pt-8 border-t border-stone-900 flex flex-col sm:flex-row items-center justify-between text-xs text-stone-500 gap-4">
                <p>&copy; {{ date('Y') }} {{ $profile->name }} ({{ $profile->short_name }}). All rights reserved.</p>
                <p class="text-stone-400">Tugas Besar Manajemen Sistem Basis Data (MSBD)</p>
            </div>
        </div>
    </footer>

</body>
</html>
