<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Resmi #{{ $order->order_code }} - Circle Concordia Coffee</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Fraunces:wght@600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .invoice-box { border: none !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-stone-100 text-stone-800 font-sans p-4 sm:p-8 antialiased min-h-screen">

    <div class="max-w-3xl mx-auto mb-4 flex items-center justify-between no-print">
        <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-emerald-800 hover:underline">
            ← Kembali ke Dashboard Kasir
        </a>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-emerald-800 text-white rounded-xl text-xs font-bold hover:bg-emerald-900 transition flex items-center gap-1.5 shadow-sm">
                <span>🖨️ Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <div class="max-w-3xl mx-auto bg-white rounded-2xl border border-stone-200 shadow-sm p-6 sm:p-10 invoice-box">
        
        <!-- Header Invoice -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-stone-200">
            <div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-emerald-900 text-amber-400 font-serif font-bold text-base flex items-center justify-center">C3</div>
                    <span class="font-serif font-bold text-xl text-emerald-950">Circle Concordia Coffee</span>
                </div>
                <p class="text-xs text-stone-500 mt-1">Specialty Coffee Roastery & Official Bean Store</p>
            </div>
            <div class="sm:text-right">
                <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">
                    FAKTUR RESMI LUNAS
                </span>
                <p class="font-mono text-sm font-bold text-stone-800 mt-1.5">{{ $order->order_code }}</p>
                <p class="text-xs text-stone-400">Tanggal: {{ $order->paid_at ? $order->paid_at->format('d/m/Y H:i') : $order->created_at->format('d/m/Y H:i') }} WIB</p>
            </div>
        </div>

        <!-- Info Penerima & Kasir Validasi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-6 border-b border-stone-100 text-xs">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-stone-400 mb-1">Ditujukan Kepada (Pembeli):</p>
                <p class="text-sm font-bold text-stone-800">{{ $order->recipient_name }}</p>
                <p class="text-stone-600 mt-0.5">📞 {{ $order->shipping_phone }}</p>
                <p class="text-stone-500 mt-0.5 leading-relaxed">{{ $order->shipping_address }}</p>
            </div>
            <div class="sm:text-right">
                <p class="text-[10px] font-bold uppercase tracking-wider text-stone-400 mb-1">Divalidasi Oleh:</p>
                <p class="text-sm font-bold text-emerald-900">{{ $order->verifier->name ?? 'Kasir Operasional C3' }}</p>
                <p class="text-stone-600 mt-0.5">Status: <span class="font-semibold text-emerald-700">{{ $order->status_label }}</span></p>
                @if($order->tracking_number)
                    <p class="text-stone-700 mt-1 font-mono font-bold">Ekspedisi: {{ $order->courier_name }} ({{ $order->tracking_number }})</p>
                @endif
            </div>
        </div>

        <!-- Tabel Item -->
        <div class="py-6">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-stone-200 text-stone-500 uppercase text-[10px] tracking-wider">
                        <th class="pb-3 font-semibold">Produk Kemasan (1 kg)</th>
                        <th class="pb-3 font-semibold">Ukuran Gilingan</th>
                        <th class="pb-3 text-center font-semibold">Kuantitas</th>
                        <th class="pb-3 text-right font-semibold">Harga Satuan</th>
                        <th class="pb-3 text-right font-semibold">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-3.5 pr-2">
                                <p class="font-bold text-stone-800">{{ $item->product->name }}</p>
                                <p class="text-[10px] text-stone-400">Asal: {{ $item->product->origin->name ?? 'Nusantara' }}</p>
                            </td>
                            <td class="py-3.5 text-stone-600">{{ $item->grind_size }}</td>
                            <td class="py-3.5 text-center font-bold text-stone-800">{{ $item->quantity_package }} Paket ({{ $item->quantity_package }} kg)</td>
                            <td class="py-3.5 text-right text-stone-600">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="py-3.5 text-right font-bold text-emerald-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-stone-200">
                        <td colspan="4" class="pt-4 text-right font-bold text-sm text-stone-700">Total Pembayaran:</td>
                        <td class="pt-4 text-right font-bold text-base text-emerald-900 font-mono">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer / Tanda Terima -->
        <div class="pt-6 border-t border-dashed border-stone-200 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-stone-500">
            <div>
                <p class="font-semibold text-stone-700">Terima kasih telah berbelanja di Circle Concordia Coffee!</p>
                <p class="text-[11px] text-stone-400 mt-0.5">Faktur ini sah sebagai bukti verifikasi pembayaran dan serah terima kurir.</p>
            </div>
            <div class="text-center sm:text-right">
                <div class="h-12 flex items-center justify-center sm:justify-end">
                    <span class="border-b border-stone-400 font-serif italic text-emerald-900 px-4">C3 Roastery Cashier</span>
                </div>
                <p class="text-[10px] text-stone-400">Sistem Kasir Terintegrasi C3</p>
            </div>
        </div>

    </div>

</body>
</html>
