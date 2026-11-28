<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promotion;
use App\Models\RoastingBatch;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ── Supply Management ──────────────────────────────────────

    public function approveSupply(Supply $supply): RedirectResponse
    {
        $supply->update([
            'status' => 'disetujui',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', "Pasokan {$supply->bean_type} ({$supply->weight_kg} kg) berhasil disetujui.");
    }

    public function rejectSupply(Request $request, Supply $supply): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $supply->update([
            'status' => 'ditolak',
            'admin_notes' => $validated['admin_notes'] ?? null,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', "Pasokan {$supply->bean_type} ditolak.");
    }

    // ── Roasting Batch ─────────────────────────────────────────

    public function storeRoastingBatch(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'supply_id' => ['nullable', 'exists:supplies,id'],
            'product_id' => ['required', 'exists:products,id'],
            'green_bean_weight_kg' => ['required', 'numeric', 'min:0.1'],
            'shrinkage_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'roasting_cost' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $greenBean = (float) $validated['green_bean_weight_kg'];
        $shrinkage = (float) $validated['shrinkage_percentage'];
        $roastedWeight = round($greenBean * (1 - $shrinkage / 100), 2);
        $packagesProduced = (int) floor($roastedWeight); // 1 paket = 1 kg

        DB::transaction(function () use ($validated, $greenBean, $shrinkage, $roastedWeight, $packagesProduced) {
            RoastingBatch::create([
                'supply_id' => $validated['supply_id'] ?: null,
                'product_id' => $validated['product_id'],
                'green_bean_weight_kg' => $greenBean,
                'shrinkage_percentage' => $shrinkage,
                'roasted_weight_kg' => $roastedWeight,
                'packages_produced' => $packagesProduced,
                'roasting_cost' => $validated['roasting_cost'] ?? 0,
                'notes' => $validated['notes'] ?? null,
                'created_by' => Auth::id(),
            ]);

            // Auto-increment product stock
            Product::where('id', $validated['product_id'])
                ->increment('stock', $packagesProduced);
        });

        return back()->with('success', "Batch roasting berhasil disimpan. {$packagesProduced} paket ditambahkan ke stok.");
    }

    // ── Harga Minimum ──────────────────────────────────────────

    public function updateMinPrice(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'min_price' => ['required', 'numeric', 'min:0'],
        ]);

        $product->update(['min_price' => $validated['min_price']]);

        return back()->with('success', "Harga minimum {$product->name} diperbarui menjadi Rp " . number_format($validated['min_price'], 0, ',', '.'));
    }

    // ── User Management ────────────────────────────────────────

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah akun sendiri.');
        }

        $validated = $request->validate([
            'role' => ['required', 'in:kasir,petani,user'],
        ]);

        // Auto-set level based on role
        $levelMap = ['admin' => 1, 'kasir' => 2, 'petani' => 2, 'user' => 3];
        $validated['level'] = $levelMap[$validated['role']];

        $user->update($validated);

        return back()->with('success', "Role {$user->name} diperbarui menjadi {$user->role_label}.");
    }

    public function deleteUser(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "Akun {$name} berhasil dihapus.");
    }

    // ── Promotion Management ───────────────────────────────────

    public function storePromotion(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'string', 'max:255'],
            'discount_type' => ['required', 'in:percentage,fixed'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        Promotion::create($validated);

        return back()->with('success', "Promo \"{$validated['name']}\" berhasil ditambahkan.");
    }

    public function togglePromotion(Promotion $promotion): RedirectResponse
    {
        $promotion->update(['is_active' => !$promotion->is_active]);
        $status = $promotion->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Promo \"{$promotion->name}\" {$status}.");
    }

    public function deletePromotion(Promotion $promotion): RedirectResponse
    {
        $name = $promotion->name;
        $promotion->delete();

        return back()->with('success', "Promo \"{$name}\" berhasil dihapus.");
    }
}
