<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan {{ $order->order_code }} - Circle Concordia Coffee</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">

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
                        },
                        cream: '#F6F1E7',
                        espresso: '#2B2118',
                        amberCustom: '#D9A05B',
                        sand: '#EDE4D3',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cream text-espresso font-sans antialiased min-h-screen py-10 px-4">

    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-forest hover:text-amber-800 transition-colors">
            <span>← Kembali ke Dashboard</span>
        </a>
        <a href="{{ route('home') }}" class="text-xs text-stone-500 hover:text-forest">Beranda Utama</a>
    </div>

    <!-- Invoice Card -->
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl border border-sand overflow-hidden">
        
        <!-- Header -->
        <div class="bg-forest text-cream p-8 sm:p-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-forest-light">
            <div>
                <span class="text-amberCustom text-xs font-bold uppercase tracking-wider block mb-1">
                    Nota Pemesanan Biji Kopi C3
                </span>
                <h1 class="font-serif font-bold text-2xl sm:text-3xl text-cream">{{ $order->order_code }}</h1>
                <p class="text-xs text-cream/70 mt-1">Dipesan pada: {{ $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>

            <div>
                <span class="px-4 py-1.5 rounded-full text-xs font-bold border {{ $order->status_badge_color }}">
                    ● {{ $order->status_label }}
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="m-8 mb-0 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                <span class="font-bold">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="p-8 sm:p-10 space-y-8">
            
            <!-- Items Table -->
            <div>
                <h3 class="font-serif font-bold text-lg text-forest mb-3">Rincian Paket Biji Kopi (Per Paket 1 kg)</h3>
                
                <div class="border border-sand rounded-2xl overflow-hidden">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-cream text-forest font-serif font-bold border-b border-sand">
                            <tr>
                                <th class="p-4">Varian Biji Kopi</th>
                                <th class="p-4">Gilingan</th>
                                <th class="p-4 text-center">Jumlah Paket</th>
                                <th class="p-4 text-right">Harga / Paket</th>
                                <th class="p-4 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sand">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="p-4 font-medium text-forest">
                                        <div class="font-bold text-sm">{{ $item->product->name }}</div>
                                        <div class="text-[11px] text-amber-800">Origin: {{ $item->product->origin->name }}</div>
                                    </td>
                                    <td class="p-4 text-stone-600">{{ $item->grind_size }}</td>
                                    <td class="p-4 text-center font-bold text-forest">
                                        {{ $item->quantity_package }} Paket ({{ $item->quantity_package * 1 }} kg)
                                    </td>
                                    <td class="p-4 text-right text-stone-700">
                                        Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-right font-bold font-serif text-forest">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-stone-50 border-t border-sand">
                            <tr>
                                <td colspan="4" class="p-4 text-right font-serif font-bold text-forest text-sm">
                                    Total Tagihan:
                                </td>
                                <td class="p-4 text-right font-serif font-bold text-forest text-lg text-amber-800">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Customer & Shipping Details -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6 rounded-2xl bg-cream border border-sand text-xs">
                <div>
                    <span class="font-serif font-bold text-forest text-sm block mb-2">Informasi Penerima</span>
                    <p class="font-semibold text-espresso">{{ $order->recipient_name }}</p>
                    <p class="text-stone-600 mt-1">📞 {{ $order->shipping_phone }}</p>
                    <p class="text-stone-500 mt-0.5">Email akun: {{ $order->user->email }}</p>
                </div>

                <div>
                    <span class="font-serif font-bold text-forest text-sm block mb-2">Alamat Pengiriman</span>
                    <p class="text-stone-700 leading-relaxed">{{ $order->shipping_address }}</p>
                    @if($order->customer_notes)
                        <div class="mt-2 text-stone-500 italic">
                            Catatan: "{{ $order->customer_notes }}"
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons: WhatsApp Confirmation -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('dashboard') }}" class="text-xs text-stone-500 hover:text-forest">
                    ← Lihat Semua Riwayat Pesanan Saya
                </a>

                @php
                    $waMsg = urlencode("Halo Owner/Admin C3 Coffee, saya ingin konfirmasi pembayaran untuk pesanan: *{$order->order_code}* senilai *Rp " . number_format($order->total_amount, 0, ',', '.') . "*. Mohon instruksi rekening dan pengiriman. Terima kasih!");
                @endphp
                <a href="https://wa.me/6281234567890?text={{ $waMsg }}" target="_blank"
                   class="w-full sm:w-auto px-6 py-3.5 rounded-full bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-md transition-all hover:scale-105">
                    <span>💬</span>
                    <span>Konfirmasi Pembayaran via WhatsApp Admin</span>
                </a>
            </div>

        </div>

    </div>

</body>
</html>
