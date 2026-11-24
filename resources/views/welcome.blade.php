<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profile->name ?? 'Circle Concordia Coffee' }} ({{ $profile->short_name ?? 'C3' }}) - Specialty Coffee Beans</title>

    <!-- Google Fonts: Fraunces (Editorial Heading) & DM Sans (Modern Clean Body) -->
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
        /* Arch / Kubah styling khas heritage roastery */
        .arch-frame {
            border-top-left-radius: 180px;
            border-top-right-radius: 180px;
        }
    </style>
</head>
<body class="font-sans antialiased selection:bg-forest selection:text-cream">

    <!-- 1. TOP ANNOUNCEMENT BAR -->
    <div class="bg-forest text-cream text-[12px] py-2 px-4 text-center font-medium border-b border-forest-light tracking-wide flex items-center justify-center gap-2">
        <span class="w-2 h-2 rounded-full bg-amberCustom animate-pulse"></span>
        <span>Biji Kopi Specialty Nusantara Terkurasi Langsung dari Petani Lokal • Batch Roasting Mingguan</span>
    </div>

    <!-- 2. NAVBAR (Warm Editorial Style) -->
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
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-espresso-muted">
                <a href="#beranda" class="hover:text-forest transition-colors">Beranda</a>
                <a href="#origins" class="hover:text-forest transition-colors">Asal Biji Kopi</a>
                <a href="#populer" class="hover:text-forest transition-colors">Kopi Populer</a>
                <a href="#visi-misi" class="hover:text-forest transition-colors">Visi & Misi</a>
                <a href="#proses" class="hover:text-forest transition-colors">Proses Kurasi</a>
            </nav>

            <!-- CTA Button -->
            <div>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone ?? '6281234567890') }}?text=Halo%20C3,%20saya%20ingin%20tanya%20katalog%20biji%20kopi%20Circle%20Concordia" 
                   target="_blank"
                   class="inline-flex items-center gap-2 bg-forest hover:bg-forest-light text-cream font-medium text-xs sm:text-sm px-5 py-2.5 rounded-full shadow-sm hover:shadow transition-all">
                    <span>Minta Penawaran</span>
                    <svg class="w-3.5 h-3.5 text-amberCustom" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
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
                        <span>Single Origin & Specialty Blend Nusantara</span>
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
                        <a href="#populer" 
                           class="px-7 py-3.5 rounded-full bg-forest hover:bg-forest-light text-cream font-medium text-sm shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                            <span>Jelajahi Kopi Populer</span>
                            <span class="text-amberCustom">↓</span>
                        </a>
                        <a href="#origins" 
                           class="px-7 py-3.5 rounded-full bg-transparent border-2 border-forest/30 hover:border-forest text-forest font-medium text-sm transition-all">
                            Lihat Asal Kebun Kopi
                        </a>
                    </div>

                    <!-- Small Brand Motto -->
                    <div class="mt-10 pt-6 border-t border-sand-DEFAULT flex items-center gap-3 text-xs text-amberCustom-dark font-medium italic font-serif">
                        <span class="text-forest not-italic font-sans font-bold">C3 Motto:</span>
                        "{{ $profile->tagline }}"
                    </div>
                </div>

                <!-- Right Column: Arch Framed Visual Image + Floating Badge -->
                <div class="lg:col-span-5 flex justify-center lg:justify-end relative">
                    <!-- Decorative back shadow glow -->
                    <div class="absolute -top-6 -right-6 w-72 h-72 rounded-full bg-amberCustom/15 blur-3xl pointer-events-none"></div>

                    <div class="relative w-full max-w-[360px] sm:max-w-[400px]">
                        <!-- Arch Image Frame -->
                        <div class="arch-frame overflow-hidden bg-forest shadow-2xl border-4 border-white/60 aspect-[3/4] relative">
                            <img src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=900&auto=format&fit=crop" 
                                 alt="Specialty Coffee Roasting Beans" 
                                 class="w-full h-full object-cover object-center scale-105 hover:scale-110 transition-transform duration-700 brightness-95">
                            
                            <!-- Vignette / Tint -->
                            <div class="absolute inset-0 bg-gradient-to-t from-forest-dark/80 via-transparent to-transparent"></div>
                            
                            <div class="absolute bottom-6 left-6 right-6 text-cream text-center">
                                <span class="font-serif italic text-sm text-amberCustom">Circle Concordia Coffee</span>
                                <p class="text-xs text-cream/80 font-sans mt-0.5">Biji Kopi Pilihan Terbaik Nusantara</p>
                            </div>
                        </div>

                        <!-- Floating Badge (seperti di referensi) -->
                        <div class="absolute -bottom-5 -left-4 sm:-left-6 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-sand-DEFAULT max-w-[220px]">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-amberCustom"></span>
                                <span class="text-[11px] font-bold text-forest uppercase tracking-wider">Cupping Score</span>
                            </div>
                            <p class="text-xs text-espresso-muted leading-snug">
                                Rata-rata specialty grade <strong class="text-forest">84+ poin</strong> dengan profil rasa terverifikasi.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. FOREST GREEN VALUE STRIP (Band Banner seperti di referensi) -->
    <section class="bg-forest text-cream py-10 border-y border-forest-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <!-- Col 1 -->
                <div class="border-b md:border-b-0 md:border-r border-forest-light pb-6 md:pb-0 md:pr-8">
                    <span class="text-amberCustom font-serif text-lg font-bold block mb-1">Asal Tertelusur</span>
                    <p class="text-xs text-cream/75 leading-relaxed">
                        Setiap varian biji kopi dilengkapi informasi petani, varietas, ketinggian kebun, dan proses pascapanen yang transparan.
                    </p>
                </div>

                <!-- Col 2 -->
                <div class="border-b md:border-b-0 md:border-r border-forest-light pb-6 md:pb-0 md:px-8">
                    <span class="text-amberCustom font-serif text-lg font-bold block mb-1">Mutu & Roasting Konsisten</span>
                    <p class="text-xs text-cream/75 leading-relaxed">
                        Disangrai dengan kurva profil presisi agar notes rasa manis buah, cokelat, dan aroma floral tetap harmonis di tiap seduhan.
                    </p>
                </div>

                <!-- Col 3 -->
                <div class="md:pl-8">
                    <span class="text-amberCustom font-serif text-lg font-bold block mb-1">Pengiriman Segar Terjadwal</span>
                    <p class="text-xs text-cream/75 leading-relaxed">
                        Dipasok dalam kondisi segar (*fresh roast*) untuk kebutuhan cafe, penikmat seduh manual, maupun konsumsi harian Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. SUMBER BIJI KOPI (ASAL KOPI PILIHAN) -->
    <section id="origins" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <span class="text-xs font-bold uppercase tracking-widest text-amberCustom-dark">Katalog Daerah</span>
                <h2 class="font-serif font-bold text-3xl sm:text-4xl text-forest mt-1.5">
                    Asal Kopi Pilihan
                </h2>
                <p class="text-sm text-espresso-muted mt-2 max-w-2xl">
                    Jelajahi sentra perkebunan kopi nusantara dengan karakter tanah vulkanik, iklim mikro, dan profil rasa yang berbeda-beda.
                </p>
            </div>

            <!-- Origins Grid: Card Bersih dengan Detail Terstruktur -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($origins as $origin)
                    <div class="bg-white rounded-2xl p-6 border border-sand-DEFAULT/90 shadow-sm hover:shadow-md hover:border-amberCustom/60 transition-all flex flex-col justify-between group">
                        <div>
                            <!-- Header Region & Badge -->
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[11px] font-bold tracking-wider uppercase text-amberCustom-dark">
                                    {{ $origin->province }}
                                </span>
                                <span class="text-[11px] font-medium text-espresso-light bg-cream-dark/60 px-2.5 py-0.5 rounded-full">
                                    ⛰️ {{ $origin->altitude }}
                                </span>
                            </div>

                            <!-- Origin Name -->
                            <h3 class="font-serif font-bold text-2xl text-forest group-hover:text-amberCustom-dark transition-colors">
                                {{ $origin->name }}
                            </h3>

                            <!-- Description -->
                            <p class="text-xs text-espresso-muted mt-2.5 leading-relaxed">
                                {{ $origin->description }}
                            </p>
                        </div>

                        <!-- Card Footer -->
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

    <!-- 6. BIJI KOPI POPULER (FEATURED / BEST SELLER PRODUCTS) -->
    <section id="populer" class="py-20 bg-sand-light/50 border-y border-sand-DEFAULT">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-amberCustom-dark">Favorit Pelanggan</span>
                    <h2 class="font-serif font-bold text-3xl sm:text-4xl text-forest mt-1.5">
                        Koleksi Biji Kopi Populer
                    </h2>
                    <p class="text-sm text-espresso-muted mt-2 max-w-xl">
                        Varian biji kopi yang paling banyak dipesan dengan keseimbangan aroma, keasaman manis, dan krema yang melimpah.
                    </p>
                </div>
                <div class="mt-4 md:mt-0 text-xs font-medium text-espresso-muted bg-white px-4 py-2 rounded-full border border-sand-DEFAULT">
                    Kemasan Netto: <strong class="text-forest">250 gram</strong> (Biji / Giling)
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
                            
                            <!-- Origin Tag Pill -->
                            <div class="absolute top-3 left-3 flex gap-1.5">
                                <span class="px-3 py-1 rounded-full bg-forest text-cream text-[11px] font-semibold tracking-wide shadow">
                                    {{ $product->category->name }}
                                </span>
                                <span class="px-2.5 py-1 rounded-full bg-white/90 backdrop-blur-sm text-amberCustom-dark text-[11px] font-bold">
                                    Best Seller
                                </span>
                            </div>

                            <!-- Roast Level Tag -->
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

                            <!-- Bottom Price & Order CTA -->
                            <div class="mt-6 pt-4 border-t border-sand-DEFAULT/80 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-espresso-light block">Harga per pack</span>
                                    <span class="font-serif font-bold text-xl text-forest">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone ?? '6281234567890') }}?text=Halo%20C3,%20saya%20tertarik%20memesan%20biji%20kopi%20{{ urlencode($product->name) }}" 
                                   target="_blank"
                                   class="px-4 py-2 rounded-full bg-forest hover:bg-forest-light text-cream font-medium text-xs flex items-center gap-1.5 shadow-sm transition-all hover:scale-105">
                                    <span>Pesan Kopi</span>
                                    <svg class="w-3.5 h-3.5 text-amberCustom" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 7. VISI & MISI (Filosofi Circle Concordia Coffee) -->
    <section id="visi-misi" class="py-20 bg-sand">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-14">
                <span class="text-xs font-bold uppercase tracking-widest text-amberCustom-dark">Dedikasi Brand</span>
                <h2 class="font-serif font-bold text-3xl sm:text-4xl text-forest mt-1.5">
                    Visi & Misi Usaha C3
                </h2>
                <p class="text-sm text-espresso-muted mt-2">
                    Mengapa kami menamakan diri <strong>Circle Concordia Coffee</strong>: lingkaran harmoni yang menghubungkan petani, roastery, dan pecinta kopi.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Visi Card (Forest Style) -->
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
                        Fokus pada perdagangan langsung (*direct trade*) yang adil dan apresiasi kualitas hasil bumi Indonesia.
                    </div>
                </div>

                <!-- Misi Card (Clean White Style) -->
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
                        <span>Mendukung pertanian kopi yang berkelanjutan dan regeneratif.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. CARA KERJA / PROSES KURASI (Step 1 - 4 seperti di referensi) -->
    <section id="proses" class="py-20 bg-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-14">
                <span class="text-xs font-bold uppercase tracking-widest text-amberCustom-dark">Standar Kualitas</span>
                <h2 class="font-serif font-bold text-3xl sm:text-4xl text-forest mt-1.5">
                    Proses Dari Kebun ke Cangkir
                </h2>
                <p class="text-sm text-espresso-muted mt-2">
                    Tahapan ketat untuk memastikan mutu biji kopi tetap terjaga dari saat petik hingga sampai ke tangan Anda.
                </p>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div>
                    <div class="w-9 h-9 rounded-full bg-forest text-cream flex items-center justify-center font-serif font-bold text-sm mb-4">
                        1
                    </div>
                    <h4 class="font-serif font-bold text-lg text-forest mb-2">Petik Selektif</h4>
                    <p class="text-xs text-espresso-muted leading-relaxed">
                        Hanya buah ceri kopi merah sempurna (*red cherry*) yang dipanen dari perkebunan dataran tinggi.
                    </p>
                </div>

                <!-- Step 2 -->
                <div>
                    <div class="w-9 h-9 rounded-full bg-forest text-cream flex items-center justify-center font-serif font-bold text-sm mb-4">
                        2
                    </div>
                    <h4 class="font-serif font-bold text-lg text-forest mb-2">Pascapanen Presisi</h4>
                    <p class="text-xs text-espresso-muted leading-relaxed">
                        Proses washed, honey, atau natural dengan fermentasi terkontrol untuk memaksimalkan sweetness alami.
                    </p>
                </div>

                <!-- Step 3 -->
                <div>
                    <div class="w-9 h-9 rounded-full bg-forest text-cream flex items-center justify-center font-serif font-bold text-sm mb-4">
                        3
                    </div>
                    <h4 class="font-serif font-bold text-lg text-forest mb-2">Artisan Roasting</h4>
                    <p class="text-xs text-espresso-muted leading-relaxed">
                        Disangrai oleh roaster berpengalaman dalam batch kecil (*micro-batch*) agar karakter rasa origin tidak hangus.
                    </p>
                </div>

                <!-- Step 4 -->
                <div>
                    <div class="w-9 h-9 rounded-full bg-forest text-cream flex items-center justify-center font-serif font-bold text-sm mb-4">
                        4
                    </div>
                    <h4 class="font-serif font-bold text-lg text-forest mb-2">Cupping & Packaging</h4>
                    <p class="text-xs text-espresso-muted leading-relaxed">
                        Uji rasa (*cupping*) sebelum pengemasan dalam pouch berkatup satu arah (*one-way valve*) kedap udara.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. CALL TO ACTION / FORM KONSULTASI (Forest Dark Panel seperti di referensi) -->
    <section class="bg-forest text-cream py-20 border-t border-forest-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Text Left -->
                <div class="lg:col-span-6">
                    <span class="text-xs font-bold uppercase tracking-widest text-amberCustom">Pemesanan & Pasokan</span>
                    <h2 class="font-serif font-bold text-3xl sm:text-4xl lg:text-5xl text-cream mt-2 leading-tight">
                        Siap menikmati seduhan terbaik hari ini?
                    </h2>
                    <p class="text-sm text-cream/80 mt-4 leading-relaxed max-w-lg">
                        Ceritakan kebutuhan biji kopi Anda—baik untuk kebutuhan seduh pribadi di rumah, pasokan cafe, maupun pemesanan grosir. Tim kami siap merespons dengan cepat.
                    </p>
                    <div class="mt-8 flex items-center gap-6 text-xs text-cream/70">
                        <div class="flex items-center gap-2">
                            <span class="text-amberCustom">📍</span> {{ $profile->address }}
                        </div>
                    </div>
                </div>

                <!-- Simple Inquiry Card Right -->
                <div class="lg:col-span-6">
                    <div class="bg-cream text-espresso p-8 rounded-3xl shadow-xl border border-sand-DEFAULT">
                        <h4 class="font-serif font-bold text-xl text-forest mb-1">Tanya Stok atau Pesan</h4>
                        <p class="text-xs text-espresso-muted mb-6">Kirim pesan langsung ke WhatsApp kami untuk konsultasi rasa & rekomendasi gilingan.</p>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-forest mb-1">Nama Pemesan</label>
                                <input type="text" id="cust_name" placeholder="Misal: Budi / Kedai Kopi Harmoni" class="w-full text-xs px-4 py-3 rounded-xl border border-sand-DEFAULT bg-white focus:outline-none focus:ring-2 focus:ring-forest">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-forest mb-1">Varian Kopi yang Diminati</label>
                                <select id="cust_coffee" class="w-full text-xs px-4 py-3 rounded-xl border border-sand-DEFAULT bg-white focus:outline-none focus:ring-2 focus:ring-forest">
                                    @foreach($popularProducts as $p)
                                        <option value="{{ $p->name }}">{{ $p->name }} (Rp {{ number_format($p->price, 0, ',', '.') }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-forest mb-1">Catatan Tambahan (Bentuk Biji / Gilingan)</label>
                                <input type="text" id="cust_notes" placeholder="Misal: Biji utuh / Giling halus untuk espresso" class="w-full text-xs px-4 py-3 rounded-xl border border-sand-DEFAULT bg-white focus:outline-none focus:ring-2 focus:ring-forest">
                            </div>

                            <button type="button" onclick="sendOrder()" class="w-full mt-2 py-3.5 rounded-full bg-forest hover:bg-forest-light text-cream font-medium text-xs tracking-wider uppercase transition-all shadow-md flex items-center justify-center gap-2">
                                <span>Kirim Permintaan ke WhatsApp</span>
                                <span class="text-amberCustom">→</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 10. MINIMALIST EDITORIAL FOOTER -->
    <footer class="bg-forest-dark text-cream/70 py-12 text-xs border-t border-forest-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <span class="font-serif font-bold text-sm text-cream">{{ $profile->name }} ({{ $profile->short_name }})</span>
                <p class="text-[11px] text-cream/50 mt-0.5">&copy; {{ date('Y') }} Circle Concordia Coffee. Tugas Besar Manajemen Sistem Basis Data.</p>
            </div>
            <div class="flex items-center gap-6 text-[11px] text-cream/70">
                <a href="#beranda" class="hover:text-amberCustom">Beranda</a>
                <a href="#origins" class="hover:text-amberCustom">Asal Kopi</a>
                <a href="#populer" class="hover:text-amberCustom">Produk Populer</a>
                <a href="#visi-misi" class="hover:text-amberCustom">Visi & Misi</a>
                <span class="text-amberCustom">📞 {{ $profile->phone }}</span>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Order Script Helper -->
    <script>
        function sendOrder() {
            const name = document.getElementById('cust_name').value || 'Pelanggan';
            const coffee = document.getElementById('cust_coffee').value;
            const notes = document.getElementById('cust_notes').value || 'Biji utuh';
            const phone = "{{ preg_replace('/[^0-9]/', '', $profile->phone ?? '6281234567890') }}";
            
            const message = `Halo C3 (Circle Concordia Coffee), perkenalkan saya ${name}. Saya ingin memesan biji kopi: *${coffee}*, dengan catatan: ${notes}. Mohon info ketersediaan stoknya. Terima kasih!`;
            
            window.open(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`, '_blank');
        }
    </script>

</body>
</html>
