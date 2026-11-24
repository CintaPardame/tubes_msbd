@extends('dashboard.layout')

@section('title', 'Petani / Produsen Dashboard (Level 2)')

@section('content')
<div class="space-y-8">
    
    <!-- Header -->
    <div class="bg-forest text-cream p-6 sm:p-8 rounded-3xl shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider inline-block mb-2 border border-emerald-500/30">
                Hak Akses: Petani & Produsen Biji Kopi (Level 2)
            </span>
            <h1 class="font-serif font-bold text-2xl sm:text-3xl text-cream">Monitoring Pasokan & Hasil Kebun</h1>
            <p class="text-xs text-cream/70 mt-1">Laporan pasokan biji kopi single origin dari perkebunan hulu mitra C3, kapasitas stok sangrai, dan penyerapan pasar.</p>
        </div>

        <div class="bg-forest-light px-4 py-3 rounded-2xl border border-emerald-600/30 text-xs">
            <span class="text-emerald-300 block font-semibold">Status Kemitraan:</span>
            <span class="font-bold text-cream">Direct Trade Terverifikasi 🌿</span>
        </div>
    </div>

    <!-- Metric Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-sand shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-stone-500 block">Total Pasokan Stok Siap Jual</span>
                <span class="font-serif font-bold text-3xl text-forest mt-1 block">{{ $totalStockKg }} kg</span>
                <span class="text-[11px] text-emerald-700 font-medium">Dalam kemasan paket 1 kg</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl">
                ⚖️
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-sand shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-stone-500 block">Penyerapan Biji Kopi Terjual</span>
                <span class="font-serif font-bold text-3xl text-amber-800 mt-1 block">{{ $totalSalesPackages }} kg</span>
                <span class="text-[11px] text-stone-400">Total paket terdistribusi</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amberCustom-dark flex items-center justify-center text-2xl">
                📦
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-sand shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-stone-500 block">Sentra Perkebunan Mitra</span>
                <span class="font-serif font-bold text-3xl text-forest mt-1 block">{{ $origins->count() }} Daerah</span>
                <span class="text-[11px] text-stone-400">Gayo, Kintamani, Bajawa, dll</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-cream text-forest flex items-center justify-center text-2xl">
                ⛰️
            </div>
        </div>
    </div>

    <!-- Origins / Kebun Binaan -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm">
        <h3 class="font-serif font-bold text-xl text-forest mb-2">Sentra Perkebunan Biji Kopi (Origins)</h3>
        <p class="text-xs text-stone-500 mb-6">Data ketinggian dan komoditas varietas kopi yang dibudidayakan para kelompok tani binaan C3</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($origins as $origin)
                <div class="p-5 rounded-2xl border border-sand bg-stone-50 flex gap-4 items-start">
                    <img src="{{ $origin->image_url }}" alt="{{ $origin->name }}" class="w-16 h-16 rounded-xl object-cover flex-shrink-0 shadow-sm">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-amber-800 block">{{ $origin->province }}</span>
                        <h4 class="font-serif font-bold text-base text-forest">{{ $origin->name }}</h4>
                        <p class="text-xs text-stone-500 mt-1">Elevasi: <span class="font-semibold text-stone-700">{{ $origin->altitude }}</span></p>
                        <p class="text-[11px] text-emerald-700 font-semibold mt-1">✓ {{ $origin->products_count }} Varian Biji Kopi Aktif</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Produk & Ketersediaan Stok (Kemasan 1 kg) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm">
        <h3 class="font-serif font-bold text-xl text-forest mb-2">Stok Biji Kopi Per Paket (1 kg)</h3>
        <p class="text-xs text-stone-500 mb-6">Monitoring ketersediaan produk per varian pasca sangrai di roastery</p>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-cream text-forest font-serif font-bold border-b border-sand">
                    <tr>
                        <th class="p-3.5">Varian Kopi</th>
                        <th class="p-3.5">Asal Daerah</th>
                        <th class="p-3.5">Metode Olah</th>
                        <th class="p-3.5">Roast Level</th>
                        <th class="p-3.5 text-center">Stok Siap Jual</th>
                        <th class="p-3.5 text-right">Harga / Paket (1kg)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand">
                    @foreach($products as $p)
                        <tr class="hover:bg-stone-50">
                            <td class="p-3.5 font-bold text-forest text-sm">
                                {{ $p->name }}
                            </td>
                            <td class="p-3.5 text-stone-600">{{ $p->origin->name }}</td>
                            <td class="p-3.5 text-stone-600">{{ $p->process_method }}</td>
                            <td class="p-3.5">
                                <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-700 text-[11px] font-medium border border-stone-200">
                                    {{ $p->roast_level }}
                                </span>
                            </td>
                            <td class="p-3.5 text-center font-bold text-forest text-sm">
                                {{ $p->stock }} Paket ({{ $p->stock }} kg)
                            </td>
                            <td class="p-3.5 text-right font-serif font-bold text-forest">
                                Rp {{ number_format($p->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
