<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\PenjualSeeder;

class PenjualTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PenjualSeeder::class);
    }

    public function testLoginPenjual()
    {
        $user = User::where('email', 'penjual@open_ecommerce')->first();
        $response = $this->actingAs($user)->get(route('penjual-lihat'));
        $response->assertStatus(200);
        $response->assertSeeText('Lihat Barang');
    }

    public function testVisitAkun()
    {
        $user = User::where('email', 'penjual@open_ecommerce')->first();
        $response = $this->actingAs($user)->get(route('penjual-profil'));
        $response->assertStatus(200);
        $response->assertSeeText('Akun');
        $response->assertSeeText('email');
    }
}
