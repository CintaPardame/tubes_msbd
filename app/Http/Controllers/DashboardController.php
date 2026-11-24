<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Origin;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Route user to their corresponding role dashboard.
     */
    public function index(): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        return match ($user->role) {
            'admin' => $this->adminDashboard(),
            'kasir' => $this->kasirDashboard(),
            'petani' => $this->petaniDashboard(),
            default => $this->userDashboard(),
        };
    }

    /**
     * Admin Dashboard (Level 1).
     */
    private function adminDashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', '!=', 'dibatalkan')->sum('total_amount'),
            'total_products' => Product::count(),
            'total_origins' => Origin::count(),
        ];

        $users = User::orderBy('level')->orderBy('role')->get();
        $recentOrders = Order::with(['user', 'items.product'])->latest()->take(8)->get();
        $products = Product::with('origin')->get();

        return view('dashboard.admin', compact('stats', 'users', 'recentOrders', 'products'));
    }

    /**
     * Kasir Dashboard (Level 2).
     */
    private function kasirDashboard(): View
    {
        $orders = Order::with(['user', 'items.product'])->latest()->get();

        $stats = [
            'pending' => Order::where('status', 'menunggu_pembayaran')->count(),
            'processing' => Order::where('status', 'diproses_kasir')->count(),
            'shipping' => Order::where('status', 'dikirim')->count(),
            'completed' => Order::where('status', 'selesai')->count(),
        ];

        return view('dashboard.kasir', compact('orders', 'stats'));
    }

    /**
     * Update order status by Kasir or Admin.
     */
    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->isAdmin() && !$user->isKasir()) {
            abort(403, 'Akses ditolak. Hanya Kasir atau Admin yang dapat memperbarui status pesanan.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:menunggu_pembayaran,diproses_kasir,dikirim,selesai,dibatalkan'],
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', "Status pesanan {$order->order_code} berhasil diperbarui menjadi {$order->status_label}.");
    }

    /**
     * Petani / Produsen Dashboard (Level 2).
     */
    private function petaniDashboard(): View
    {
        $origins = Origin::withCount('products')->get();
        $products = Product::with(['origin', 'category'])->get();
        
        $totalStockKg = Product::sum('stock'); // Karena per paket adalah 1kg
        $totalSalesPackages = Order::where('status', '!=', 'dibatalkan')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->sum('order_items.quantity_package');

        return view('dashboard.petani', compact('origins', 'products', 'totalStockKg', 'totalSalesPackages'));
    }

    /**
     * User / Konsumen Dashboard (Level 3).
     */
    private function userDashboard(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $myOrders = Order::with(['items.product.origin'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $popularProducts = Product::where('is_popular', true)->take(4)->get();

        return view('dashboard.user', compact('myOrders', 'popularProducts'));
    }
}
