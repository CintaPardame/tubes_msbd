@extends('dashboard.layout')

@section('title', 'Dashboard Konsumen (Level 3)')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header & New Order Action -->
    <div class="bg-forest text-cream p-6 sm:p-8 rounded-3xl shadow-md flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 text-xs font-bold uppercase tracking-wider inline-block mb-2 border border-amber-500/30">
                Hak Akses: Konsumen (Level 3)
            </span>
            <h1 class="font-serif font-bold text-2xl sm:text-3xl text-cream">Halo, {{ auth()->user()->name }}!</h1>
            <p class="text-xs text-cream/70 mt-1 max-w-xl">
                Selamat datang di akun pemesanan biji kopi Circle Concordia Coffee. Semua pembelian dihitung per paket (1 paket = 1 kg).
            </p>
        </div>

        <div>
            <a href="{{ route('orders.create') }}" class="px-6 py-3.5 rounded-full bg-amberCustom hover:bg-amber-400 text-forest font-bold text-xs uppercase tracking-wider shadow-lg transition-all inline-flex items-center gap-2">
                <span>☕ Pesan Biji Kopi (1 kg) Baru</span>
                <span>→</span>
            </a>
        </div>
    </div>

    <!-- Riwayat Pesanan Konsumen -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-serif font-bold text-xl text-forest">Riwayat Pesanan Anda</h3>
                <p class="text-xs text-stone-500">Daftar paket biji kopi yang pernah Anda pesan di C3</p>
            </div>
            <span class="text-xs text-stone-500 font-medium">Total: {{ $myOrders->count() }} Transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-cream text-forest font-serif font-bold border-b border-sand">
                    <tr>
                        <th class="p-3.5">Kode Transaksi</th>
                        <th class="p-3.5">Tanggal</th>
                        <th class="p-3.5">Varian Biji Kopi</th>
                        <th class="p-3.5 text-center">Jumlah Paket (kg)</th>
                        <th class="p-3.5 text-right">Total Pembayaran</th>
                        <th class="p-3.5 text-center">Status Pesanan</th>
                        <th class="p-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand">
                    @forelse($myOrders as $order)
                        <tr class="hover:bg-stone-50">
                            <td class="p-3.5 font-bold font-mono text-forest">
                                {{ $order->order_code }}
                            </td>
                            <td class="p-3.5 text-stone-500">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="p-3.5 text-stone-800">
                                @foreach($order->items as $item)
                                    <div class="font-semibold">{{ $item->product->name }}</div>
                                    <div class="text-[10px] text-stone-500">({{ $item->grind_size }})</div>
                                @endforeach
                            </td>
                            <td class="p-3.5 text-center font-bold text-forest">
                                {{ $order->items->sum('quantity_package') }} Paket ({{ $order->items->sum('quantity_package') * 1 }} kg)
                            </td>
                            <td class="p-3.5 text-right font-serif font-bold text-forest">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="p-3.5 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold border {{ $order->status_badge_color }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="p-3.5 text-center">
                                <a href="{{ route('orders.show', $order) }}" class="px-3 py-1.5 rounded-lg bg-forest hover:bg-forest-light text-cream font-medium text-[11px] transition-colors inline-block">
                                    Lihat Nota / Bayar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-stone-400">
                                Anda belum memiliki riwayat pesanan. 
                                <a href="{{ route('orders.create') }}" class="font-semibold text-amber-800 hover:underline ml-1">Pesan paket 1 kg pertama Anda sekarang!</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Rekomendasi Biji Kopi Populer -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm">
        <h3 class="font-serif font-bold text-xl text-forest mb-2">Rekomendasi Biji Kopi Populer (1 kg)</h3>
        <p class="text-xs text-stone-500 mb-6">Pilih langsung untuk memesan paket biji kopi favorit pelanggan C3</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($popularProducts as $prod)
                <div class="p-4 rounded-2xl border border-sand bg-cream/40 flex flex-col justify-between group">
                    <img src="{{ $prod->main_image }}" alt="{{ $prod->name }}" class="w-full h-36 object-cover rounded-xl mb-3">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-amber-800">{{ $prod->roast_level }} Roast</span>
                        <h4 class="font-serif font-bold text-sm text-forest mt-0.5">{{ $prod->name }}</h4>
                        <p class="font-serif font-bold text-amber-900 mt-2 text-sm">
                            Rp {{ number_format($prod->price, 0, ',', '.') }} <span class="text-[10px] font-sans font-normal text-stone-500">/ 1 kg</span>
                        </p>
                    </div>

                    <a href="{{ route('orders.create', ['product_id' => $prod->id]) }}" class="mt-4 w-full py-2 rounded-xl bg-forest hover:bg-forest-light text-cream text-center text-xs font-semibold transition-colors block">
                        Pesan 1 kg Ini
                    </a>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
