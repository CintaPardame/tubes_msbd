<?php

namespace App\Http\Controllers;

use App\Models\DailyCashierSummary;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KasirController extends Controller
{
    /**
     * Fitur 1: Konfirmasi Pembayaran (Sekali Klik)
     * Kasir melihat bukti pembayaran / transfer konsumen,
     * mengonfirmasi -> status menjadi 'diproses_kasir' dan invoice resmi tercetak/diterbitkan.
     */
    public function confirmPayment(Request $request, Order $order): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isKasir() && !$user->isAdmin()) {
            abort(403, 'Hanya Kasir atau Admin yang dapat memvalidasi pembayaran.');
        }

        $order->update([
            'status' => 'diproses_kasir',
            'paid_at' => now(),
            'verified_by' => $user->id,
        ]);

        return back()->with('success', "Pembayaran untuk pesanan {$order->order_code} berhasil dikonfirmasi! Status kini 'Diproses Kasir' dan invoice resmi telah diterbitkan.")
                     ->with('print_invoice_order_id', $order->id);
    }

    /**
     * Upload Bukti Pembayaran (oleh Konsumen atau Kasir yang menerima slip manual).
     */
    public function uploadPaymentProof(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'payment_proof' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $order->update([
                'payment_proof' => $path,
            ]);
        }

        return back()->with('success', "Bukti pembayaran untuk pesanan {$order->order_code} berhasil diunggah.");
    }

    /**
     * Fitur 2: Input Resi Ekspedisi & Serah Terima Pengiriman
     * Kasir menginput nomor resi (JNE/J&T/Kurir Roastery) dan mengubah status menjadi Sedang Dikirim.
     */
    public function updateShipping(Request $request, Order $order): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isKasir() && !$user->isAdmin()) {
            abort(403, 'Hanya Kasir atau Admin yang dapat memperbarui pengiriman.');
        }

        $validated = $request->validate([
            'courier_name' => ['required', 'string', 'max:100'],
            'tracking_number' => ['required', 'string', 'max:150'],
        ]);

        $order->update([
            'courier_name' => $validated['courier_name'],
            'tracking_number' => $validated['tracking_number'],
            'status' => 'dikirim',
            'shipped_at' => now(),
        ]);

        return back()->with('success', "Resi {$validated['courier_name']} ({$validated['tracking_number']}) berhasil diinput. Pesanan {$order->order_code} kini berstatus 'Sedang Dikirim'.");
    }

    /**
     * Fitur 3: Rekap Tutup Buku Kasir Harian (Daily Cashier Summary)
     * Rekap total transaksi yang diproses shift hari itu untuk diserahkan ke Admin.
     */
    public function closeShift(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isKasir() && !$user->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $today = Carbon::today();

        // Hitung total transaksi yang diproses oleh kasir hari ini (yang statusnya diproses_kasir, dikirim, atau selesai)
        $processedOrders = Order::whereDate('paid_at', $today)
            ->whereIn('status', ['diproses_kasir', 'dikirim', 'selesai'])
            ->get();

        $totalTransactions = $processedOrders->count();
        $totalRevenue = (float) $processedOrders->sum('total_amount');

        $notes = $request->input('notes', 'Tutup buku shift harian kasir per tanggal ' . $today->translatedFormat('d F Y'));

        $summary = DailyCashierSummary::updateOrCreate(
            [
                'cashier_id' => $user->id,
                'closing_date' => $today->toDateString(),
            ],
            [
                'total_transactions' => $totalTransactions,
                'total_revenue' => $totalRevenue,
                'notes' => $notes,
                'status' => 'submitted_to_admin',
            ]
        );

        return back()->with('success', "Tutup buku shift harian berhasil disimpan & diserahkan ke Admin! Total: {$totalTransactions} transaksi (Rp " . number_format($totalRevenue, 0, ',', '.') . ").");
    }

    /**
     * Cetak Invoice Resmi (Struk / Faktur Pembelian)
     */
    public function printInvoice(Order $order): View
    {
        $order->load(['user', 'items.product.origin', 'verifier']);
        return view('order.invoice', compact('order'));
    }
}
