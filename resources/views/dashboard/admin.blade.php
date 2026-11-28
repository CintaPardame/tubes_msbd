@extends('dashboard.layout')

@section('title', 'Admin / Owner Dashboard')

@section('content')
<div class="space-y-7">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-800">
            ✕ {{ session('error') }}
        </div>
    @endif
    @if(isset($errors) && $errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Header --}}
    <section class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 flex flex-wrap items-center gap-2">
                <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-emerald-800">Administrator · Level 1</span>
                <span class="rounded-full bg-amber-50 px-3 py-1 text-[11px] font-semibold text-amber-800">Pengambil Keputusan</span>
            </div>
            <h1 class="font-serif text-3xl font-bold text-forest">Selamat datang, {{ auth()->user()->name }}</h1>
            <p class="mt-1 text-sm text-stone-500">Manajemen mutu roasting, harga jual minimum, kontrol user, dan laporan finansial roastery.</p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-forest px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-forest-light">
            <span>↗</span> Lihat Katalog
        </a>
    </section>

    {{-- Stat Cards --}}
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Ringkasan bisnis">
        <article class="rounded-2xl border border-sand bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between"><p class="text-sm text-stone-500">Omzet Kotor</p><span class="grid h-9 w-9 place-items-center rounded-xl bg-amber-50 text-lg text-amber-700">↗</span></div>
            <p class="mt-4 font-serif text-2xl font-bold text-forest">Rp {{ number_format((float) ($stats['total_revenue'] ?? 0), 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-stone-400">Total pesanan selesai & diproses</p>
        </article>
        <article class="rounded-2xl border border-sand bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between"><p class="text-sm text-stone-500">Modal Petani & Roasting</p><span class="grid h-9 w-9 place-items-center rounded-xl bg-rose-50 text-lg text-rose-700">↘</span></div>
            <p class="mt-4 font-serif text-2xl font-bold text-stone-700">Rp {{ number_format((float) (($stats['total_farmer_cost'] ?? 0) + ($stats['total_roasting_cost'] ?? 0)), 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-stone-400">Modal: Rp {{ number_format((float)($stats['total_farmer_cost'] ?? 0), 0, ',', '.') }} | Roasting: Rp {{ number_format((float)($stats['total_roasting_cost'] ?? 0), 0, ',', '.') }}</p>
        </article>
        <article class="rounded-2xl border border-sand bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between"><p class="text-sm text-stone-500">Laba Bersih</p><span class="grid h-9 w-9 place-items-center rounded-xl bg-emerald-50 text-lg text-emerald-700">◈</span></div>
            <p class="mt-4 font-serif text-2xl font-bold {{ ($stats['net_profit'] ?? 0) >= 0 ? 'text-emerald-700' : 'text-rose-600' }}">Rp {{ number_format((float) ($stats['net_profit'] ?? 0), 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-stone-400">Omzet kotor − (Modal beli + Biaya roasting)</p>
        </article>
        <article class="rounded-2xl border border-sand bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between"><p class="text-sm text-stone-500">Stok Siap Jual</p><span class="grid h-9 w-9 place-items-center rounded-xl bg-sky-50 text-lg text-sky-700">▤</span></div>
            <p class="mt-4 font-serif text-2xl font-bold text-forest">{{ number_format((int) $products->sum('stock'), 0, ',', '.') }} <span class="font-sans text-sm font-medium">paket 1 kg</span></p>
            <p class="mt-1 text-xs text-stone-400">{{ $stats['total_batches'] ?? 0 }} batch roasting tercatat</p>
        </article>
    </section>

    {{-- FITUR 1: Roasting Batch & Pasokan Petani --}}
    <section class="grid grid-cols-1 gap-5 xl:grid-cols-5">
        {{-- Form Roasting Batch --}}
        <article class="rounded-2xl border border-sand bg-white p-5 shadow-sm sm:p-6 xl:col-span-3">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[.16em] text-amber-700">Fitur 1 · Produksi & Stok</p>
                    <h2 class="mt-1 font-serif text-xl font-bold text-forest">Roasting Batch & Konversi Stok</h2>
                    <p class="mt-1 text-sm text-stone-500">Input proses sangrai biji mentah ➔ paket kopi 1 kg. Stok otomatis bertambah saat disimpan.</p>
                </div>
                <span class="w-fit rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-semibold text-emerald-800">Aktif & Terhubung</span>
            </div>

            <form action="{{ route('admin.roasting.store') }}" method="POST" class="mt-6 space-y-4" id="roastingForm">
                @csrf
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <label class="block sm:col-span-2">
                        <span class="mb-1.5 block text-xs font-semibold text-stone-600">Pilih Pasokan Petani (Opsional)</span>
                        <select name="supply_id" id="supplySelect" class="w-full rounded-xl border border-stone-200 bg-stone-50 px-3.5 py-3 text-sm text-stone-700 outline-none focus:border-emerald-700">
                            <option value="">-- Tanpa pasokan tercatat (Input manual) --</option>
                            @foreach($approvedSupplies as $appSupply)
                                <option value="{{ $appSupply->id }}" data-weight="{{ $appSupply->weight_kg }}">
                                    {{ $appSupply->bean_type }} ({{ $appSupply->origin_name }}) · {{ $appSupply->weight_kg }} kg · Petani: {{ $appSupply->user->name ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block sm:col-span-2">
                        <span class="mb-1.5 block text-xs font-semibold text-stone-600">Target Produk Kemasan 1 kg *</span>
                        <select name="product_id" required class="w-full rounded-xl border border-stone-200 bg-stone-50 px-3.5 py-3 text-sm text-stone-700 outline-none focus:border-emerald-700">
                            <option value="">-- Pilih produk yang stoknya akan ditambah --</option>
                            @foreach($products as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->name }} (Stok saat ini: {{ $prod->stock }} paket)</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="mb-1.5 block text-xs font-semibold text-stone-600">Berat Biji Mentah (Green Bean) *</span>
                        <div class="flex rounded-xl border border-stone-200 bg-stone-50">
                            <input type="number" step="0.1" min="0.1" name="green_bean_weight_kg" id="greenBeanInput" value="50" required class="w-full rounded-l-xl bg-transparent px-3.5 py-3 text-sm font-semibold text-stone-800 outline-none">
                            <span class="px-4 py-3 text-sm text-stone-500">kg</span>
                        </div>
                    </label>

                    <label class="block">
                        <span class="mb-1.5 block text-xs font-semibold text-stone-600">Penyusutan Roasting *</span>
                        <div class="flex rounded-xl border border-stone-200 bg-stone-50">
                            <input type="number" step="0.1" min="0" max="99" name="shrinkage_percentage" id="shrinkageInput" value="15" required class="w-full rounded-l-xl bg-transparent px-3.5 py-3 text-sm font-semibold text-stone-800 outline-none">
                            <span class="px-4 py-3 text-sm text-stone-500">%</span>
                        </div>
                    </label>

                    <label class="block sm:col-span-2">
                        <span class="mb-1.5 block text-xs font-semibold text-stone-600">Biaya Operasional Roasting (Gas, Listrik, Tenaga)</span>
                        <div class="flex rounded-xl border border-stone-200 bg-stone-50">
                            <span class="px-4 py-3 text-sm text-stone-500">Rp</span>
                            <input type="number" step="1000" min="0" name="roasting_cost" value="150000" class="w-full rounded-r-xl bg-transparent px-3.5 py-3 text-sm font-semibold text-stone-800 outline-none">
                        </div>
                    </label>
                </div>

                {{-- Live Calculation Box --}}
                <div class="mt-4 rounded-2xl bg-emerald-50/80 p-4 sm:p-5">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-emerald-800">Estimasi Hasil Produksi</p>
                            <p class="mt-1 font-serif text-2xl font-bold text-forest" id="estPackages">42 paket <span class="font-sans text-sm font-medium">siap jual</span></p>
                        </div>
                        <div class="text-right text-xs leading-5 text-stone-600">
                            <p id="estFormula">50 kg masuk − 7.5 kg susut</p>
                            <p class="font-semibold text-emerald-800" id="estResult">42.5 kg → 42 paket utuh 1 kg</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                    <p class="text-xs text-stone-500">Stok produk tujuan akan otomatis bertambah sesuai jumlah paket.</p>
                    <button type="submit" class="rounded-xl bg-forest px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-forest-light shadow-sm">
                        Simpan Batch & Tambah Stok →
                    </button>
                </div>
            </form>
        </article>

        {{-- FITUR 2 (Part A): Harga Minimum & Promo --}}
        <article class="rounded-2xl border border-sand bg-white p-5 shadow-sm sm:p-6 xl:col-span-2">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[.16em] text-amber-700">Fitur 2 · Harga Minimum</p>
                    <h2 class="mt-1 font-serif text-xl font-bold text-forest">Harga Jual & Batas Minimum</h2>
                    <p class="mt-1 text-sm text-stone-500">Atur batas harga jual bawah untuk setiap produk 1 kg.</p>
                </div>
            </div>

            <div class="mt-5 divide-y divide-stone-100 max-h-[380px] overflow-y-auto pr-1">
                @forelse($products as $product)
                    <div class="py-3">
                        <div class="flex items-center justify-between gap-2">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-stone-800">{{ $product->name }}</p>
                                <p class="text-[11px] text-stone-400">Harga: Rp {{ number_format((float) $product->price, 0, ',', '.') }} · Stok: {{ $product->stock }}</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.products.min_price', $product) }}" method="POST" class="mt-2 flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <div class="flex flex-1 rounded-lg border border-stone-200 bg-stone-50 text-xs">
                                <span class="px-2 py-1.5 text-stone-400">Min Rp</span>
                                <input type="number" step="1000" name="min_price" value="{{ (float) ($product->min_price ?? 0) }}" placeholder="0" class="w-full bg-transparent px-2 py-1.5 font-semibold text-stone-700 outline-none">
                            </div>
                            <button type="submit" class="rounded-lg bg-stone-800 px-3 py-1.5 text-xs font-semibold text-white hover:bg-black transition">Set Min</button>
                        </form>
                    </div>
                @empty
                    <p class="py-4 text-center text-xs text-stone-400">Belum ada produk.</p>
                @endforelse
            </div>

            {{-- Promo Section --}}
            <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50/70 p-4">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-800">Kelola Promo Aktif</p>
                    <span class="rounded-full bg-amber-200 px-2 py-0.5 text-[10px] font-bold text-amber-900">{{ $promotions->where('is_active', true)->count() }} Aktif</span>
                </div>
                <div class="mt-3 space-y-2 max-h-40 overflow-y-auto">
                    @forelse($promotions as $promo)
                        <div class="flex items-center justify-between rounded-lg bg-white p-2 text-xs border border-amber-100">
                            <div>
                                <p class="font-semibold text-stone-800">{{ $promo->name }} ({{ $promo->product->name ?? '-' }})</p>
                                <p class="text-[10px] text-stone-500">Diskon: {{ $promo->discount_type === 'percentage' ? $promo->discount_value.'%' : 'Rp '.number_format((float)$promo->discount_value, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center gap-1">
                                <form action="{{ route('admin.promotions.toggle', $promo) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded px-2 py-1 text-[10px] font-semibold {{ $promo->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                                        {{ $promo->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.promotions.destroy', $promo) }}" method="POST" onsubmit="return confirm('Hapus promo ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded px-1.5 py-1 text-[10px] text-rose-600 hover:bg-rose-50">✕</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-stone-500">Belum ada promo. Tambahkan promo untuk paket kopi.</p>
                    @endforelse
                </div>

                {{-- Form Tambah Promo --}}
                <form action="{{ route('admin.promotions.store') }}" method="POST" class="mt-3 pt-3 border-t border-amber-200 space-y-2">
                    @csrf
                    <div class="grid grid-cols-2 gap-2">
                        <select name="product_id" required class="col-span-2 rounded border border-stone-200 bg-white px-2 py-1.5 text-xs">
                            <option value="">-- Pilih Produk Promo --</option>
                            @foreach($products as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="name" placeholder="Nama promo (mis: Promo Panen)" required class="col-span-2 rounded border border-stone-200 bg-white px-2 py-1.5 text-xs">
                        <select name="discount_type" class="rounded border border-stone-200 bg-white px-2 py-1.5 text-xs">
                            <option value="percentage">Persen (%)</option>
                            <option value="fixed">Nominal (Rp)</option>
                        </select>
                        <input type="number" step="0.1" name="discount_value" placeholder="Nilai diskon" required class="rounded border border-stone-200 bg-white px-2 py-1.5 text-xs">
                        <input type="date" name="start_date" value="{{ date('Y-m-d') }}" required class="rounded border border-stone-200 bg-white px-2 py-1.5 text-xs">
                        <input type="date" name="end_date" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required class="rounded border border-stone-200 bg-white px-2 py-1.5 text-xs">
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-amber-800 py-1.5 text-xs font-semibold text-white hover:bg-amber-900 transition">+ Tambah Promo</button>
                </form>
            </div>
        </article>
    </section>

    {{-- FITUR 3 & FITUR 2 (Part B): Laporan Finansial & User Matrix --}}
    <section class="grid grid-cols-1 gap-5 xl:grid-cols-5">
        {{-- FITUR 3: Laporan Finansial Komprehensif --}}
        <article class="rounded-2xl border border-sand bg-white p-5 shadow-sm sm:p-6 xl:col-span-3">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[.16em] text-amber-700">Fitur 3 · Akuntansi</p>
                    <h2 class="mt-1 font-serif text-xl font-bold text-forest">Laporan Finansial Komprehensif</h2>
                    <p class="mt-1 text-sm text-stone-500">Rangkuman omset kotor, modal beli petani, biaya roasting, dan laba bersih.</p>
                </div>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-3 lg:grid-cols-4">
                <div class="rounded-xl bg-stone-50 p-3.5">
                    <p class="text-[11px] text-stone-500">1. Omzet Kotor</p>
                    <p class="mt-1 text-sm font-bold text-forest">Rp {{ number_format((float) ($stats['total_revenue'] ?? 0), 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl bg-stone-50 p-3.5">
                    <p class="text-[11px] text-stone-500">2. Modal Petani</p>
                    <p class="mt-1 text-sm font-bold text-stone-700">Rp {{ number_format((float) ($stats['total_farmer_cost'] ?? 0), 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl bg-stone-50 p-3.5">
                    <p class="text-[11px] text-stone-500">3. Biaya Roasting</p>
                    <p class="mt-1 text-sm font-bold text-stone-700">Rp {{ number_format((float) ($stats['total_roasting_cost'] ?? 0), 0, ',', '.') }}</p>
                </div>
                <div class="rounded-xl bg-emerald-50 p-3.5">
                    <p class="text-[11px] text-emerald-800">4. Laba Bersih</p>
                    <p class="mt-1 text-sm font-bold {{ ($stats['net_profit'] ?? 0) >= 0 ? 'text-emerald-800' : 'text-rose-600' }}">
                        Rp {{ number_format((float) ($stats['net_profit'] ?? 0), 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Breakdown formula --}}
            <div class="mt-4 rounded-xl border border-stone-200 bg-stone-50/50 p-4 text-xs text-stone-600 space-y-2">
                <div class="flex justify-between font-semibold border-b border-stone-200 pb-2">
                    <span>Komponen Perhitungan:</span>
                    <span>Nominal</span>
                </div>
                <div class="flex justify-between text-forest">
                    <span>(+) Omzet Penjualan Konsumen</span>
                    <span>Rp {{ number_format((float)($stats['total_revenue'] ?? 0), 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-rose-600">
                    <span>(−) Total Pembelian Pasokan Petani (Disetujui)</span>
                    <span>Rp {{ number_format((float)($stats['total_farmer_cost'] ?? 0), 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-rose-600">
                    <span>(−) Total Biaya Operasional Roasting (Batch)</span>
                    <span>Rp {{ number_format((float)($stats['total_roasting_cost'] ?? 0), 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold pt-2 border-t border-stone-200 {{ ($stats['net_profit'] ?? 0) >= 0 ? 'text-emerald-800' : 'text-rose-600' }}">
                    <span>(=) Estimasi Laba Bersih Roastery</span>
                    <span>Rp {{ number_format((float)($stats['net_profit'] ?? 0), 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Riwayat Roasting Batch Terbaru --}}
            <div class="mt-5">
                <h3 class="text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Riwayat Batch Roasting Terbaru</h3>
                <div class="overflow-x-auto rounded-xl border border-stone-100">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-stone-50 text-[10px] uppercase text-stone-500">
                            <tr>
                                <th class="px-3 py-2">Tanggal</th>
                                <th class="px-3 py-2">Produk</th>
                                <th class="px-3 py-2 text-right">Biji Mentah</th>
                                <th class="px-3 py-2 text-right">Hasil (1 kg)</th>
                                <th class="px-3 py-2 text-right">Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($recentBatches as $batch)
                                <tr>
                                    <td class="px-3 py-2">{{ $batch->created_at->format('d/m/Y') }}</td>
                                    <td class="px-3 py-2 font-semibold">{{ $batch->product->name ?? '-' }}</td>
                                    <td class="px-3 py-2 text-right">{{ $batch->green_bean_weight_kg }} kg (susut {{ $batch->shrinkage_percentage }}%)</td>
                                    <td class="px-3 py-2 text-right font-bold text-forest">{{ $batch->packages_produced }} paket</td>
                                    <td class="px-3 py-2 text-right">Rp {{ number_format((float)$batch->roasting_cost, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-3 py-4 text-center text-stone-400">Belum ada batch roasting yang tercatat.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </article>

        {{-- FITUR 2 (Part B): Matriks Pengguna & Kontrol Akses --}}
        <article class="rounded-2xl border border-sand bg-white p-5 shadow-sm sm:p-6 xl:col-span-2">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[.16em] text-amber-700">Fitur 2 · Hak Akses</p>
                    <h2 class="mt-1 font-serif text-xl font-bold text-forest">Matriks Pengguna</h2>
                    <p class="mt-1 text-sm text-stone-500">Kelola peran & hak akses Kasir, Petani, dan Konsumen.</p>
                </div>
            </div>

            {{-- Ringkasan Role --}}
            <div class="mt-4 space-y-2">
                @foreach ([['admin', 'Administrator', 'bg-rose-50 text-rose-800'], ['kasir', 'Kasir', 'bg-sky-50 text-sky-800'], ['petani', 'Petani', 'bg-emerald-50 text-emerald-800'], ['user', 'Konsumen', 'bg-amber-50 text-amber-800']] as [$role, $label, $badge])
                    @php $roleUsers = $users->where('role', $role); @endphp
                    <div class="flex items-center justify-between gap-3 rounded-xl bg-stone-50 px-3.5 py-2.5">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-stone-800">{{ $label }}</p>
                            <p class="text-[10px] text-stone-400">{{ $roleUsers->count() }} akun terdaftar</p>
                        </div>
                        <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold {{ $badge }}">Level {{ $role === 'admin' ? 1 : ($role === 'user' ? 3 : 2) }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Tabel Edit Akun --}}
            <div class="mt-5">
                <p class="text-xs font-bold text-stone-700 mb-2">Daftar Akun & Ubah Hak Akses</p>
                <div class="max-h-72 overflow-y-auto divide-y divide-stone-100 pr-1">
                    @foreach($users as $u)
                        <div class="py-2.5 flex items-center justify-between gap-2 text-xs">
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-stone-800 truncate">{{ $u->name }}</p>
                                <p class="text-[10px] text-stone-400 truncate">{{ $u->email }}</p>
                            </div>
                            @if($u->id !== auth()->id())
                                <form action="{{ route('admin.users.update', $u) }}" method="POST" class="flex items-center gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()" class="rounded border border-stone-200 bg-white px-2 py-1 text-[11px] font-medium text-stone-700">
                                        <option value="kasir" {{ $u->role === 'kasir' ? 'selected' : '' }}>Kasir (L2)</option>
                                        <option value="petani" {{ $u->role === 'petani' ? 'selected' : '' }}>Petani (L2)</option>
                                        <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>Konsumen (L3)</option>
                                    </select>
                                </form>
                                <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus user {{ $u->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-stone-400 hover:text-rose-600 px-1">✕</button>
                                </form>
                            @else
                                <span class="text-[10px] italic text-stone-400">(Akun Anda)</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </article>
    </section>

    {{-- FITUR 1 (Part B): Persetujuan Pasokan Petani --}}
    <section class="rounded-2xl border border-sand bg-white p-5 shadow-sm sm:p-6">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[.16em] text-amber-700">Fitur 1 · Pasokan Bahan Baku</p>
                <h2 class="mt-1 font-serif text-xl font-bold text-forest">Persetujuan Pasokan Petani</h2>
                <p class="mt-1 text-sm text-stone-500">Tinjau dan setujui pasokan green bean sebelum disangrai (roasting).</p>
            </div>
            <span class="rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-800">
                {{ $stats['total_supplies_pending'] ?? 0 }} Pasokan Menunggu Persetujuan
            </span>
        </div>

        <div class="mt-5 overflow-x-auto rounded-xl border border-stone-100">
            <table class="w-full min-w-[700px] text-left text-sm">
                <thead class="bg-stone-50 text-[11px] uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Petani / Pemasok</th>
                        <th class="px-4 py-3 font-semibold">Jenis Biji & Asal</th>
                        <th class="px-4 py-3 text-right font-semibold">Berat</th>
                        <th class="px-4 py-3 text-right font-semibold">Total Biaya Beli</th>
                        <th class="px-4 py-3 text-center font-semibold">Status</th>
                        <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($supplies as $supply)
                        <tr class="hover:bg-stone-50/70">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-stone-800">{{ $supply->user->name ?? 'Petani Eksternal' }}</p>
                                <p class="text-[11px] text-stone-400">{{ $supply->created_at->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-stone-800">{{ $supply->bean_type }}</p>
                                <p class="text-xs text-stone-500">{{ $supply->origin_name }}</p>
                            </td>
                            <td class="px-4 py-3 text-right font-semibold text-stone-800">
                                {{ $supply->weight_kg }} kg
                            </td>
                            <td class="px-4 py-3 text-right font-semibold text-stone-700">
                                Rp {{ number_format((float) $supply->total_purchase_cost, 0, ',', '.') }}
                                <div class="text-[10px] text-stone-400">@ Rp {{ number_format((float) $supply->purchase_cost_per_kg, 0, ',', '.') }}/kg</div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $supply->status_badge }}">
                                    {{ $supply->status_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if($supply->status === 'menunggu')
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.supplies.approve', $supply) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 transition">
                                                Setujui ✓
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.supplies.reject', $supply) }}" method="POST" onsubmit="return confirm('Tolak pasokan ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100 transition">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-stone-400">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-stone-400">
                                Belum ada data pasokan petani.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Transaksi Konsumen --}}
    <section class="rounded-2xl border border-sand bg-white p-5 shadow-sm sm:p-6">
        <div class="mb-5 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[.16em] text-amber-700">Aktivitas Penjualan</p>
                <h2 class="mt-1 font-serif text-xl font-bold text-forest">Transaksi Konsumen</h2>
                <p class="mt-1 text-sm text-stone-500">Pesanan terbaru untuk kopi kemasan 1 kg.</p>
            </div>
            <span class="w-fit rounded-full bg-stone-100 px-3 py-1.5 text-xs font-semibold text-stone-600">{{ $recentOrders->count() }} transaksi terbaru</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="border-b border-stone-100 text-[11px] uppercase tracking-wider text-stone-500">
                    <tr>
                        <th class="px-3 py-3 font-semibold">Kode Pesanan</th>
                        <th class="px-3 py-3 font-semibold">Pemesan</th>
                        <th class="px-3 py-3 font-semibold">Produk</th>
                        <th class="px-3 py-3 text-right font-semibold">Total</th>
                        <th class="px-3 py-3 text-center font-semibold">Status</th>
                        <th class="px-3 py-3 text-right font-semibold">Nota</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-stone-50/70">
                            <td class="px-3 py-3 font-mono text-xs font-semibold text-forest">
                                {{ $order->order_code }}
                                <div class="mt-1 font-sans text-[10px] font-normal text-stone-400">{{ $order->created_at?->format('d/m/Y H:i') ?? '-' }}</div>
                            </td>
                            <td class="px-3 py-3">
                                <p class="font-semibold text-stone-800">{{ $order->recipient_name }}</p>
                                <p class="text-[11px] text-stone-400">{{ $order->shipping_phone }}</p>
                            </td>
                            <td class="px-3 py-3 text-xs text-stone-600">
                                @foreach($order->items as $item)
                                    <div>{{ $item->product?->name ?? 'Produk tidak tersedia' }} · {{ $item->quantity_package }} paket</div>
                                @endforeach
                            </td>
                            <td class="px-3 py-3 text-right font-semibold text-forest">Rp {{ number_format((float) ($order->total_amount ?? 0), 0, ',', '.') }}</td>
                            <td class="px-3 py-3 text-center"><span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $order->status_badge_color }}">{{ $order->status_label }}</span></td>
                            <td class="px-3 py-3 text-right"><a href="{{ route('orders.show', $order) }}" class="text-xs font-semibold text-forest hover:underline">Buka →</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-3 py-8 text-center text-sm text-stone-400">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<script>
    // Live Roasting Calculation
    const greenBeanInput = document.getElementById('greenBeanInput');
    const shrinkageInput = document.getElementById('shrinkageInput');
    const supplySelect = document.getElementById('supplySelect');
    const estPackages = document.getElementById('estPackages');
    const estFormula = document.getElementById('estFormula');
    const estResult = document.getElementById('estResult');

    function calculateRoasting() {
        const green = parseFloat(greenBeanInput.value) || 0;
        const shrinkage = parseFloat(shrinkageInput.value) || 0;
        const shrinkKg = green * (shrinkage / 100);
        const roasted = Math.max(0, green - shrinkKg);
        const packages = Math.floor(roasted);

        estPackages.innerHTML = `${packages} paket <span class="font-sans text-sm font-medium">siap jual</span>`;
        estFormula.textContent = `${green.toFixed(1)} kg masuk − ${shrinkKg.toFixed(1)} kg susut`;
        estResult.textContent = `${roasted.toFixed(1)} kg → ${packages} paket utuh 1 kg`;
    }

    if (greenBeanInput && shrinkageInput) {
        greenBeanInput.addEventListener('input', calculateRoasting);
        shrinkageInput.addEventListener('input', calculateRoasting);
    }

    if (supplySelect) {
        supplySelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const weight = selected.getAttribute('data-weight');
            if (weight) {
                greenBeanInput.value = weight;
                calculateRoasting();
            }
        });
    }
</script>
@endsection
