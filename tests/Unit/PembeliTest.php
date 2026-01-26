<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\PembeliSeeder;

class PembeliTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PembeliSeeder::class);
    }

    public function testLoginPembeli()
    {
        $user = User::where('email', 'pembeli@open_ecommerce')->first();
        $response = $this->actingAs($user)->get(route('beranda'));
        $response->assertStatus(200);
        $response->assertSeeText('Troli');
    }
    
    public function testVisitAkun()
    {
        $user = User::where('email', 'pembeli@open_ecommerce')->first();
        $response = $this->actingAs($user)->get(route('pembeli-profil'));
        $response->assertStatus(200);
        $response->assertSeeText('Profil');
        $response->assertSeeText('email');
    }
}
