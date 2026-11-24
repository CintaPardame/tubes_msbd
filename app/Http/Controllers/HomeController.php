<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Origin;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index(): View
    {
        $profile = CompanyProfile::first() ?? new CompanyProfile([
            'name' => 'Circle Concordia Coffee',
            'short_name' => 'C3',
            'tagline' => 'Harmony in Every Bean, Circle in Every Cup',
            'about' => 'Menyajikan biji kopi nusantara pilihan berkualitas specialty langsung dari petani lokal.',
            'vision' => 'Menjadi lingkaran penghubung harmoni antara petani kopi nusantara dan penikmat kopi dunia.',
            'mission' => [
                'Menjalin kemitraan direct trade yang etis.',
                'Proses roasting presisi menjaga karakter origin.',
                'Membangun komunitas pecinta kopi spesialti.',
            ],
            'phone' => '+62 812-3456-7890',
            'email' => 'hello@circleconcordiacoffee.com',
            'address' => 'Jl. Harmoni Kopi No. 3, Bandung, Jawa Barat',
            'instagram' => '@circleconcordia.coffee',
        ]);

        $origins = Origin::withCount('products')->orderBy('name')->get();
        $popularProducts = Product::with(['origin', 'category'])
            ->where('is_popular', true)
            ->get();
        $allProducts = Product::with(['origin', 'category'])
            ->orderBy('name')
            ->get();
        $categories = Category::withCount('products')->get();

        return view('welcome', compact(
            'profile',
            'origins',
            'popularProducts',
            'allProducts',
            'categories'
        ));
    }
}
