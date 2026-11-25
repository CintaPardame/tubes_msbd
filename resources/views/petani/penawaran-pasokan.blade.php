<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penawaran Pasokan - Circle Concordia</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-stone-100 min-h-screen">

    <div class="max-w-6xl mx-auto px-6 py-8">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-stone-800">
                    Penawaran Pasokan
                </h1>
                <p class="text-stone-600 mt-2">
                    Ajukan pasokan kopi baru untuk disetujui Admin.
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="bg-stone-700 text-white px-4 py-2 rounded-xl">
                Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded-xl mb-6">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow p-6 mb-8">

            <h2 class="text-xl font-bold mb-5">
                Form Penawaran Pasokan
            </h2>

            <form action="{{ route('petani.penawaran-pasokan.store') }}"
                  method="POST">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block font-medium mb-2">
                            Asal Perkebunan
                        </label>

                        <select name="origin_id"
                                class="w-full border rounded-xl p-3"
                                required>

                            <option value="">Pilih asal perkebunan</option>

                            @foreach($origins as $origin)
                                <option value="{{ $origin->id }}"
                                    @selected(old('origin_id') == $origin->id)>
                                    {{ $origin->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div>
                        <label class="block font-medium mb-2">
                            Varietas Kopi
                        </label>

                        <input type="text"
                               name="variety"
                               value="{{ old('variety') }}"
                               placeholder="Contoh: Arabika"
                               class="w-full border rounded-xl p-3"
                               required>
                    </div>

                    <div>
                        <label class="block font-medium mb-2">
                            Metode Pengolahan
                        </label>

                        <select name="process_method"
                                class="w-full border rounded-xl p-3"
                                required>

                            <option value="">Pilih metode pengolahan</option>

                            <option value="Washed"
                                @selected(old('process_method') == 'Washed')>
                                Washed
                            </option>

                            <option value="Honey"
                                @selected(old('process_method') == 'Honey')>
                                Honey
                            </option>

                            <option value="Natural"
                                @selected(old('process_method') == 'Natural')>
                                Natural
                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="block font-medium mb-2">
                            Tanggal Panen
                        </label>

                        <input type="date"
                               name="harvest_date"
                               value="{{ old('harvest_date') }}"
                               max="{{ date('Y-m-d') }}"
                               class="w-full border rounded-xl p-3"
                               required>
                    </div>

                    <div>
                        <label class="block font-medium mb-2">
                            Jumlah Pasokan (kg)
                        </label>

                        <input type="number"
                               name="quantity_kg"
                               value="{{ old('quantity_kg') }}"
                               min="0.01"
                               max="99999999.99"
                               step="0.01"
                               placeholder="Contoh: 100"
                               class="w-full border rounded-xl p-3"
                               required>
                    </div>

                </div>

                <button type="submit"
                        class="mt-6 bg-stone-800 text-white px-6 py-3 rounded-xl hover:bg-stone-700">
                    Ajukan Penawaran
                </button>

            </form>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <h2 class="text-xl font-bold mb-5">
                Riwayat Penawaran Pasokan
            </h2>

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-stone-200">
                        <tr>
                            <th class="p-3">No</th>
                            <th class="p-3">Asal</th>
                            <th class="p-3">Varietas</th>
                            <th class="p-3">Metode</th>
                            <th class="p-3">Tanggal Panen</th>
                            <th class="p-3">Jumlah (kg)</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($supplyOffers as $offer)

                            <tr class="border-b">

                                <td class="p-3">{{ $loop->iteration }}</td>

                                <td class="p-3">
                                    {{ $offer->origin?->name ?? '-' }}
                                </td>

                                <td class="p-3">{{ $offer->variety }}</td>

                                <td class="p-3">{{ $offer->process_method }}</td>

                                <td class="p-3">{{ $offer->harvest_date }}</td>

                                <td class="p-3">{{ $offer->quantity_kg }}</td>

                                <td class="p-3">

                                    @if($offer->status == 'menunggu')

                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">
                                            Menunggu
                                        </span>

                                    @elseif($offer->status == 'disetujui')

                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                            Disetujui
                                        </span>

                                    @elseif($offer->status == 'ditolak')

                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full">
                                            Ditolak
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="p-5 text-center text-gray-500">
                                    Belum ada penawaran pasokan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>
</html>