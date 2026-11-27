<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pemesanan Biji Kopi - Circle Concordia Coffee (C3)</title>

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

    <!-- Top Navigation Container -->
    <div class="max-w-4xl mx-auto mb-8 flex items-center justify-between">

        <div class="flex items-center gap-3 text-xs ml-auto">
            <span class="text-stone-500">Masuk sebagai:</span>
            <span class="font-bold text-forest bg-white px-3 py-1 rounded-full border border-sand shadow-sm">
                👤 {{ $user->name }} ({{ $user->role_label }})
            </span>
        </div>
    </div>

    <!-- Main Order Form Card -->
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl border border-sand overflow-hidden">
        
        <!-- Header Banner -->
        <div class="bg-forest text-cream p-8 sm:p-10 border-b border-forest-light">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amberCustom/20 text-amberCustom text-xs font-bold uppercase tracking-wider mb-3">
                <span>📦</span> Aturan Pemesanan C3: Minimal 1 Paket (1 kg)
            </div>
            <h1 class="font-serif font-bold text-3xl sm:text-4xl text-cream">Form Pemesanan Biji Kopi</h1>
            <p class="text-xs sm:text-sm text-cream/75 mt-2 max-w-2xl leading-relaxed">
                Pemesanan biji kopi di C3 dihitung dalam satuan <strong>paket utuh (1 paket = 1 kg / 1.000 gram)</strong> untuk menjaga kesegaran proses sangrai batch mingguan.
            </p>
        </div>

        <!-- Navigasi: Kembali dan Dashboard -->
        <div class="px-8 sm:px-10 pt-5 pb-4 flex items-center justify-between border-b border-sand">

            <a href="{{ route('home') }}"
               class="text-xs font-semibold text-forest hover:text-amber-800">
                ← Kembali ke Beranda
            </a>

            <a href="{{ route('dashboard') }}"
               class="text-xs font-semibold text-amber-800 hover:underline">
                Dashboard →
            </a>

        </div>


        @if(session('error'))
            <div class="m-8 mb-0 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
                <span class="font-bold">⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST" class="p-8 sm:p-10 space-y-8">
            @csrf

            <!-- Section 1: Pilihan Varian Kopi -->
            <div>
                <label for="product_id" class="block font-serif font-bold text-lg text-forest mb-2">
                    1. Pilih Varian Biji Kopi (Kemasan 1 kg)
                </label>
                <select name="product_id" id="product_id" onchange="updateSummary()" required
                        class="w-full text-xs sm:text-sm px-4 py-3.5 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-forest text-espresso">
                        <option value="" selected hidden> -- Pilih Biji Kopi --</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" 
                                data-price="{{ $p->price }}" 
                                data-name="{{ $p->name }}"
                                data-origin="{{ $p->origin->name }}"
                                data-roast="{{ $p->roast_level }}"
                                data-stock="{{ $p->stock }}"
                                {{ ($selectedProduct && $selectedProduct->id === $p->id) ? 'selected' : '' }}>
                            {{ $p->name }} — Rp {{ number_format($p->price, 0, ',', '.') }} / Paket (1 kg) [Stok: {{ $p->stock }} kg]
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Section 2: Jumlah Paket & Profil Gilingan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Jumlah Paket (1 paket = 1kg) -->
                <div class="p-5 rounded-2xl bg-cream border border-sand">
                    <label for="quantity_package" class="block font-serif font-bold text-forest text-sm mb-1">
                        2. Jumlah Paket (Min. 1 Paket = 1 kg)
                    </label>
                    <p class="text-[11px] text-stone-500 mb-3">Tiap 1 paket setara dengan berat bersih 1.000 gram.</p>
                    
                    <div class="flex items-center gap-3">
                        <input type="number" id="quantity_package" name="quantity_package" value="1" min="1" max="100" required onchange="updateSummary()" oninput="updateSummary()"
                               class="w-28 text-center font-bold text-base px-3 py-2.5 rounded-xl border border-sand bg-white focus:ring-2 focus:ring-forest text-forest">
                        <span class="text-xs font-semibold text-espresso">Paket ( <span id="weight_total">1</span> kg )</span>
                    </div>
                </div>

                <!-- Opsi Gilingan / Grind Size -->
                <div class="p-5 rounded-2xl bg-cream border border-sand">
                    <label for="grind_size" class="block font-serif font-bold text-forest text-sm mb-1">
                        3. Bentuk Biji / Tingkat Gilingan
                    </label>
                    <p class="text-[11px] text-stone-500 mb-3">Sesuaikan dengan alat seduh yang Anda gunakan.</p>

                    <select name="grind_size" id="grind_size"  onchange="updateSummary()" required
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-sand bg-white focus:ring-2 focus:ring-forest text-espresso">
                        <option value="" selected hidden> -- Pilih Bentuk Biji Kopi --</option>
                        <option value="Biji Utuh">Biji Utuh (Whole Bean - Sangat Disarankan)</option>
                        <option value="Giling Kasar (Cold Brew/French Press)">Giling Kasar (Cold Brew / French Press)</option>
                        <option value="Giling Sedang (V60/Filter)">Giling Sedang (V60 / Pour Over / Aeropress)</option>
                        <option value="Giling Halus (Espresso/Tubruk)">Giling Halus (Espresso Machine / Kopi Tubruk)</option>
                    </select>
                </div>
            </div>

            <!-- Section 3: Data Penerima & Pengiriman -->
            <div class="space-y-4 pt-4 border-t border-sand">
                <h3 class="font-serif font-bold text-lg text-forest">4. Informasi Pengiriman</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="recipient_name" class="block text-xs font-semibold text-forest mb-1">Nama Penerima</label>
                        <input type="text" id="recipient_name" name="recipient_name" value="{{ old('recipient_name', $user->name) }}" required
                               class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:ring-2 focus:ring-forest">
                    </div>

                    <div>
                        <label for="shipping_phone" class="block text-xs font-semibold text-forest mb-1">Nomor WhatsApp Penerima</label>
                        <input type="text" id="shipping_phone" name="shipping_phone" value="{{ old('shipping_phone', $user->phone) }}" required
                               class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:ring-2 focus:ring-forest">
                    </div>
                </div>

                <div>
                    <label for="shipping_address" class="block text-xs font-semibold text-forest mb-1">Alamat Lengkap Pengiriman</label>
                    <textarea id="shipping_address" name="shipping_address" rows="3" required
                              class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:ring-2 focus:ring-forest"
                              placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota/kabupaten, kode pos">{{ old('shipping_address', $user->address) }}</textarea>
                </div>

                <div>
                    <label for="customer_notes" class="block text-xs font-semibold text-forest mb-1">Catatan Tambahan (Opsional)</label>
                    <input type="text" id="customer_notes" name="customer_notes" value="{{ old('customer_notes') }}"
                           class="w-full text-xs px-4 py-3 rounded-xl border border-sand bg-stone-50 focus:bg-white focus:ring-2 focus:ring-forest"
                           placeholder="Contoh: Packing ekstra aman, mohon dikirim sebelum jam 3 sore">
                </div>
            </div>

            <!-- Section 4: Ringkasan Total Biaya -->
            <div class="p-6 rounded-2xl bg-forest text-cream flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <span class="text-xs text-amberCustom font-bold uppercase tracking-wider block">Ringkasan Pesanan (Minimum 1kg)</span>
                    <p class="font-serif text-xl font-bold mt-0.5" id="summary_title">-</p>
                    <p class="text-xs text-cream/70 mt-1" id="summary_calc">-</p>
                </div>

                <div class="text-right flex flex-col items-end">
                    <span class="text-[11px] text-cream/70 block">Total Pembayaran:</span>
                    <span class="font-serif font-bold text-2xl sm:text-3xl text-amberCustom" id="total_price_text">
                        Rp 0
                    </span>
                    <button type="submit" class="mt-3 px-8 py-3 rounded-full bg-amberCustom hover:bg-amber-400 text-forest font-bold text-xs uppercase tracking-wider shadow-lg transition-all hover:scale-105">
                        Konfirmasi & Pesan Sekarang →
                    </button>
                </div>
            </div>

        </form>

    </div>

    <!-- Script Kalkulator Realtime -->
    <script>
        function formatRupiah(angka) {
    return 'Rp ' + Number(angka).toLocaleString('id-ID');
}

        function updateSummary() {
            const select = document.getElementById('product_id');
            const selectedOption = select.options[select.selectedIndex];

            const productSelect = document.getElementById('product_id');
            const grindSelect = document.getElementById('grind_size');

            const selectedProduct = productSelect.value;
            const selectedGrind = grindSelect.value;

            if (selectedProduct === "" && selectedGrind === "") {
                document.getElementById('summary_title').textContent =
                    "Pilihlah Biji Kopi dan Bentuk Biji";

                document.getElementById('summary_calc').textContent = "";

                document.getElementById('total_price_text').textContent = "Rp 0";

            
                return;
            }

            if (selectedProduct === "") {
                document.getElementById('summary_title').textContent =
                    "Pilihlah Biji Kopi";
                

                document.getElementById('total_price_text').innerText = 'Rp 0';
            
                return;
            }

            if (selectedGrind === "") {
                document.getElementById('summary_title').textContent =
                    "Pilihlah Bentuk Biji Kopi";
            
                document.getElementById('total_price_text').textContent = "Rp 0";
            
                return;
            }
            
            const price = parseFloat(selectedOption.getAttribute('data-price') || 0);
            const name = selectedOption.getAttribute('data-name') || '';
            const qty = parseInt(document.getElementById('quantity_package').value) || 1;
            
            document.getElementById('weight_total').innerText = qty;
            
            const total = price * qty;
            
            document.getElementById('summary_title').innerText = `${name} (${qty} Paket @ 1 kg)`;
            document.getElementById('summary_calc').innerText = `Rp ${price.toLocaleString('id-ID')} × ${qty} kg`;
            document.getElementById('total_price_text').innerText = `Rp ${total.toLocaleString('id-ID')}`;
        }

        // Jalankan saat pertama dimuat
        document.addEventListener('DOMContentLoaded', updateSummary);
    </script>
</body>
</html>
