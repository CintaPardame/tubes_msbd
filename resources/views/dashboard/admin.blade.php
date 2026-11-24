@extends('dashboard.layout')

@section('title', 'Admin Dashboard (Level 1)')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header -->
    <div class="bg-forest text-cream p-6 sm:p-8 rounded-3xl shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="px-3 py-1 rounded-full bg-rose-500/20 text-rose-300 text-xs font-bold uppercase tracking-wider inline-block mb-2 border border-rose-500/30">
                Hak Akses: Administrator (Level 1)
            </span>
            <h1 class="font-serif font-bold text-2xl sm:text-3xl text-cream">Panel Kendali Utama Roastery C3</h1>
            <p class="text-xs text-cream/70 mt-1">Mengelola seluruh data master sistem: pengguna, pesanan, pasokan, dan keuangan.</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-full bg-amberCustom text-forest font-bold text-xs hover:bg-amber-400 transition-colors">
                + Buka Katalog Produk
            </a>
        </div>
    </div>

    <!-- Stat Metric Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-sand shadow-sm">
            <span class="text-xs text-stone-500 block">Total Pengguna</span>
            <span class="font-serif font-bold text-2xl text-forest mt-1 block">{{ $stats['total_users'] }} User</span>
            <span class="text-[10px] text-amber-800">4 Role & 3 Level</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-sand shadow-sm">
            <span class="text-xs text-stone-500 block">Total Pesanan</span>
            <span class="font-serif font-bold text-2xl text-forest mt-1 block">{{ $stats['total_orders'] }} Transaksi</span>
            <span class="text-[10px] text-emerald-700">Semua riwayat</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-sand shadow-sm">
            <span class="text-xs text-stone-500 block">Pendapatan Bruto</span>
            <span class="font-serif font-bold text-xl text-forest mt-1 block truncate">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</span>
            <span class="text-[10px] text-emerald-700">Pemesanan aktif</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-sand shadow-sm">
            <span class="text-xs text-stone-500 block">Varian Biji Kopi</span>
            <span class="font-serif font-bold text-2xl text-forest mt-1 block">{{ $stats['total_products'] }} Produk</span>
            <span class="text-[10px] text-stone-400">Kemasan 1 kg</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-sand shadow-sm col-span-2 md:col-span-1">
            <span class="text-xs text-stone-500 block">Daerah Asal (Origin)</span>
            <span class="font-serif font-bold text-2xl text-forest mt-1 block">{{ $stats['total_origins'] }} Kebun</span>
            <span class="text-[10px] text-stone-400">Sentra Nusantara</span>
        </div>
    </div>

    <!-- Section 1: Daftar Seluruh Pengguna (4 Role & 3 Level) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-serif font-bold text-xl text-forest">Struktur Pengguna Berdasarkan Role & Level</h3>
                <p class="text-xs text-stone-500">Menampilkan matriks 4 role (Admin, Kasir, Petani, Konsumen) dan 3 level otoritas</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-cream border border-sand text-stone-700">
                Total: {{ $users->count() }} Akun
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-cream text-forest font-serif font-bold border-b border-sand">
                    <tr>
                        <th class="p-3.5">Nama & Kontak</th>
                        <th class="p-3.5">Role Sistem</th>
                        <th class="p-3.5 text-center">Level Otoritas</th>
                        <th class="p-3.5">Tanggung Jawab / Otoritas</th>
                        <th class="p-3.5">Alamat / Lokasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand">
                    @foreach($users as $u)
                        <tr class="hover:bg-stone-50">
                            <td class="p-3.5 font-medium">
                                <div class="font-bold text-forest text-sm">{{ $u->name }}</div>
                                <div class="text-[11px] text-stone-400">{{ $u->email }} • {{ $u->phone ?? '-' }}</div>
                            </td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-1 rounded-full font-bold uppercase text-[10px]
                                    @if($u->role === 'admin') bg-rose-100 text-rose-800 border border-rose-300
                                    @elseif($u->role === 'kasir') bg-blue-100 text-blue-800 border border-blue-300
                                    @elseif($u->role === 'petani') bg-emerald-100 text-emerald-800 border border-emerald-300
                                    @else bg-amber-100 text-amber-800 border border-amber-300
                                    @endif">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="p-3.5 text-center font-bold text-forest">
                                <span class="w-7 h-7 rounded-full inline-flex items-center justify-center bg-stone-100 text-stone-800 border border-stone-200">
                                    {{ $u->level }}
                                </span>
                            </td>
                            <td class="p-3.5 text-stone-600">
                                @if($u->role === 'admin')
                                    <span class="font-medium text-rose-900">Hak Penuh: Kelola Data Master & Keuangan</span>
                                @elseif($u->role === 'kasir')
                                    <span class="font-medium text-blue-900">Operasional: Verifikasi Pembayaran & Kirim Order</span>
                                @elseif($u->role === 'petani')
                                    <span class="font-medium text-emerald-900">Produksi: Pasokan Biji Kopi Mentah / Origin</span>
                                @else
                                    <span class="font-medium text-amber-900">Konsumen: Pemesanan Biji Kopi Per Paket (1 kg)</span>
                                @endif
                            </td>
                            <td class="p-3.5 text-stone-500 max-w-xs truncate">
                                {{ $u->address ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 2: Transaksi Pesanan Terbaru -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-serif font-bold text-xl text-forest">Daftar Transaksi Pesanan Konsumen</h3>
                <p class="text-xs text-stone-500">Semua pesanan per paket (1 kg) yang masuk ke sistem C3</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-cream text-forest font-serif font-bold border-b border-sand">
                    <tr>
                        <th class="p-3.5">Kode Pesanan</th>
                        <th class="p-3.5">Pemesan</th>
                        <th class="p-3.5">Item Biji Kopi</th>
                        <th class="p-3.5 text-right">Total Tagihan</th>
                        <th class="p-3.5 text-center">Status</th>
                        <th class="p-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand">
                    @foreach($recentOrders as $order)
                        <tr class="hover:bg-stone-50">
                            <td class="p-3.5 font-bold font-mono text-forest">
                                {{ $order->order_code }}
                                <div class="text-[10px] text-stone-400 font-sans font-normal">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="p-3.5">
                                <div class="font-bold text-stone-800">{{ $order->recipient_name }}</div>
                                <div class="text-[10px] text-stone-500">📞 {{ $order->shipping_phone }}</div>
                            </td>
                            <td class="p-3.5 text-stone-700">
                                @foreach($order->items as $item)
                                    <div>• {{ $item->product->name }} ({{ $item->quantity_package }} Paket = {{ $item->quantity_package * 1 }} kg)</div>
                                @endforeach
                            </td>
                            <td class="p-3.5 text-right font-serif font-bold text-forest">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="p-3.5 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $order->status_badge_color }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="p-3.5 text-center">
                                <a href="{{ route('orders.show', $order) }}" class="px-3 py-1 bg-forest hover:bg-forest-light text-cream rounded-lg text-[11px] font-medium transition-colors">
                                    Nota / Invoice
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
