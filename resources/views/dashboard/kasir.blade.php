@extends('dashboard.layout')

@section('title', 'Kasir Dashboard (Level 2)')

@section('content')
<div class="space-y-8">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span>✓</span>
                <span>{{ session('success') }}</span>
            </div>
            @if(session('print_invoice_order_id'))
                <a href="{{ route('kasir.invoice.print', session('print_invoice_order_id')) }}" target="_blank" class="px-3 py-1.5 bg-emerald-800 text-white rounded-xl text-xs font-bold hover:bg-emerald-900 transition flex items-center gap-1">
                    <span>🖨️ Cetak Invoice Sekarang</span>
                </a>
            @endif
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-800">
            ✕ {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="bg-forest text-cream p-6 sm:p-8 rounded-3xl shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="mb-2 flex flex-wrap items-center gap-2">
                <span class="rounded-full border border-blue-500/30 bg-blue-500/20 px-3 py-1 text-xs font-bold uppercase tracking-wider text-blue-300">
                    Kasir Operasional · Level 2
                </span>
                <span class="rounded-full bg-amber-500/20 border border-amber-500/30 px-3 py-1 text-xs font-semibold text-amber-200">
                    Validasi Keuangan & Pengiriman
                </span>
            </div>
            <h1 class="font-serif font-bold text-2xl sm:text-3xl text-cream">Manajemen Pesanan, Resi & Tutup Buku</h1>
            <p class="text-xs text-cream/70 mt-1">Verifikasi pembayaran masuk dari konsumen, terbitkan invoice resmi, input resi ekspedisi, dan rekap shift harian.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="#tutup-buku" class="px-4 py-2.5 rounded-xl bg-amberCustom text-forest font-bold text-xs hover:bg-amber-400 transition shadow-sm">
                📋 Form Tutup Buku Hari Ini
            </a>
        </div>
    </div>

    <!-- Status Metric Summary -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-amber-50 border border-amber-200 p-4 rounded-2xl">
            <span class="text-xs text-amber-800 font-semibold block">Menunggu Bayar</span>
            <span class="font-serif font-bold text-2xl text-amber-900 mt-1 block">{{ $stats['pending'] }} Pesanan</span>
            <span class="text-[10px] text-amber-700/80">Perlu verifikasi kasir</span>
        </div>

        <div class="bg-blue-50 border border-blue-200 p-4 rounded-2xl">
            <span class="text-xs text-blue-800 font-semibold block">Sedang Diproses</span>
            <span class="font-serif font-bold text-2xl text-blue-900 mt-1 block">{{ $stats['processing'] }} Pesanan</span>
            <span class="text-[10px] text-blue-700/80">Siap kemas & input resi</span>
        </div>

        <div class="bg-purple-50 border border-purple-200 p-4 rounded-2xl">
            <span class="text-xs text-purple-800 font-semibold block">Sedang Dikirim</span>
            <span class="font-serif font-bold text-2xl text-purple-900 mt-1 block">{{ $stats['shipping'] }} Pesanan</span>
            <span class="text-[10px] text-purple-700/80">Dalam perjalanan ekspedisi</span>
        </div>

        <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-2xl">
            <span class="text-xs text-emerald-800 font-semibold block">Selesai</span>
            <span class="font-serif font-bold text-2xl text-emerald-900 mt-1 block">{{ $stats['completed'] }} Pesanan</span>
            <span class="text-[10px] text-emerald-700/80">Pesanan telah diterima</span>
        </div>
    </div>

    <!-- FITUR 1: Antrean Verifikasi Pembayaran (Order Verification) -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 border-b border-sand pb-4">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800 bg-amber-100 px-2 py-0.5 rounded-full">Fitur 1</span>
                <h3 class="font-serif font-bold text-xl text-forest mt-1">Antrean Verifikasi Pembayaran (Order Verification)</h3>
                <p class="text-xs text-stone-500">Periksa bukti transfer konsumen, klik <b>"Konfirmasi Bayar"</b> untuk menerbitkan invoice dan memproses pesanan.</p>
            </div>
            <span class="text-xs text-amber-800 font-semibold bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-xl">
                {{ $orders->where('status', 'menunggu_pembayaran')->count() }} Menunggu Konfirmasi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 text-forest font-semibold uppercase text-[10px]">
                    <tr>
                        <th class="p-3.5">Kode & Waktu</th>
                        <th class="p-3.5">Pemesan</th>
                        <th class="p-3.5">Total Tagihan</th>
                        <th class="p-3.5 text-center">Bukti Transfer</th>
                        <th class="p-3.5 text-center">Aksi Verifikasi (1 Klik)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($orders->where('status', 'menunggu_pembayaran') as $pendingOrder)
                        <tr class="hover:bg-amber-50/40">
                            <td class="p-3.5">
                                <span class="font-mono font-bold text-forest">{{ $pendingOrder->order_code }}</span>
                                <div class="text-[10px] text-stone-400">{{ $pendingOrder->created_at->format('d/m/Y H:i') }} WIB</div>
                            </td>
                            <td class="p-3.5">
                                <p class="font-bold text-stone-800">{{ $pendingOrder->recipient_name }}</p>
                                <p class="text-[10px] text-stone-500">📞 {{ $pendingOrder->shipping_phone }}</p>
                            </td>
                            <td class="p-3.5 font-bold font-serif text-forest text-sm">
                                Rp {{ number_format($pendingOrder->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="p-3.5 text-center">
                                @if($pendingOrder->payment_proof)
                                    <a href="{{ asset('storage/' . $pendingOrder->payment_proof) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-blue-700 font-bold hover:underline bg-blue-50 px-2 py-1 rounded-lg border border-blue-200">
                                        <span>🔍</span> Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-[11px] text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                        Konfirmasi Chat WA
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 text-center">
                                <form action="{{ route('kasir.orders.confirm_payment', $pendingOrder) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran untuk pesanan {{ $pendingOrder->order_code }}?')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl text-xs transition shadow-sm inline-flex items-center gap-1.5">
                                        <span>✓</span>
                                        <span>Konfirmasi Bayar</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-stone-400">
                                Tidak ada antrean pembayaran yang menunggu verifikasi saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- FITUR 2: Input Resi Ekspedisi & Serah Terima Pengiriman -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 border-b border-sand pb-4">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-blue-800 bg-blue-100 px-2 py-0.5 rounded-full">Fitur 2</span>
                <h3 class="font-serif font-bold text-xl text-forest mt-1">Input Resi Ekspedisi & Serah Terima Pengiriman</h3>
                <p class="text-xs text-stone-500">Input nomor resi (JNE, J&T, SiCepat, Kurir Roastery) untuk mengubah status menjadi <b>Sedang Dikirim</b>.</p>
            </div>
            <span class="text-xs text-blue-800 font-semibold bg-blue-50 border border-blue-200 px-3 py-1.5 rounded-xl">
                {{ $orders->where('status', 'diproses_kasir')->count() }} Siap Dikirim
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 text-forest font-semibold uppercase text-[10px]">
                    <tr>
                        <th class="p-3.5">Kode Pesanan</th>
                        <th class="p-3.5">Tujuan & Alamat Pengiriman</th>
                        <th class="p-3.5">Item Paket 1kg</th>
                        <th class="p-3.5">Input Ekspedisi & Resi Pengiriman</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($orders->where('status', 'diproses_kasir') as $processingOrder)
                        <tr class="hover:bg-blue-50/30">
                            <td class="p-3.5">
                                <span class="font-mono font-bold text-forest">{{ $processingOrder->order_code }}</span>
                                <div class="text-[10px] text-stone-400">Diverifikasi: {{ $processingOrder->paid_at ? $processingOrder->paid_at->format('d/m/Y H:i') : '-' }}</div>
                                <a href="{{ route('kasir.invoice.print', $processingOrder) }}" target="_blank" class="text-[11px] text-emerald-800 font-semibold hover:underline mt-1 inline-block">
                                    🖨️ Cetak Faktur
                                </a>
                            </td>
                            <td class="p-3.5">
                                <p class="font-bold text-stone-800">{{ $processingOrder->recipient_name }} ({{ $processingOrder->shipping_phone }})</p>
                                <p class="text-stone-500 text-[11px] max-w-sm mt-0.5">{{ $processingOrder->shipping_address }}</p>
                            </td>
                            <td class="p-3.5">
                                @foreach($processingOrder->items as $item)
                                    <div>• {{ $item->product->name }} ({{ $item->quantity_package }} kg - {{ $item->grind_size }})</div>
                                @endforeach
                            </td>
                            <td class="p-3.5">
                                <form action="{{ route('kasir.orders.shipping', $processingOrder) }}" method="POST" class="flex flex-wrap items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="courier_name" required class="rounded-xl border border-stone-200 bg-stone-50 px-2.5 py-1.5 text-xs text-stone-800">
                                        <option value="JNE">JNE Express</option>
                                        <option value="J&T">J&T Express</option>
                                        <option value="SiCepat">SiCepat</option>
                                        <option value="Kurir Roastery">Kurir Internal Roastery</option>
                                    </select>
                                    <input type="text" name="tracking_number" placeholder="Nomor Resi (mis: JNE98214...)" required class="rounded-xl border border-stone-200 bg-stone-50 px-3 py-1.5 text-xs text-stone-800 flex-1 min-w-[140px]">
                                    <button type="submit" class="rounded-xl bg-forest px-3.5 py-1.5 text-xs font-bold text-white hover:bg-forest-light transition shadow-sm">
                                        Kirim Resi ➔
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-stone-400">
                                Tidak ada pesanan berstatus 'Diproses' yang menunggu input resi saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Semua Riwayat Transaksi & Filter Status -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm">
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-sand">
            <div>
                <h3 class="font-serif font-bold text-xl text-forest">Semua Riwayat Pesanan Konsumen</h3>
                <p class="text-xs text-stone-500">Daftar transaksi keseluruhan dengan nomor resi dan invoice resmi.</p>
            </div>
            <span class="text-xs text-stone-500">Total: {{ $orders->count() }} Transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-cream text-forest font-serif font-bold border-b border-sand">
                    <tr>
                        <th class="p-3.5">Kode & Tanggal</th>
                        <th class="p-3.5">Penerima</th>
                        <th class="p-3.5">Item (1kg)</th>
                        <th class="p-3.5 text-right">Total</th>
                        <th class="p-3.5 text-center">Status</th>
                        <th class="p-3.5">Resi / Ekspedisi</th>
                        <th class="p-3.5 text-center">Invoice Resmi</th>
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
                            </td>
                            <td class="p-3.5 text-stone-700">
                                @foreach($order->items as $item)
                                    <div>• {{ $item->product->name }} ({{ $item->quantity_package }} kg)</div>
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
                            <td class="p-3.5">
                                @if($order->tracking_number)
                                    <span class="font-semibold text-stone-800">{{ $order->courier_name }}</span>
                                    <div class="font-mono text-[10px] text-forest font-bold">{{ $order->tracking_number }}</div>
                                @else
                                    <span class="text-stone-400 text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="p-3.5 text-center">
                                <a href="{{ route('kasir.invoice.print', $order) }}" target="_blank" class="px-2.5 py-1 text-emerald-800 bg-emerald-50 hover:bg-emerald-100 rounded-lg text-xs font-bold transition inline-flex items-center gap-1 border border-emerald-200">
                                    <span>🖨️ Cetak</span>
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

    <!-- FITUR 3: Rekap Tutup Buku Kasir Harian (Daily Cashier Summary) -->
    <div id="tutup-buku" class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 border-b border-sand pb-4">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-full">Fitur 3</span>
                <h3 class="font-serif font-bold text-xl text-forest mt-1">Rekap Tutup Buku Kasir Harian (Daily Cashier Summary)</h3>
                <p class="text-xs text-stone-500">Rekap total transaksi yang divalidasi kasir pada shift hari ini untuk diserahkan ke Admin.</p>
            </div>
            @if($todaySummary)
                <span class="text-xs bg-emerald-100 text-emerald-800 px-3 py-1.5 rounded-full font-bold">
                    ✓ Tutup Buku Hari Ini Sudah Disimpan
                </span>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Box Ringkasan Shift Hari Ini -->
            <div class="md:col-span-1 rounded-2xl bg-stone-50 border border-stone-200 p-5 space-y-4">
                <h4 class="font-serif font-bold text-forest text-sm">Aktivitas Shift Hari Ini</h4>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between text-stone-600">
                        <span>Tanggal:</span>
                        <span class="font-bold text-stone-800">{{ now()->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between text-stone-600">
                        <span>Petugas Kasir:</span>
                        <span class="font-bold text-stone-800">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="flex justify-between text-stone-600 border-t border-stone-200 pt-2">
                        <span>Transaksi Terverifikasi:</span>
                        <span class="font-bold text-emerald-800 text-sm">{{ $todayStats['count'] }} Pesanan</span>
                    </div>
                    <div class="flex justify-between text-stone-600">
                        <span>Total Uang Masuk Shift:</span>
                        <span class="font-bold font-serif text-emerald-900 text-base">
                            Rp {{ number_format($todayStats['revenue'], 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('kasir.shift.close') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melakukan Tutup Buku Shift Hari Ini dan menyerahkan rekap ke Admin?')">
                    @csrf
                    <div class="space-y-2 mt-4">
                        <label class="block text-[11px] font-semibold text-stone-600">Catatan Serah Terima Shift ke Admin:</label>
                        <textarea name="notes" rows="2" placeholder="Tuliskan catatan fisik kas, transfer, atau kondisi shift..." class="w-full rounded-xl border border-stone-200 bg-white p-2.5 text-xs text-stone-700 outline-none focus:border-forest"></textarea>
                    </div>
                    <button type="submit" class="w-full mt-3 rounded-xl bg-forest hover:bg-forest-light py-2.5 text-xs font-bold text-white transition shadow-sm">
                        🔒 Simpan Tutup Buku & Kirim ke Admin
                    </button>
                </form>
            </div>

            <!-- Tabel Riwayat Tutup Buku -->
            <div class="md:col-span-2">
                <h4 class="font-serif font-bold text-forest text-sm mb-3">Riwayat Tutup Buku Terakhir</h4>
                <div class="overflow-x-auto rounded-xl border border-stone-100">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-stone-50 text-[10px] uppercase text-stone-500">
                            <tr>
                                <th class="p-3">Tanggal Closing</th>
                                <th class="p-3">Kasir</th>
                                <th class="p-3 text-center">Jumlah Order</th>
                                <th class="p-3 text-right">Total Kas Masuk</th>
                                <th class="p-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse($dailySummaries as $summary)
                                <tr>
                                    <td class="p-3 font-semibold text-stone-800">{{ $summary->closing_date->format('d/m/Y') }}</td>
                                    <td class="p-3 text-stone-600">{{ $summary->cashier->name ?? 'Kasir' }}</td>
                                    <td class="p-3 text-center font-bold text-stone-700">{{ $summary->total_transactions }}</td>
                                    <td class="p-3 text-right font-bold text-forest">Rp {{ number_format($summary->total_revenue, 0, ',', '.') }}</td>
                                    <td class="p-3 text-center">
                                        <span class="rounded-full bg-emerald-100 text-emerald-800 px-2 py-0.5 text-[10px] font-bold">
                                            {{ $summary->status_label }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-stone-400">Belum ada riwayat tutup buku kasir.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
