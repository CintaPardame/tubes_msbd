<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Promotion;
use App\Models\RoastingBatch;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $petani = User::where('role', 'petani')->first();
        $admin = User::where('role', 'admin')->first();
        $products = Product::all();

        if (!$petani || !$admin || $products->isEmpty()) {
            return;
        }

        // 1. Seed Supplies
        $supply1 = Supply::firstOrCreate([
            'bean_type' => 'Arabika Gayo Specialty Grade 1',
        ], [
            'user_id' => $petani->id,
            'origin_name' => 'Aceh Gayo',
            'weight_kg' => 100.00,
            'purchase_cost_per_kg' => 95000,
            'total_purchase_cost' => 9500000,
            'status' => 'disetujui',
            'approved_by' => $admin->id,
            'approved_at' => now(),
        ]);

        $supply2 = Supply::firstOrCreate([
            'bean_type' => 'Robusta Temanggung Fine',
        ], [
            'user_id' => $petani->id,
            'origin_name' => 'Temanggung',
            'weight_kg' => 50.00,
            'purchase_cost_per_kg' => 60000,
            'total_purchase_cost' => 3000000,
            'status' => 'menunggu',
        ]);

        // 2. Seed Roasting Batch
        $firstProduct = $products->first();
        RoastingBatch::firstOrCreate([
            'notes' => 'Batch perdana panen raya',
        ], [
            'supply_id' => $supply1->id,
            'product_id' => $firstProduct->id,
            'green_bean_weight_kg' => 50.00,
            'shrinkage_percentage' => 15.00,
            'roasted_weight_kg' => 42.50,
            'packages_produced' => 42,
            'roasting_cost' => 150000,
            'created_by' => $admin->id,
        ]);

        // 3. Set minimum price for products
        foreach ($products as $prod) {
            if (!$prod->min_price) {
                $prod->update(['min_price' => (float)$prod->price * 0.85]);
            }
        }

        // 4. Seed Promotion
        Promotion::firstOrCreate([
            'name' => 'Promo Diskon Panen Gayo',
        ], [
            'product_id' => $firstProduct->id,
            'discount_type' => 'percentage',
            'discount_value' => 10.00,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(30)->toDateString(),
            'is_active' => true,
        ]);
    }
}
