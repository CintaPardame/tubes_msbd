<?php

namespace App\Http\Controllers;

use App\Models\Origin;
use App\Models\SupplyOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplyOfferController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()?->role === 'petani', 403);

        $origins = Origin::orderBy('name')->get();

        $supplyOffers = SupplyOffer::with('origin')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('petani.penawaran-pasokan', compact(
            'origins',
            'supplyOffers'
        ));
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()?->role === 'petani', 403);

        $validated = $request->validate([
            'origin_id' => 'required|exists:origins,id',
            'variety' => 'required|string|max:255',
            'process_method' => 'required|in:Washed,Honey,Natural',
            'harvest_date' => 'required|date|before_or_equal:today',
            'quantity_kg' => 'required|numeric|min:0.01|max:99999999.99',
        ]);

        SupplyOffer::create([
            'user_id' => Auth::id(),
            'origin_id' => $validated['origin_id'],
            'variety' => trim($validated['variety']),
            'process_method' => $validated['process_method'],
            'harvest_date' => $validated['harvest_date'],
            'quantity_kg' => $validated['quantity_kg'],
            'status' => 'menunggu',
        ]);

        return redirect()
            ->route('petani.penawaran-pasokan')
            ->with('success', 'Penawaran pasokan berhasil diajukan.');
    }
}