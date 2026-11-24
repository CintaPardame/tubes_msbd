@extends('dashboard.layout')

@section('title', 'Kasir Dashboard (Level 2)')

@section('content')
<div class="space-y-8">
    
    <!-- Header -->
    <div class="bg-forest text-cream p-6 sm:p-8 rounded-3xl shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 text-xs font-bold uppercase tracking-wider inline-block mb-2 border border-blue-500/30">
                Hak Akses: Kasir Operasional (Level 2)
            </span>
            <h1 class="font-serif font-bold text-2xl sm:text-3xl text-cream">Manajemen Pesanan & Pembayaran</h1>
            <p class="text-xs text-cream/70 mt-1">Verifikasi pembayaran masuk dari konsumen, perbarui status order, dan koordinasi pengiriman paket 1kg.</p>
        </div>
    </div>

    <!-- Status Metric Summary -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-amber-50 border border-amber-200 p-4 rounded-2xl">
            <span class="text-xs text-amber-800 font-semibold block">Menunggu Pembayaran</span>
            <span class="font-serif font-bold text-2xl text-amber-900 mt-1 block">{{ $stats['pending'] }} Pesanan</span>
        </div>

        <div class="bg-blue-50 border border-blue-200 p-4 rounded-2xl">
            <span class="text-xs text-blue-800 font-semibold block">Sedang Diproses</span>
            <span class="font-serif font-bold text-2xl text-blue-900 mt-1 block">{{ $stats['processing'] }} Pesanan</span>
        </div>

        <div class="bg-purple-50 border border-purple-200 p-4 rounded-2xl">
            <span class="text-xs text-purple-800 font-semibold block">Sedang Dikirim</span>
            <span class="font-serif font-bold text-2xl text-purple-900 mt-1 block">{{ $stats['shipping'] }} Pesanan</span>
        </div>

        <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-2xl">
            <span class="text-xs text-emerald-800 font-semibold block">Selesai</span>
            <span class="font-serif font-bold text-2xl text-emerald-900 mt-1 block">{{ $stats['completed'] }} Pesanan</span>
        </div>
    </div>

    <!-- Orders Queue with Status Update Action -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-serif font-bold text-xl text-forest">Antrean Pesanan Konsumen</h3>
                <p class="text-xs text-stone-500">Kasir dapat langsung mengganti status pesanan setelah konfirmasi dana / resi</p>
            </div>
            <span class="text-xs text-stone-500">Total: {{ $orders->count() }} Transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-cream text-forest font-serif font-bold border-b border-sand">
                    <tr>
                        <th class="p-3.5">Kode & Tanggal</th>
                        <th class="p-3.5">Penerima & Alamat</th>
                        <th class="p-3.5">Item Pesanan (Paket 1kg)</th>
                        <th class="p-3.5 text-right">Total</th>
                        <th class="p-3.5 text-center">Status Saat Ini</th>
                        <th class="p-3.5 text-center">Perbarui Status</th>
                        <th class="p-3.5 text-center">Invoice</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand">
                    @forelse($orders as $order)
                        <tr class="hover:bg-stone-50">
                            <td class="p-3.5 font-bold font-mono text-forest">
                                {{ $order->order_code }}
                                <div class="text-[10px] text-stone-400 font-sans font-normal">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="p-3.5">
                                <div class="font-bold text-stone-800">{{ $order->recipient_name }}</div>
                                <div class="text-[10px] text-stone-500">📞 {{ $order->shipping_phone }}</div>
                                <div class="text-[10px] text-stone-400 max-w-xs truncate">{{ $order->shipping_address }}</div>
                            </td>
                            <td class="p-3.5 text-stone-700">
                                @foreach($order->items as $item)
                                    <div class="font-medium">• {{ $item->product->name }}</div>
                                    <div class="text-[10px] text-stone-400">({{ $item->quantity_package }} Paket = {{ $item->quantity_package * 1 }} kg) [{{ $item->grind_size }}]</div>
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
                                <form action="{{ route('dashboard.order.status', $order) }}" method="POST" class="inline-flex items-center gap-1.5">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-[11px] px-2 py-1 rounded-lg border border-sand bg-stone-50 focus:bg-white text-forest font-medium">
                                        <option value="menunggu_pembayaran" {{ $order->status === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Bayar</option>
                                        <option value="diproses_kasir" {{ $order->status === 'diproses_kasir' ? 'selected' : '' }}>Diproses Kasir</option>
                                        <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                                        <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-3.5 text-center">
                                <a href="{{ route('orders.show', $order) }}" class="p-1.5 text-forest hover:text-amber-800 text-xs font-bold" title="Lihat Invoice">
                                    📄 Nota
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-stone-400">Belum ada pesanan yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
