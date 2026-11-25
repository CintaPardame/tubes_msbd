@extends('dashboard.layout')

@section('title', 'Pasokan Panen')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="bg-forest text-cream p-6 sm:p-8 rounded-3xl shadow-md">
        <h1 class="font-serif font-bold text-3xl">
            Pasokan Panen
        </h1>

        <p class="text-sm text-cream/70 mt-2">
            Kelola data hasil panen biji kopi dari perkebunan.
        </p>

        <a href="{{ route('dashboard') }}"
           class="inline-block mt-4 bg-cream text-forest px-4 py-2 rounded-xl text-sm font-semibold">
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Form Input -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm">

        <h2 class="font-serif font-bold text-xl text-forest mb-6">
            Tambah Pasokan Panen
        </h2>

        @if ($errors->any())
            <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('petani.pasokan-panen.store') }}"
              method="POST">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Asal Perkebunan
                    </label>

                    <select name="origin_id"
                            class="w-full border border-sand rounded-xl p-3"
                            required>

                        <option value="">Pilih asal perkebunan</option>

                        @foreach ($origins as $origin)
                            <option value="{{ $origin->id }}"
                                @selected(old('origin_id') == $origin->id)>
                                {{ $origin->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Varietas Kopi
                    </label>

                    <input type="text"
                           name="variety"
                           value="{{ old('variety') }}"
                           placeholder="Contoh: Arabika"
                           class="w-full border border-sand rounded-xl p-3"
                           required>
                </div>

                 <div>
                    <label class="block text-sm font-semibold mb-2">
                        Metode Pengolahan
                    </label>

                    <select name="process_method"
                            class="w-full border border-sand rounded-xl p-3"
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
                    <label class="block text-sm font-semibold mb-2">
                        Tanggal Panen
                    </label>

                    <input type="date"
                           name="harvest_date"
                           value="{{ old('harvest_date') }}"
                           max="{{ date('Y-m-d') }}"
                           class="w-full border border-sand rounded-xl p-3"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Jumlah Panen (kg)
                    </label>

                    <input type="number"
                           name="quantity_kg"
                           value="{{ old('quantity_kg') }}"
                           min="0.01"
                           step="0.01"
                           placeholder="Contoh: 100"
                           class="w-full border border-sand rounded-xl p-3"
                           required>
                </div>

            </div>

            <button type="submit"
                    class="mt-6 bg-forest hover:bg-forest-light text-cream px-6 py-3 rounded-xl font-semibold">
                Simpan Pasokan
            </button>

        </form>
    </div>

    <!-- Daftar Pasokan -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sand shadow-sm">

        <h2 class="font-serif font-bold text-xl text-forest mb-6">
            Daftar Pasokan Panen
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-cream text-forest border-b border-sand">
                    <tr>
                        <th class="p-3">No</th>
                        <th class="p-3">Asal Perkebunan</th>
                        <th class="p-3">Varietas</th>
                        <th class="p-3">Metode Olah</th>
                        <th class="p-3">Tanggal Panen</th>
                        <th class="p-3">Jumlah (kg)</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-sand">

                    @forelse ($supplyBatches as $batch)

                        <tr class="hover:bg-stone-50">

                            <td class="p-3">{{ $loop->iteration }}</td>

                            <td class="p-3">
                                {{ $batch->origin->name }}
                            </td>

                            <td class="p-3">{{ $batch->variety }}</td>

                            <td class="p-3">
                                {{ $batch->process_method }}
                            </td>

                            <td class="p-3">
                                {{ $batch->harvest_date }}
                            </td>

                            <td class="p-3">
                                {{ number_format($batch->quantity_kg, 2, ',', '.') }}
                            </td>

                            <td class="p-3">
                                <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ ucfirst($batch->status) }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7"
                                class="p-6 text-center text-stone-500">
                                Belum ada data pasokan panen.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
