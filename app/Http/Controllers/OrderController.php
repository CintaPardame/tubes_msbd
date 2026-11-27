<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Show order form for a selected product.
     * Requires user authentication as consumer (User Level 3) or Admin.
     */
    public function create(Request $request): View|RedirectResponse
    {
        // 1. Cek apakah sudah login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan masuk (login) sebagai akun Konsumen terlebih dahulu untuk melakukan pemesanan biji kopi.');
        }

        $productId = $request->query('product_id');
        $selectedProduct = $productId ? Product::with('origin')->find($productId) : null;
        $products = Product::with('origin')->where('stock', '>', 0)->get();
        $products = Product::with('origin')->get();
        $selectedProduct = null;

        /** @var User $user */
        $user = Auth::user();

        return view('order.create', compact('selectedProduct', 'products', 'user'));
    }

    /**
     * Store new order in database.
     */
    public function store(Request $request): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk memesan.');
        }

        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity_package' => ['required', 'integer', 'min:1'], // Minimum pemesanan 1 paket (1 kg)
            'grind_size' => ['required', 'string', 'in:Biji Utuh,Giling Kasar (Cold Brew/French Press),Giling Sedang (V60/Filter),Giling Halus (Espresso/Tubruk)'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'shipping_phone' => ['required', 'string', 'max:25', 'regex:/^[0-9+\s\-]+$/'],
            'shipping_address' => ['required', 'string'],
            'customer_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity_package']) {
            return back()->with('error', "Maaf, stok varian {$product->name} tidak mencukupi (tersedia {$product->stock} paket 1kg).")->withInput();
        }

        $unitPrice = $product->price;
        $subtotal = $unitPrice * $validated['quantity_package'];

        DB::beginTransaction();
        try {
            // Generate order code
            $orderCode = 'C3-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            $order = Order::create([
                'order_code' => $orderCode,
                'user_id' => $user->id,
                'total_amount' => $subtotal,
                'status' => 'menunggu_pembayaran',
                'recipient_name' => $validated['recipient_name'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'customer_notes' => $validated['customer_notes'],
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity_package' => $validated['quantity_package'],
                'weight_per_package_kg' => 1.00, // 1 Paket = 1 kg
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'grind_size' => $validated['grind_size'],
            ]);

            // Kurangi stok produk
            $product->decrement('stock', $validated['quantity_package']);

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', "Pesanan {$order->order_code} berhasil dibuat! Silakan lakukan konfirmasi pembayaran.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show order detail & invoice.
     */
    public function show(Order $order): View
    {
        /** @var User $user */
        $user = Auth::user();

        // Validasi akses: hanya pemilik pesanan, admin, atau kasir yang bisa melihat
        if (!$user->isAdmin() && !$user->isKasir() && $order->user_id !== $user->id) {
            abort(403, 'Anda tidak berhak melihat pesanan ini.');
        }

        $order->load(['user', 'items.product.origin']);

        return view('order.show', compact('order'));
    }
}
