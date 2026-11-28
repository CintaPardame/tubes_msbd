<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class AuthAndOrderTest extends TestCase
{
    public function test_guest_is_redirected_to_login_when_accessing_order_create(): void
    {
        $response = $this->get(route('orders.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_login_and_access_dashboard(): void
    {
        $user = User::where('role', 'user')->first();
        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Konsumen');
    }

    public function test_admin_can_login_and_access_admin_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Admin / Owner Dashboard');
        $response->assertSee('Administrator · Level 1');
    }

    public function test_kasir_can_login_and_access_kasir_dashboard(): void
    {
        $kasir = User::where('role', 'kasir')->first();
        $response = $this->actingAs($kasir)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Kasir Operasional');
    }

    public function test_petani_can_login_and_access_petani_dashboard(): void
    {
        $petani = User::where('role', 'petani')->first();
        $response = $this->actingAs($petani)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Petani');
    }

    public function test_user_can_place_an_order_per_package(): void
    {
        $user = User::where('role', 'user')->first();
        $product = Product::first();

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'product_id' => $product->id,
            'quantity_package' => 1,
            'grind_size' => 'Biji Utuh',
            'recipient_name' => 'Cinta Konsumen',
            'shipping_phone' => '081234567890',
            'shipping_address' => 'Jl. Kopi Harum No. 10',
            'customer_notes' => 'Testing order per paket 1kg',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'recipient_name' => 'Cinta Konsumen',
        ]);
    }
}
