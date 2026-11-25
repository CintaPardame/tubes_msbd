<?php

namespace App\Http\Controllers;

use App\Models\Origin;
use App\Models\SupplyBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplyBatchController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()?->role === 'petani', 403);

        $origins = Origin::orderBy('name')->get();

        $supplyBatches = SupplyBatch::with('origin')
            ->where('user_id', Auth::id())
            ->where('status', 'tersedia')
            ->latest()
            ->get();

        return view('petani.pasokan-panen', compact(
            'origins',
            'supplyBatches'
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

        SupplyBatch::create([
            'user_id' => Auth::id(),
            'origin_id' => $validated['origin_id'],
            'variety' => $validated['variety'],
            'process_method' => $validated['process_method'],
            'harvest_date' => $validated['harvest_date'],
            'quantity_kg' => $validated['quantity_kg'],
            'status' => 'tersedia',
        ]);

  return redirect()
    ->route('petani.pasokan-panen')
    ->with('success', 'Pasokan panen berhasil dicatat.');
    }
}